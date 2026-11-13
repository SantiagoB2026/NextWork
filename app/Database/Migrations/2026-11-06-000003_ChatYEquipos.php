<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChatYEquipos extends Migration
{
    public function up()
    {
        // 1) Mensajes directos entre dos usuarios (chat 1 a 1)
        $this->forge->addField([
            'id_mensaje'  => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_emisor'   => ['type' => 'INT', 'unsigned' => true],
            'id_receptor' => ['type' => 'INT', 'unsigned' => true],
            'texto'       => ['type' => 'VARCHAR', 'constraint' => 500],
            'leido_at'    => ['type' => 'DATETIME', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_mensaje', true);
        $this->forge->addKey(['id_emisor', 'id_receptor']);
        $this->forge->addKey(['id_receptor', 'leido_at']);
        $this->forge->addForeignKey('id_emisor', 'Usuario', 'id_usuario', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_receptor', 'Usuario', 'id_usuario', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Mensajes');

        // 2) Equipo de un proyecto conjunto: el creador invita, el invitado acepta o rechaza
        $this->forge->addField([
            'id_proyecto' => ['type' => 'INT', 'unsigned' => true],
            'id_usuario'  => ['type' => 'INT', 'unsigned' => true],
            'estado'      => ['type' => 'ENUM', 'constraint' => ['pendiente', 'aceptado'], 'default' => 'pendiente'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['id_proyecto', 'id_usuario'], true);
        $this->forge->addKey('id_usuario');
        $this->forge->addForeignKey('id_proyecto', 'Proyectos', 'id_proyecto', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_usuario', 'Usuario', 'id_usuario', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ProyectoColaboradores');
    }

    public function down()
    {
        $this->forge->dropTable('ProyectoColaboradores', true);
        $this->forge->dropTable('Mensajes', true);
    }
}
