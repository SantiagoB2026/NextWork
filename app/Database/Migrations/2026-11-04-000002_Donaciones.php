<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Donaciones extends Migration
{
    public function up()
    {
        // 1) Cada donación: quién, a qué proyecto y cuánto
        $this->forge->addField([
            'id_donacion' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_proyecto' => ['type' => 'INT', 'unsigned' => true],
            'id_usuario'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'monto'       => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_donacion', true);
        $this->forge->addKey('id_proyecto');
        $this->forge->addKey('id_usuario');
        // Si se borra el proyecto se borran sus donaciones; si se borra el usuario, la donación se conserva
        $this->forge->addForeignKey('id_proyecto', 'Proyectos', 'id_proyecto', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_usuario', 'Usuario', 'id_usuario', 'CASCADE', 'SET NULL');
        $this->forge->createTable('Donaciones');

        // 2) Dueño del proyecto (hasta ahora solo se guardaba el alias en texto)
        $this->forge->addColumn('Proyectos', [
            'id_usuario' => ['type' => 'INT', 'unsigned' => true, 'null' => true, 'after' => 'id_proyecto'],
        ]);

        $proyectos = $this->db->prefixTable('Proyectos');
        $usuarios  = $this->db->prefixTable('Usuario');

        // Proyectos ya creados: se asignan al usuario cuyo alias coincide con "autor"
        $this->db->query("UPDATE {$proyectos} p INNER JOIN {$usuarios} u ON u.alias = p.autor SET p.id_usuario = u.id_usuario WHERE p.id_usuario IS NULL");
        $this->db->query("ALTER TABLE {$proyectos} ADD CONSTRAINT fk_proyectos_usuario FOREIGN KEY (id_usuario) REFERENCES {$usuarios} (id_usuario) ON UPDATE CASCADE ON DELETE SET NULL");

        // 3) El título estaba limitado a 15 caracteres
        $this->forge->modifyColumn('Proyectos', [
            'titulo' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
        ]);
    }

    public function down()
    {
        $proyectos = $this->db->prefixTable('Proyectos');
        $this->db->query("ALTER TABLE {$proyectos} DROP FOREIGN KEY fk_proyectos_usuario");
        $this->forge->dropColumn('Proyectos', 'id_usuario');
        $this->forge->dropTable('Donaciones', true);
        // El título se deja en 100 para no cortar textos ya guardados
    }
}
