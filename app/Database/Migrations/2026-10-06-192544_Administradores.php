<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Administradores extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_administrador' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true, // CORREGIDO: El autoincremento va en el ID de esta tabla
            ],
            'nivel_permiso' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'moderador',
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

        // CORREGIDO: Cambiado 'id_inversionista' por 'id_administrador'
        $this->forge->addKey('id_administrador', true);

        // CORREGIDO: Cambiado el destino 'id' por 'id_usuario'
        $this->forge->addForeignKey('id_usuario', 'Usuario', 'id_usuario', 'CASCADE', 'CASCADE');

        // Creamos la tabla definitiva
        $this->forge->createTable('Administradores');
    }

    public function down()
    {
        $this->forge->dropTable('Administradores');
    }
}
