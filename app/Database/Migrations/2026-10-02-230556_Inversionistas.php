<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Inversionistas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_inversionista' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true, // CORREGIDO: El autoincremento va en la llave primaria real
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
            'id_usuario' => [
                'type'     => 'INT',
                'unsigned' => true, // CORREGIDO: Se eliminó el auto_increment de aquí
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

        // Definimos la Clave Primaria
        $this->forge->addKey('id_inversionista', true);

        // CORREGIDO: Cambiado 'id' por 'id_usuario' como tercer parámetro
        $this->forge->addForeignKey('id_usuario', 'Usuario', 'id_usuario', 'CASCADE', 'CASCADE');

        // Creamos la tabla física
        $this->forge->createTable('Inversionistas');
    }

    public function down()
    {
        $this->forge->dropTable('Inversionistas');
    }
}
