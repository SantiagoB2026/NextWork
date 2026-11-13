<?php
namespace App\Controllers;

use App\Models\DonacionModel;
use App\Models\ProyectoModel;

class Perfil extends BaseController
{
    public function index($id_perfil_visitado = null)
    {
        $session = session();
        $db = \Config\Database::connect();

        // Tu sesión guarda el ID en la clave 'id'
        if ($id_perfil_visitado === null) {
            $id_perfil_visitado = $session->get('id');
        }
        $id_perfil_visitado = (int) $id_perfil_visitado;

        $usuarioDb = $db->table('Usuario')
                        ->where('id_usuario', $id_perfil_visitado)
                        ->get()
                        ->getRowArray();

        // Si por alguna razón la consulta falla, dejamos un plan B para que no rompa
        if (!$usuarioDb) {
            $usuarioDb = [
                'alias'    => 'Sin Alias',
                'nombre'   => $session->get('name') ?? 'Usuario',
                'apellido' => ''
            ];
        }

        $esPropio     = ((int) $session->get('id') === $id_perfil_visitado);
        $tipoVisitado = $usuarioDb['tipo'] ?? null; // el tipo de la cuenta del perfil, no el de quien lo mira

        $proyectoModel   = new ProyectoModel();
        $donaciones      = new DonacionModel();
        $proyectos       = [];
        $stats           = [];
        $limiteAlcanzado = false;

        if ($tipoVisitado === 'desarrollador') {
            // Proyectos creados (quien no es el dueño no ve los que ya llegaron a su meta)
            $proyectos = $proyectoModel->conProgreso(
                $proyectoModel->conEtiquetas($proyectoModel->delCreador($id_perfil_visitado, $esPropio))
            );
            $stats = [
                'publicados' => count($proyectos),
                'fondos'     => $donaciones->totalRecaudadoPor($id_perfil_visitado),
            ];
            $limiteAlcanzado = $esPropio && $proyectoModel->alcanzoLimite($id_perfil_visitado);
        } elseif ($tipoVisitado === 'inversionista' && $esPropio) {
            // Proyectos en los que invirtió (solo lo ve el propio inversionista)
            $aportes = $donaciones->resumenDeUsuario($id_perfil_visitado);
            $mapa    = array_column($aportes, 'mi_aporte', 'id_proyecto');

            $proyectos = $proyectoModel->conProgreso(
                $proyectoModel->conEtiquetas($proyectoModel->porIds(array_keys($mapa)))
            );
            foreach ($proyectos as &$proyecto) {
                $proyecto['mi_aporte'] = (float) ($mapa[$proyecto['id_proyecto']] ?? 0);
            }
            unset($proyecto);

            $stats = [
                'invertidos' => count($aportes),
                'donado'     => array_sum($mapa),
            ];
        }

        $data = [
            'id_usuario_logueado' => $session->get('id'),
            'id_cuenta_visitada'  => $id_perfil_visitado,
            'es_el_propio_perfil' => $esPropio,

            'alias'               => $usuarioDb['alias'] ?? 'Sin Alias',
            'nombre'              => $usuarioDb['nombre'] ?? '',
            'apellido'            => $usuarioDb['apellido'] ?? '',
            'email'               => $session->get('email'),
            'tipo'                => $tipoVisitado,

            'proyectos'           => $proyectos,
            'stats'               => $stats,
            'puede_crear'         => $esPropio && $tipoVisitado === 'desarrollador' && ! $limiteAlcanzado,
            'limite_alcanzado'    => $limiteAlcanzado,
            'max_proyectos'       => ProyectoModel::MAX_POR_DESARROLLADOR,
        ];

        return view('perfil/mi_cuenta_view', $data);
    }
}
