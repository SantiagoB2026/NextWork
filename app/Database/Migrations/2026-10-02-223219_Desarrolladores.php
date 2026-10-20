<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Creadores extends Migration
{
    public function up()
    {
        
        $this->forge->addField([
        
            'id_usuario' => ['type' => 'INT','constraint' => 11, 'unsigned'   => true],
            'gustos' => ['type' => 'VARCHAR', 'constraint' => 255,'null'       => true],
            'calificacion' => [ 'type' => 'DECIMAL', 'constraint' => '3,2', 'default' => 0.00, 'null' => false],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ]
        ]);
        $this->forge->addKey('id_usuario', true);
        
        $this->forge->addForeignKey('id_usuario', 'Usuario', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('Desarrollador');
    }

    public function down()
    {
        $this->forge->dropTable('Desarrollador');
    }
}
