<?php

namespace App\Libraries;

use App\Models\ColaboradorModel;
use App\Models\DonacionModel;

/**
 * Qué relación tiene la persona que está navegando con un proyecto,
 * y si tiene permiso para verlo (los proyectos que llegaron a su meta se ocultan al público).
 */
class AccesoProyecto
{
    public static function de(array $proyecto): array
    {
        $tipo = session()->get('isLoggedIn') ? session()->get('tipo') : null;
        $yo   = (int) session()->get('id');
        $id   = (int) $proyecto['id_proyecto'];

        $esDueno       = $tipo === 'desarrollador' && (int) ($proyecto['id_usuario'] ?? 0) === $yo;
        $esColaborador = $tipo === 'desarrollador' && ! $esDueno && (new ColaboradorModel())->esColaborador($id, $yo);
        $esEquipo      = $esDueno || $esColaborador;
        $esDonante     = $tipo === 'inversionista' && (new DonacionModel())->totalDeUsuarioEnProyecto($yo, $id) > 0;
        $financiado    = ! empty($proyecto['financiado_at']);

        return [
            'tipo'          => $tipo,
            'yo'            => $yo,
            'esDueno'       => $esDueno,
            'esColaborador' => $esColaborador,
            'esEquipo'      => $esEquipo,
            'esDonante'     => $esDonante,
            'financiado'    => $financiado,
            // Si llegó a la meta, solo lo ven su equipo, quienes donaron y el administrador
            'puedeVer'      => ! $financiado || $esEquipo || $esDonante || $tipo === 'admin',
        ];
    }
}
