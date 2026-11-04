<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Etiquetas extends Migration
{
    public function up()
    {
        // 1) Tabla de etiquetas (entidad propia)
        $this->forge->addField([
            'id_etiqueta' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nombre'      => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => false],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 40, 'null' => false],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_etiqueta', true);
        $this->forge->addUniqueKey('nombre');
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('Etiquetas');

        // 2) Tabla pivote: un proyecto puede tener varias etiquetas y viceversa
        $this->forge->addField([
            'id_proyecto' => ['type' => 'INT', 'unsigned' => true],
            'id_etiqueta' => ['type' => 'INT', 'unsigned' => true],
        ]);
        $this->forge->addKey(['id_proyecto', 'id_etiqueta'], true);
        $this->forge->addKey('id_etiqueta');
        $this->forge->addForeignKey('id_proyecto', 'Proyectos', 'id_proyecto', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_etiqueta', 'Etiquetas', 'id_etiqueta', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ProyectoEtiqueta');

        // 3) La columna vieja "etiqueta" (texto suelto) ya no se usa
        if ($this->db->fieldExists('etiqueta', 'Proyectos')) {
            $this->forge->dropColumn('Proyectos', 'etiqueta');
        }
    }

    public function down()
    {
        $this->forge->dropTable('ProyectoEtiqueta', true);
        $this->forge->dropTable('Etiquetas', true);

        $this->forge->addColumn('Proyectos', [
            'etiqueta' => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
        ]);
    }
}
