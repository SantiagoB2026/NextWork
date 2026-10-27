<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table         = 'Usuario';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['alias', 'nombre', 'apellido', 'contraseña', 'tipo', 'correo_electronico', 'fecha_nacimiento'];
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