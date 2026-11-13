<?php

namespace App\Models;

use CodeIgniter\Model;

class ComentarioModel extends Model
{
    protected $table            = 'Comentarios';
    protected $primaryKey       = 'id_comentario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields    = ['id_proyecto', 'id_usuario', 'texto'];

    /** Comentarios de un proyecto, los más nuevos primero, con alias y tipo de quien comentó */
    public function deProyecto(int $idProyecto, int $limite = 100): array
    {
        return $this->select('Comentarios.*, u.alias, u.tipo')
            ->join('Usuario u', 'u.id_usuario = Comentarios.id_usuario', 'left')
            ->where('Comentarios.id_proyecto', $idProyecto)
            ->orderBy('Comentarios.id_comentario', 'DESC')
            ->findAll($limite);
    }
}
