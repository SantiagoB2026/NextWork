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
        
        if ($id_perfil_visitado === null) {
            $id_perfil_visitado = $session->get('id');
        }
        $id_perfil_visitado = (int) $id_perfil_visitado;

        $usuarioDb = $db->table('Usuario')
                        ->where('id_usuario', $id_perfil_visitado)
                        ->get()
                        ->getRowArray();

        if (!$usuarioDb) {
            $usuarioDb = [
                'alias'       => 'Sin Alias',
                'nombre'      => $session->get('name') ?? 'Usuario',
                'apellido'    => '',
                'foto_perfil' => null // Plan B por si no encuentra el usuario
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
            'foto_perfil'         => $usuarioDb['foto_perfil'] ?? null,
            'proyectos'           => $proyectos,
            'stats'               => $stats,
            'puede_crear'         => $esPropio && $tipoVisitado === 'desarrollador' && ! $limiteAlcanzado,
            'limite_alcanzado'    => $limiteAlcanzado,
            'max_proyectos'       => ProyectoModel::MAX_POR_DESARROLLADOR,
        ];

        return view('perfil/mi_cuenta_view', $data);
    }

    public function subirFoto()
    {
        $session = session();
        $id_usuario = $session->get('id');

        if (!$id_usuario) {
            return redirect()->to(base_url('login'));
        }

        // Validación del archivo (máximo 2MB, solo imágenes)
        $validacion = $this->validate([
            'foto' => [
                'uploaded[foto]',
                'mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]',
                'max_size[foto,4092]',
            ]
        ]);

        if (!$validacion) {
            return redirect()->back()->with('error', 'Archivo no válido. Asegúrate de que sea una imagen de menos de 2MB.');
        }

        $file = $this->request->getFile('foto');

        if ($file->isValid() && !$file->hasMoved()) {
            // Genera un nombre aleatorio seguro para la imagen
            $nuevoNombre = $file->getRandomName();
            
            // Movemos el archivo a la carpeta pública 'public/uploads/perfiles/'
            $file->move(FCPATH . 'uploads/perfiles/', $nuevoNombre);

            // Actualizamos la base de datos
            $db = \Config\Database::connect();
            $db->table('Usuario')
               ->where('id_usuario', $id_usuario)
               ->update(['foto_perfil' => $nuevoNombre]);

            return redirect()->back()->with('mensaje', 'Foto de perfil actualizada correctamente.');
        }

        return redirect()->back()->with('error', 'Error al subir el archivo.');
    }
}