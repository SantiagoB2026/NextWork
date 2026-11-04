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
}
