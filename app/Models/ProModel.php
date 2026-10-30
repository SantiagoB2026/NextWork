<?php

namespace App\Models;
use CodeIgniter\Model;

class ProModel extends Model {
    protected $table         = 'Proyectos';
    protected $primaryKey    = 'id_Proyecto';
    protected $returnType    = 'array';
    protected $allowedFields = ['autor', 'titulo', 'descripcion', 'etiqueta', 'fecha_publicacion','dinero_a_conseguir'];
    protected $useTimestamps = true;
   
};
