<?php

namespace App\Models;

use CodeIgniter\Model;

class EtiquetaModel extends Model
{
    protected $table            = 'Etiquetas';
    protected $primaryKey       = 'id_etiqueta';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields    = ['nombre', 'slug'];

    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[30]|is_unique[Etiquetas.nombre,id_etiqueta,{id_etiqueta}]',
    ];
    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre de la etiqueta es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 2 caracteres.',
            'max_length' => 'El nombre no puede superar los 30 caracteres.',
            'is_unique'  => 'Ya existe una etiqueta con ese nombre.',
        ],
    ];

    // El slug (para la URL) se genera solo a partir del nombre
    protected $beforeInsert = ['generarSlug'];
    protected $beforeUpdate = ['generarSlug'];

    protected function generarSlug(array $data): array
    {
        if (isset($data['data']['nombre'])) {
            $data['data']['slug'] = self::crearSlug($data['data']['nombre']);
        }
        return $data;
    }

    /** "Impacto social" -> "impacto-social", "Música" -> "musica" */
    public static function crearSlug(string $texto): string
    {
        $texto = mb_strtolower(trim($texto), 'UTF-8');
        $texto = strtr($texto, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n',
        ]);
        $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);

        return trim($texto, '-');
    }

    public function porSlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->first();
    }

    /** Todas las etiquetas con la cantidad de proyectos que tiene cada una */
    public function todasConConteo(): array
    {
        return $this->select('Etiquetas.*, COUNT(p.id_proyecto) AS total_proyectos')
            ->join('ProyectoEtiqueta pe', 'pe.id_etiqueta = Etiquetas.id_etiqueta', 'left')
            ->join('Proyectos p', 'p.id_proyecto = pe.id_proyecto AND p.financiado_at IS NULL', 'left')
            ->groupBy('Etiquetas.id_etiqueta')
            ->orderBy('Etiquetas.nombre')
            ->findAll();
    }

    /** Etiquetas de UN proyecto */
    public function deProyecto(int $idProyecto): array
    {
        return $this->select('Etiquetas.*')
            ->join('ProyectoEtiqueta pe', 'pe.id_etiqueta = Etiquetas.id_etiqueta')
            ->where('pe.id_proyecto', $idProyecto)
            ->orderBy('Etiquetas.nombre')
            ->findAll();
    }

    /** Etiquetas de VARIOS proyectos en una sola consulta: [id_proyecto => [etiquetas...]] */
    public function agruparPorProyecto(array $idsProyectos): array
    {
        if (empty($idsProyectos)) {
            return [];
        }

        $filas = $this->db->table('ProyectoEtiqueta pe')
            ->select('pe.id_proyecto, e.id_etiqueta, e.nombre, e.slug')
            ->join('Etiquetas e', 'e.id_etiqueta = pe.id_etiqueta')
            ->whereIn('pe.id_proyecto', $idsProyectos)
            ->orderBy('e.nombre')
            ->get()
            ->getResultArray();

        $mapa = [];
        foreach ($filas as $fila) {
            $mapa[$fila['id_proyecto']][] = $fila;
        }
        return $mapa;
    }

    /** Reemplaza las etiquetas de un proyecto por las indicadas (ignora ids que no existan) */
    public function sincronizar(int $idProyecto, array $idsEtiquetas): void
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $idsEtiquetas))));

        $validos = [];
        if (! empty($ids)) {
            $validos = array_column(
                $this->select('id_etiqueta')->whereIn('id_etiqueta', $ids)->findAll(),
                'id_etiqueta'
            );
        }

        $this->db->table('ProyectoEtiqueta')->where('id_proyecto', $idProyecto)->delete();

        if (! empty($validos)) {
            $filas = array_map(
                static fn ($id) => ['id_proyecto' => $idProyecto, 'id_etiqueta' => (int) $id],
                $validos
            );
            $this->db->table('ProyectoEtiqueta')->insertBatch($filas);
        }
    }
}
