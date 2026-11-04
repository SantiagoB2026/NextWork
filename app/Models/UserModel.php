<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table         = 'Usuario';
    protected $primaryKey    = 'id_usuario';
    protected $returnType    = 'array';
    
    // Agregada 'foto_perfil' a los campos permitidos
    protected $allowedFields = ['alias', 'nombre', 'apellido', 'contraseña', 'tipo', 'correo_electronico', 'fecha_nacimiento', 'foto_perfil'];
    
    protected $validationMessages = [
        'alias' => [
            'is_unique' => 'Este nombre de usuario (alias) ya está registrado.'
        ],
        'correo_electronico' => [
            'is_unique' => 'Este correo electrónico ya se encuentra en uso.'
        ],
        'contraseña' => [
            'required'  => 'La contraseña es obligatoria.'
        ]
    ];
}