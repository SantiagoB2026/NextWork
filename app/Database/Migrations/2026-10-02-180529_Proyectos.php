<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Proyectos extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'id_proyecto'    =>['type' => 'INT','unsigned' => true, 'auto_increment' => true],
        'autor' => ['type' => 'VARCHAR', 'constraint' => 15,'null' => false],
        'descripcion' => ['type' => 'VARCHAR', 'constraint' => 500],
        'etiqueta' => ['type' => 'VARCHAR', 'constraint' => 15],
        'fecha_publicacion' => ['type' => 'DATE','null' => false],
        'created_at' => ['type' => 'DATETIME', 'null' => true],
        'updated_at' => ['type' => 'DATETIME', 'null' => true],

    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('Proyectos');
    }

    public function down()
    {
    $this->forge->dropTable('Proyectos');
    }
}
?>
