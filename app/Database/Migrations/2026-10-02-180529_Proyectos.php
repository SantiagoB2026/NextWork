<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Proyectos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_proyecto'       => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'titulo'            => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'autor'             => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => false],
            'descripcion'       => ['type' => 'VARCHAR', 'constraint' => 500],
            'dinero_conseguir'  => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => false],
            'etiqueta'          => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
            'fecha_publicacion' => ['type' => 'DATE', 'null' => false],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_proyecto', true);
        $this->forge->createTable('Proyectos');
    }

    // ¡Faltaba esta función obligatoria!
    public function down()
    {
        $this->forge->dropTable('Proyectos', true);
    }
}
