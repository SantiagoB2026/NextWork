<?php

namespace App\Models;

use CodeIgniter\Model;

class ColaboradorModel extends Model
{
    protected $table            = 'ProyectoColaboradores';
    protected $primaryKey       = 'id_proyecto';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_proyecto', 'id_usuario', 'estado'];

    private function tabla()
    {
        return $this->db->table('ProyectoColaboradores');
    }

    /** Fila de la invitación/colaboración de un usuario en un proyecto (o null) */
    public function existe(int $idProyecto, int $idUsuario): ?array
    {
        $fila = $this->tabla()
            ->where('id_proyecto', $idProyecto)
            ->where('id_usuario', $idUsuario)
            ->get()
            ->getRowArray();

        return $fila ?: null;
    }

    public function esColaborador(int $idProyecto, int $idUsuario): bool
    {
        $fila = $this->existe($idProyecto, $idUsuario);

        return $fila !== null && $fila['estado'] === 'aceptado';
    }

    public function invitar(int $idProyecto, int $idUsuario): bool
    {
        $ahora = date('Y-m-d H:i:s');

        return (bool) $this->tabla()->insert([
            'id_proyecto' => $idProyecto,
            'id_usuario'  => $idUsuario,
            'estado'      => 'pendiente',
            'created_at'  => $ahora,
            'updated_at'  => $ahora,
        ]);
    }

    /** Aceptar la deja como colaboración; rechazar borra la invitación */
    public function responder(int $idProyecto, int $idUsuario, bool $aceptar): void
    {
        $consulta = $this->tabla()->where('id_proyecto', $idProyecto)->where('id_usuario', $idUsuario);

        if ($aceptar) {
            $consulta->update(['estado' => 'aceptado', 'updated_at' => date('Y-m-d H:i:s')]);
        } else {
            $consulta->delete();
        }
    }

    /** Desarrolladores que ya forman parte del equipo de un proyecto */
    public function equipo(int $idProyecto): array
    {
        return $this->tabla()
            ->select('u.id_usuario, u.alias')
            ->join('Usuario u', 'u.id_usuario = ProyectoColaboradores.id_usuario')
            ->where('ProyectoColaboradores.id_proyecto', $idProyecto)
            ->where('ProyectoColaboradores.estado', 'aceptado')
            ->orderBy('u.alias')
            ->get()
            ->getResultArray();
    }

    /** Invitaciones enviadas que todavía no respondieron */
    public function invitadosPendientes(int $idProyecto): array
    {
        return $this->tabla()
            ->select('u.id_usuario, u.alias')
            ->join('Usuario u', 'u.id_usuario = ProyectoColaboradores.id_usuario')
            ->where('ProyectoColaboradores.id_proyecto', $idProyecto)
            ->where('ProyectoColaboradores.estado', 'pendiente')
            ->orderBy('u.alias')
            ->get()
            ->getResultArray();
    }

    /** Invitaciones que recibió un desarrollador y aún no respondió */
    public function pendientesDe(int $idUsuario): array
    {
        return $this->tabla()
            ->select('p.id_proyecto, p.titulo, u.alias AS invitador')
            ->join('Proyectos p', 'p.id_proyecto = ProyectoColaboradores.id_proyecto')
            ->join('Usuario u', 'u.id_usuario = p.id_usuario', 'left')
            ->where('ProyectoColaboradores.id_usuario', $idUsuario)
            ->where('ProyectoColaboradores.estado', 'pendiente')
            ->orderBy('ProyectoColaboradores.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function contarPendientes(int $idUsuario): int
    {
        return (int) $this->tabla()
            ->where('id_usuario', $idUsuario)
            ->where('estado', 'pendiente')
            ->countAllResults();
    }
}
