<?php

namespace App\Models;
use CodeIgniter\Model;

class DeveloperModel extends UserModel {
    protected $table         = 'Desarrollador';
    protected $primaryKey    = 'id_desarrollador';
    protected $returnType    = 'array';
    protected $allowedFields = ['calificacion', 'preferencias'];
    protected $useTimestamps = true;
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