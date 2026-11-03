<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyectoModel extends Model
{
    protected $table            = 'Proyectos';
    protected $primaryKey       = 'id_proyecto';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Habilitar los timestamps automáticos si los definiste en la migración
    protected $useTimestamps    = true; 
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Campos que el formulario tiene permitido llenar en la BD
    protected $allowedFields    = [
        'titulo', 
        'autor', 
        'descripcion', 
        'dinero_conseguir', 
        'etiqueta', 
        'fecha_publicacion'
    ];
}
