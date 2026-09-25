<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usuarios extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'id'    =>['type' => 'INT','unsigned' => true, 'auto_increment' => true],
        'alias' => ['type' => 'VARCHAR', 'constraint' => 15,'null' => false],
        'nombre' => ['type' => 'VARCHAR', 'constraint' => 50],
        'apellido' => ['type' => 'VARCHAR', 'constraint' => 50],
        'contraseña' => ['type' => 'VARCHAR', 'constraint' => 100,'null' => false],
        'correo_electronico' => ['type' => 'VARCHAR','constraint' =>100, 'null' => false],
        'fecha_nacimiento' => ['type' => 'DATE','null' => false],
        'created_at' => ['type' => 'DATETIME', 'null' => true],
        'updated_at' => ['type' => 'DATETIME', 'null' => true],

    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('Usuario');
    }

    public function down()
    {
    $this->forge->dropTable('Usuario');
    }
}
?>
