<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Inversionistas extends Migration
{
    public function up()
    {
        $camposPadre = $this->getCamposBase();
        
        $camposEspecificos = [
            'donacion_total'=> ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00, 'null' => false],
            'dinero_disponible' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00, 'null' => false],
        ];

        $todosLosCampos = array_merge($camposPadre, $camposEspecificos);

        $this->forge->addKey('id', true);
        $this->forge->createTable('Inversionistas');
    }

    public function down()
    {
        $this->forge->dropTable('Inversionistas');
    }
}