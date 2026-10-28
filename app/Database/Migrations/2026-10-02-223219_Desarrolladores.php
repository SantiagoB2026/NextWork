<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Creadores extends Migration
{
    public function up()
    {
        $this->forge->addField([
            // Añadimos auto_increment a la verdadera llave primaria de esta tabla
            'id_desarrolador' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'gustos'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'calificacion'    => ['type' => 'DECIMAL', 'constraint' => '3,2', 'default' => 0.00, 'null' => false],
            // Quitamos el auto_increment de aquí, ya que es una llave foránea normal
            'id_usuario'      => ['type' => 'INT', 'unsigned' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true]
        ]);
        
        // Define id_desarrolador como la llave primaria de esta tabla
        $this->forge->addKey('id_desarrolador', true);
        
        // CORREGIDO: Cambiado el tercer parámetro 'id' por 'id_usuario' para que calce con la tabla Usuario
        $this->forge->addForeignKey('id_usuario', 'Usuario', 'id_usuario', 'CASCADE', 'CASCADE');

        $this->forge->createTable('Desarrollador');
    }

    public function down()
    {
        $this->forge->dropTable('Desarrollador');
    }
}

