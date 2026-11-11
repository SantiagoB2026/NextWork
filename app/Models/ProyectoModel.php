<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyectoModel extends Model
{
    protected $table            = 'Proyectos';
    protected $primaryKey       = 'id_proyecto';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Ya no existe 'etiqueta': ahora las etiquetas viven en su propia entidad
    protected $allowedFields    = [
        'id_usuario',
        'titulo',
        'autor',
        'descripcion',
        'dinero_conseguir',
        'fecha_publicacion',
    ];

    /** Proyectos que tienen una etiqueta concreta */
    public function porEtiqueta(int $idEtiqueta): array
    {
        return $this->select('Proyectos.*')
            ->join('ProyectoEtiqueta pe', 'pe.id_proyecto = Proyectos.id_proyecto')
            ->where('pe.id_etiqueta', $idEtiqueta)
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
            ->groupStart()
                ->like('Proyectos.titulo', $keyword)
                ->orLike('Proyectos.descripcion', $keyword)
                ->orLike('e.nombre', $keyword)
            ->groupEnd()
            ->findAll();
    }

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

    /** Proyectos de un desarrollador (los más nuevos primero) */
    public function delUsuario(int $idUsuario): array
    {
        return $this->where('id_usuario', $idUsuario)
            ->orderBy('fecha_publicacion', 'DESC')
            ->orderBy('id_proyecto', 'DESC')
            ->findAll();
    }

    /** Proyectos destacados: los que más dinero llevan recaudado (si hay empate, los más nuevos) */
    public function destacados(int $limite = 6): array
    {
        return $this->select('Proyectos.*')
            ->join('Donaciones d', 'd.id_proyecto = Proyectos.id_proyecto', 'left')
            ->groupBy('Proyectos.id_proyecto')
            ->orderBy('COALESCE(SUM(d.monto), 0)', 'DESC', false)
            ->orderBy('Proyectos.fecha_publicacion', 'DESC')
            ->findAll($limite);
    }

    /**
     * Agrega a cada proyecto: recaudado, total_donaciones, donantes y porcentaje
     * (porcentaje real: puede pasar de 100 si se supera la meta)
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

        foreach ($proyectos as &$proyecto) {
            $fila = $totales[$proyecto['id_proyecto']] ?? null;

            $proyecto['recaudado']        = $fila ? (float) $fila['recaudado'] : 0.0;
            $proyecto['total_donaciones'] = $fila ? (int) $fila['total_donaciones'] : 0;
            $proyecto['donantes']         = $fila ? (int) $fila['donantes'] : 0;

            $meta = (float) $proyecto['dinero_conseguir'];
            $proyecto['porcentaje'] = $meta > 0 ? round($proyecto['recaudado'] / $meta * 100, 1) : 0.0;
        }
        unset($proyecto);

        return $proyectos;
    }
}
