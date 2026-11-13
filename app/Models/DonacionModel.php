<?php

namespace App\Models;

use CodeIgniter\Model;

class DonacionModel extends Model
{
    protected $table            = 'Donaciones';
    protected $primaryKey       = 'id_donacion';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields    = ['id_proyecto', 'id_usuario', 'monto'];

    /** Últimos aportes de un proyecto, con el alias de quien donó */
    public function recientesDeProyecto(int $idProyecto, int $limite = 10): array
    {
        return $this->select('Donaciones.monto, Donaciones.created_at, u.alias')
            ->join('Usuario u', 'u.id_usuario = Donaciones.id_usuario', 'left')
            ->where('Donaciones.id_proyecto', $idProyecto)
            ->orderBy('Donaciones.created_at', 'DESC')
            ->orderBy('Donaciones.id_donacion', 'DESC')
            ->findAll($limite);
    }

    /** Cuánto lleva aportado un inversionista a un proyecto */
    public function totalDeUsuarioEnProyecto(int $idUsuario, int $idProyecto): float
    {
        $fila = $this->selectSum('monto', 'total')
            ->where('id_usuario', $idUsuario)
            ->where('id_proyecto', $idProyecto)
            ->first();

        return (float) ($fila['total'] ?? 0);
    }

    /** Proyectos a los que aportó un inversionista, con el total aportado a cada uno */
    public function resumenDeUsuario(int $idUsuario): array
    {
        return $this->select('p.id_proyecto, p.titulo, p.autor, p.dinero_conseguir, SUM(Donaciones.monto) AS mi_aporte, COUNT(*) AS veces, MAX(Donaciones.created_at) AS ultimo')
            ->join('Proyectos p', 'p.id_proyecto = Donaciones.id_proyecto')
            ->where('Donaciones.id_usuario', $idUsuario)
            ->groupBy('p.id_proyecto')
            ->orderBy('ultimo', 'DESC')
            ->findAll();
    }

    /** Dinero que recibieron en total los proyectos creados por un desarrollador */
    public function totalRecaudadoPor(int $idDesarrollador): float
    {
        $fila = $this->db->table('Donaciones d')
            ->selectSum('d.monto', 'total')
            ->join('Proyectos p', 'p.id_proyecto = d.id_proyecto')
            ->where('p.id_usuario', $idDesarrollador)
            ->get()
            ->getRowArray();

        return (float) ($fila['total'] ?? 0);
    }
}
