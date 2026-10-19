<?php

namespace App\Models;
use CodeIgniter\Model;

class ProModel extends Model{
   protected $table = 'Proyectos';
 protected $primaryKey = 'id_Proyecto';
 protected $returnType = 'array';
 protected $allowedFields = ['autor', 'descripcion', 'etiqueta', 'fecha_publicacion'];
 protected $useTimestamps = true;
 protected $validationRules = ['autor' => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
                               'descripcion' => 'required|alpha_space|max_length[250]',
                               'etiqueta' => 'required|alpha_space|max_length[25]',
                                'fecha_publicacion' => 'required|valid_date'
 ];
}
