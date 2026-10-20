<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table         = 'Usuario';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['alias', 'nombre', 'apellido', 'contraseña', 'tipo', 'correo_electronico', 'fecha_nacimiento'];
    protected $useTimestamps = true;
    protected $validationRules = [
        'alias'              => 'required|alpha_numeric_space|min_length[3]|max_length[100]|is_unique[Usuario.alias]',
        'nombre'             => 'required|max_length[50]',
        'apellido'           => 'required|max_length[50]',
        'tipo'               => 'required|in_list[inversionista,desarrollador]',
        'correo_electronico' => 'required|valid_email|is_unique[Usuario.correo_electronico]',
        'fecha_nacimiento'   => 'required|valid_date',
        'contraseña'         => 'required' 
    ];
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