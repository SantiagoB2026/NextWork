<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyectoModel extends Model
{
    /** Máximo de proyectos por desarrollador */
    public const MAX_POR_DESARROLLADOR = 3;

    /**
     * true  = cuentan solo los proyectos que todavía no llegaron a su meta
     *         (al llegar a la meta se libera un lugar para crear otro)
     * false = cuentan todos los proyectos que el desarrollador creó alguna vez
     */
    public const CONTAR_SOLO_ACTIVOS = true;

    protected $table            = 'Proyectos';
    protected $primaryKey       = 'id_proyecto';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields    = [
        'id_usuario',
        'titulo',
        'autor',
        'descripcion',
        'dinero_conseguir',
        'financiado_at',
        'fecha_publicacion',
    ];

    // ---------- LISTADOS PÚBLICOS (nunca incluyen proyectos que llegaron a su meta) ----------

    /** Proyectos que tienen una etiqueta concreta */
    public function porEtiqueta(int $idEtiqueta): array
    {
        return $this->select('Proyectos.*')
            ->join('ProyectoEtiqueta pe', 'pe.id_proyecto = Proyectos.id_proyecto')
            ->where('pe.id_etiqueta', $idEtiqueta)
            ->where('Proyectos.financiado_at IS NULL', null, false)
            ->orderBy('Proyectos.fecha_publicacion', 'DESC')
            ->findAll();
    }

    /** Búsqueda por título, descripción o nombre de etiqueta */
    public function buscar(string $keyword): array
    {
        return $this->select('Proyectos.*')
            ->distinct()
            ->join('ProyectoEtiqueta pe', 'pe.id_proyecto = Proyectos.id_proyecto', 'left')
            ->join('Etiquetas e', 'e.id_etiqueta = pe.id_etiqueta', 'left')
            ->where('Proyectos.financiado_at IS NULL', null, false)
            ->groupStart()
                ->like('Proyectos.titulo', $keyword)
                ->orLike('Proyectos.descripcion', $keyword)
                ->orLike('e.nombre', $keyword)
            ->groupEnd()
            ->findAll();
    }

    /** Proyectos destacados: los que más dinero llevan recaudado (si hay empate, los más nuevos) */
    public function destacados(int $limite = 6): array
    {
        return $this->select('Proyectos.*')
            ->join('Donaciones d', 'd.id_proyecto = Proyectos.id_proyecto', 'left')
            ->where('Proyectos.financiado_at IS NULL', null, false)
            ->groupBy('Proyectos.id_proyecto')
            ->orderBy('COALESCE(SUM(d.monto), 0)', 'DESC', false)
            ->orderBy('Proyectos.fecha_publicacion', 'DESC')
            ->findAll($limite);
    }

    // ---------- LISTADOS PERSONALES ----------

    /** Proyectos de un desarrollador: los que creó y aquellos donde es colaborador (más nuevos primero) */
    public function delUsuario(int $idUsuario): array
    {
        $idUsuario = (int) $idUsuario;

        return $this->groupStart()
                ->where('id_usuario', $idUsuario)
                ->orWhere(
                    "id_proyecto IN (SELECT id_proyecto FROM ProyectoColaboradores WHERE id_usuario = {$idUsuario} AND estado = 'aceptado')",
                    null,
                    false
                )
            ->groupEnd()
            ->orderBy('fecha_publicacion', 'DESC')
            ->orderBy('id_proyecto', 'DESC')
            ->findAll();
    }

    /** Proyectos que creó un desarrollador (para su perfil). Los que llegaron a su meta solo se incluyen si se pide */
    public function delCreador(int $idUsuario, bool $incluirFinanciados = false): array
    {
        $this->where('id_usuario', $idUsuario);

        if (! $incluirFinanciados) {
            $this->where('financiado_at IS NULL', null, false);
        }

        return $this->orderBy('fecha_publicacion', 'DESC')->orderBy('id_proyecto', 'DESC')->findAll();
    }

    public function porIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        return $this->whereIn('id_proyecto', $ids)->orderBy('fecha_publicacion', 'DESC')->findAll();
    }

    // ---------- LÍMITE DE PROYECTOS POR DESARROLLADOR ----------

    public function contarCreados(int $idUsuario): int
    {
        $this->where('id_usuario', $idUsuario);

        if (self::CONTAR_SOLO_ACTIVOS) {
            $this->where('financiado_at IS NULL', null, false);
        }

        return (int) $this->countAllResults();
    }

    public function alcanzoLimite(int $idUsuario): bool
    {
        return $this->contarCreados($idUsuario) >= self::MAX_POR_DESARROLLADOR;
    }

    // ---------- DATOS EXTRA PARA MOSTRAR ----------

    /** Agrega a cada proyecto la clave 'etiquetas' (lista de sus etiquetas) */
    public function conEtiquetas(array $proyectos): array
    {
        $mapa = (new EtiquetaModel())->agruparPorProyecto(array_column($proyectos, 'id_proyecto'));

        foreach ($proyectos as &$proyecto) {
            $proyecto['etiquetas'] = $mapa[$proyecto['id_proyecto']] ?? [];
        }
        unset($proyecto);

        return $proyectos;
    }

    /**
     * Agrega a cada proyecto lo necesario para dibujar su tarjeta:
     *  - recaudado, total_donaciones, donantes y porcentaje (real: puede pasar de 100)
     *  - calificacion (promedio), total_calificaciones
     *  - portada (archivo de la primera imagen, o null)
     */
    public function conProgreso(array $proyectos): array
    {
        $ids     = array_column($proyectos, 'id_proyecto');
        $totales = [];

        if (! empty($ids)) {
            $filas = $this->db->table('Donaciones')
                ->select('id_proyecto, SUM(monto) AS recaudado, COUNT(*) AS total_donaciones, COUNT(DISTINCT id_usuario) AS donantes')
                ->whereIn('id_proyecto', $ids)
                ->groupBy('id_proyecto')
                ->get()
                ->getResultArray();

            foreach ($filas as $fila) {
                $totales[$fila['id_proyecto']] = $fila;
            }
        }

        $calificaciones = (new CalificacionModel())->resumenPorProyecto($ids);
        $portadas       = (new ImagenModel())->portadas($ids);

        foreach ($proyectos as &$proyecto) {
            $id   = $proyecto['id_proyecto'];
            $fila = $totales[$id] ?? null;

            $proyecto['recaudado']            = $fila ? (float) $fila['recaudado'] : 0.0;
            $proyecto['total_donaciones']     = $fila ? (int) $fila['total_donaciones'] : 0;
            $proyecto['donantes']             = $fila ? (int) $fila['donantes'] : 0;
            $proyecto['calificacion']         = $calificaciones[$id]['promedio'] ?? 0.0;
            $proyecto['total_calificaciones'] = $calificaciones[$id]['total'] ?? 0;
            $proyecto['portada']              = $portadas[$id] ?? null;

            $meta = (float) $proyecto['dinero_conseguir'];
            $proyecto['porcentaje'] = $meta > 0 ? round($proyecto['recaudado'] / $meta * 100, 1) : 0.0;
        }
        unset($proyecto);

        return $proyectos;
    }
}
