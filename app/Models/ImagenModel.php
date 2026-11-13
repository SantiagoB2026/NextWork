<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagenModel extends Model
{
    protected $table            = 'ProyectoImagenes';
    protected $primaryKey       = 'id_imagen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields    = ['id_proyecto', 'archivo'];

    public function deProyecto(int $idProyecto): array
    {
        return $this->where('id_proyecto', $idProyecto)->orderBy('id_imagen', 'ASC')->findAll();
    }

    public function contar(int $idProyecto): int
    {
        return (int) $this->where('id_proyecto', $idProyecto)->countAllResults();
    }

    /** [id_proyecto => archivo de la portada (la primera imagen)] para varios proyectos */
    public function portadas(array $idsProyectos): array
    {
        if (empty($idsProyectos)) {
            return [];
        }

        $primeras = $this->db->table('ProyectoImagenes')
            ->select('MIN(id_imagen)')
            ->whereIn('id_proyecto', $idsProyectos)
            ->groupBy('id_proyecto')
            ->getCompiledSelect();

        $filas = $this->db->table('ProyectoImagenes')
            ->select('id_proyecto, archivo')
            ->where("id_imagen IN ({$primeras})", null, false)
            ->get()
            ->getResultArray();

        return array_column($filas, 'archivo', 'id_proyecto');
    }
}
