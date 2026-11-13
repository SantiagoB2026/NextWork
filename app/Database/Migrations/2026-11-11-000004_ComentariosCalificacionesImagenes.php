<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ComentariosCalificacionesImagenes extends Migration
{
    public function up()
    {
        // 1) Comentarios de un proyecto
        $this->forge->addField([
            'id_comentario' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_proyecto'   => ['type' => 'INT', 'unsigned' => true],
            'id_usuario'    => ['type' => 'INT', 'unsigned' => true],
            'texto'         => ['type' => 'VARCHAR', 'constraint' => 500],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_comentario', true);
        $this->forge->addKey(['id_proyecto', 'id_comentario']);
        $this->forge->addKey('id_usuario');
        $this->forge->addForeignKey('id_proyecto', 'Proyectos', 'id_proyecto', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_usuario', 'Usuario', 'id_usuario', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Comentarios');

        // 2) Calificaciones: una por inversionista y proyecto (de 1 a 5 estrellas)
        $this->forge->addField([
            'id_proyecto' => ['type' => 'INT', 'unsigned' => true],
            'id_usuario'  => ['type' => 'INT', 'unsigned' => true],
            'puntaje'     => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['id_proyecto', 'id_usuario'], true);
        $this->forge->addKey('id_usuario');
        $this->forge->addForeignKey('id_proyecto', 'Proyectos', 'id_proyecto', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_usuario', 'Usuario', 'id_usuario', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Calificaciones');

        $calificaciones = $this->db->prefixTable('Calificaciones');
        $this->db->query("ALTER TABLE {$calificaciones} ADD CONSTRAINT chk_calificacion_puntaje CHECK (puntaje BETWEEN 1 AND 5)");

        // 3) Imágenes de un proyecto (la primera es la portada)
        $this->forge->addField([
            'id_imagen'   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_proyecto' => ['type' => 'INT', 'unsigned' => true],
            'archivo'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_imagen', true);
        $this->forge->addKey('id_proyecto');
        $this->forge->addForeignKey('id_proyecto', 'Proyectos', 'id_proyecto', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ProyectoImagenes');

        // 4) Cuándo llegó el proyecto a su meta (mientras sea NULL, el proyecto es público)
        $this->forge->addColumn('Proyectos', [
            'financiado_at' => ['type' => 'DATETIME', 'null' => true, 'after' => 'dinero_conseguir'],
        ]);

        // Proyectos que ya habían llegado a su meta antes de esta actualización
        $proyectos  = $this->db->prefixTable('Proyectos');
        $donaciones = $this->db->prefixTable('Donaciones');
        $this->db->query(
            "UPDATE {$proyectos} p SET p.financiado_at = NOW()
             WHERE p.financiado_at IS NULL AND p.dinero_conseguir > 0
               AND (SELECT COALESCE(SUM(d.monto), 0) FROM {$donaciones} d WHERE d.id_proyecto = p.id_proyecto) >= p.dinero_conseguir"
        );
    }

    public function down()
    {
        $this->forge->dropColumn('Proyectos', 'financiado_at');
        $this->forge->dropTable('ProyectoImagenes', true);
        $this->forge->dropTable('Calificaciones', true);
        $this->forge->dropTable('Comentarios', true);
    }
}
