<?php

namespace App\Database\Migrations;

class Creadores extends Usuarios
{
    public function up()
    {
        $camposPadre = $this->getCamposBase();
        
        $camposEspecificos = [
            'gustos'=> ['type' => 'VARCHAR','constraint' => 255, 'null' => true],
            'calificacion' => ['type' => 'DECIMAL', 'constraint' => '3,2', 'default' => 0.00, 'null' => false],
        ];

        $todosLosCampos = array_merge($camposPadre, $camposEspecificos);

        $this->forge->addKey('id', true);
        $this->forge->createTable('Creadores');
    }

    public function down()
    {
        $this->forge->dropTable('Creadores');
    }
}
