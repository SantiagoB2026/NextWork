<?php

namespace App\Models;

use CodeIgniter\Model;

class CalificacionModel extends Model
{
    protected $table            = 'Calificaciones';
    protected $primaryKey       = 'id_proyecto';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_proyecto', 'id_usuario', 'puntaje'];

    /** Puntaje que dio un usuario a un proyecto (0 si todavía no calificó) */
    public function de(int $idProyecto, int $idUsuario): int
    {
        $fila = $this->db->table('Calificaciones')
            ->select('puntaje')
            ->where('id_proyecto', $idProyecto)
            ->where('id_usuario', $idUsuario)
            ->get()
            ->getRowArray();

        return $fila ? (int) $fila['puntaje'] : 0;
    }

    /** Guarda la calificación; si ya había una, la reemplaza */
    public function guardar(int $idProyecto, int $idUsuario, int $puntaje): void
    {
        $tabla = $this->db->prefixTable('Calificaciones');
        $ahora = date('Y-m-d H:i:s');

        $this->db->query(
            "INSERT INTO {$tabla} (id_proyecto, id_usuario, puntaje, created_at, updated_at)
             VALUES (?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE puntaje = VALUES(puntaje), updated_at = VALUES(updated_at)",
            [$idProyecto, $idUsuario, $puntaje, $ahora, $ahora]
        );
    }

    /** [id_proyecto => ['promedio' => 4.3, 'total' => 12]] para varios proyectos en una consulta */
    public function resumenPorProyecto(array $idsProyectos): array
    {
        if (empty($idsProyectos)) {
            return [];
        }

        $filas = $this->db->table('Calificaciones')
            ->select('id_proyecto, AVG(puntaje) AS promedio, COUNT(*) AS total')
            ->whereIn('id_proyecto', $idsProyectos)
            ->groupBy('id_proyecto')
            ->get()
            ->getResultArray();

        $mapa = [];
        foreach ($filas as $fila) {
            $mapa[$fila['id_proyecto']] = [
                'promedio' => round((float) $fila['promedio'], 1),
                'total'    => (int) $fila['total'],
            ];
        }
        return $mapa;
    }
}
