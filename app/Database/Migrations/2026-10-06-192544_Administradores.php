<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Administradores extends Migration
{
    public function up()
    {
        $camposPadre = $this->getCamposBase();
        
        $camposEspecificos = [
            'rol'              => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Usuario', 'null' => false],
            'nivel_acceso'     => ['type' => 'INT', 'constraint' => 11, 'default' => 1, 'null' => false],
        ];

        $todosLosCampos = array_merge($camposPadre, $camposEspecificos);

        $this->forge->addKey('id', true);
        $this->forge->createTable('Administradores');
    }

    public function down()
    {
        $this->forge->dropTable('Administradores');
    }
}
