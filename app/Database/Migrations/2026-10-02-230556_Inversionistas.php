<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Inversionistas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            // Este ID vincula al inversionista con su cuenta en la tabla Usuario
            'id_usuario' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'donacion_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'null'       => false,
            ],
            'dinero_disponible' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
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

        // Definimos la Clave Primaria sobre id_usuario
        $this->forge->addKey('id_usuario', true);

        // Creamos la relación de Clave Foránea con la tabla Usuario
        $this->forge->addForeignKey('id_usuario', 'Usuario', 'id', 'CASCADE', 'CASCADE');

        // Creamos la tabla física
        $this->forge->createTable('Inversionistas');
    }

    public function down()
    {
        $this->forge->dropTable('Inversionistas');
    }
}
