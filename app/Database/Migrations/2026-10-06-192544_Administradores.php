<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Administradores extends Migration
{
    public function up()
    {
        $this->forge->addField([
            // Vinculamos al admin con su cuenta base de Usuario
            'id_usuario' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            // Un campo clásico por si manejan niveles de admin (ej: superadmin, moderador)
            'nivel_permiso' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'moderador',
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Seteamos la Clave Primaria
        $this->forge->addKey('id_usuario', true);

        // Relación directa de Clave Foránea con Usuarios
        $this->forge->addForeignKey('id_usuario', 'Usuario', 'id', 'CASCADE', 'CASCADE');

        // Creamos la tabla definitiva
        $this->forge->createTable('Administradores');
    }

    public function down()
    {
        $this->forge->dropTable('Administradores');
    }
}
