<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model{
   protected $table = 'Usuario';
 protected $primaryKey = 'id';
 protected $returnType = 'array';
 protected $allowedFields = ['alias', 'nombre', 'apellido', 'contraseña' ,'correo_electronico', 'fecha_nacimiento'];
 protected $useTimestamps = true;
 protected $validationRules = ['alias' => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
                               'nombre' => 'required|alpha_space|max_length[50]',
                               'apellido' => 'required|alpha_space|max_length[50]',
                               'contraseña' => 'required|min_length[8]',
                                'correo_electronico' => 'required|valid_email',
                                'fecha_nacimiento' => 'required|valid_date'
 ];
 protected $validationMessages = [
 'contraseña|' => ['required' => 'es necesario agregar al menos un numero.']
 ];
}
