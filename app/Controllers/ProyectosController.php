<?php

namespace App\Controllers;

use App\Models\DonacionModel;
use App\Models\EtiquetaModel;
use App\Models\ProyectoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProyectosController extends BaseController
{
    private const MAX_ETIQUETAS = 5;

    // ---------- DESARROLLADOR ----------

    /** desarrollador/proyectos : mis proyectos con su barra de progreso */
    public function mios()
    {
        return $this->vistaMisProyectos(false);
    }

    /** desarrollador/proyectos/nuevo : lo mismo, con el formulario abierto */
    public function nuevo()
    {
        return $this->vistaMisProyectos(true);
    }

    private function vistaMisProyectos(bool $abrirFormulario)
    {
        $idLogueado    = session()->get('id');
        $proyectoModel = new ProyectoModel();

        $proyectos = $proyectoModel->conProgreso(
            $proyectoModel->conEtiquetas($proyectoModel->delUsuario((int) $idLogueado))
        );

        return view('Creador/crearproyectos', [
            'id_usuario_logueado' => $idLogueado,
            'id_cuenta_visiteda'  => $idLogueado, // Se asume que el desarrollador está en su propia sección
            'etiquetas'           => (new EtiquetaModel())->orderBy('nombre')->findAll(),
            'proyectos'           => $proyectos,
            'abrirFormulario'     => $abrirFormulario,
        ]);
    }

    // Procesa y guarda los datos enviados por el formulario
    public function guardar()
    {
        $reglas = [
            'titulo'           => 'required|max_length[100]',
            'descripcion'      => 'required|max_length[500]',
            'dinero_conseguir' => 'required|is_natural_no_zero',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $model         = new ProyectoModel();
        $etiquetaModel = new EtiquetaModel();

        // Etiquetas elegidas en el formulario (checkboxes name="etiquetas[]")
        $idsEtiquetas = array_slice((array) $this->request->getPost('etiquetas'), 0, self::MAX_ETIQUETAS);

        $data = [
            'id_usuario'        => (int) session()->get('id'),
            'titulo'            => $this->request->getPost('titulo'),
            'descripcion'       => $this->request->getPost('descripcion'),
            'dinero_conseguir'  => $this->request->getPost('dinero_conseguir'),
            'fecha_publicacion' => date('Y-m-d'),
            'autor'             => session()->get('alias') ?? 'Anonimo',
        ];

        // Proyecto y etiquetas se guardan juntos: si algo falla, no queda nada a medias
        $db = \Config\Database::connect();
        $db->transStart();

        $idNuevo = $model->insert($data);
        if ($idNuevo) {
            $etiquetaModel->sincronizar((int) $idNuevo, $idsEtiquetas);
        }

        $db->transComplete();

        if ($idNuevo && $db->transStatus()) {
            return redirect()->to('desarrollador/proyectos')->with('exito', 'Proyecto publicado con éxito.');
        }

        return redirect()->back()->withInput()->with('error', 'No se pudo guardar el proyecto');
    }

    // ---------- PÁGINA DE UN PROYECTO (cada rol ve su versión) ----------

    /** proyecto/{id} */
    public function ver(int $id)
    {
        $model    = new ProyectoModel();
        $proyecto = $model->find($id);

        if ($proyecto === null) {
            throw PageNotFoundException::forPageNotFound('No existe el proyecto solicitado.');
        }

        $proyecto  = $model->conProgreso($model->conEtiquetas([$proyecto]))[0];
        $idUsuario = (int) session()->get('id');
        $tipo      = session()->get('isLoggedIn') ? session()->get('tipo') : null;
        $esDueno   = $tipo === 'desarrollador' && (int) ($proyecto['id_usuario'] ?? 0) === $idUsuario;

        $donaciones = new DonacionModel();

        return view('Proyectos/ver', [
            'proyecto'  => $proyecto,
            'tipo'      => $tipo,
            'esDueno'   => $esDueno,
            'miAporte'  => $tipo === 'inversionista' ? $donaciones->totalDeUsuarioEnProyecto($idUsuario, $id) : 0,
            'recientes' => $esDueno ? $donaciones->recientesDeProyecto($id, 10) : [],
        ]);
    }
}
