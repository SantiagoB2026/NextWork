<?php

namespace App\Controllers;

use App\Libraries\AccesoProyecto;
use App\Libraries\ImagenesProyecto;
use App\Models\CalificacionModel;
use App\Models\ColaboradorModel;
use App\Models\ComentarioModel;
use App\Models\DonacionModel;
use App\Models\EtiquetaModel;
use App\Models\ImagenModel;
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
        if ((new ProyectoModel())->alcanzoLimite((int) session()->get('id'))) {
            return redirect()->to('desarrollador/proyectos')->with('error', $this->mensajeLimite());
        }

        return $this->vistaMisProyectos(true);
    }

    private function vistaMisProyectos(bool $abrirFormulario)
    {
        $idLogueado    = (int) session()->get('id');
        $proyectoModel = new ProyectoModel();

        $proyectos = $proyectoModel->conProgreso(
            $proyectoModel->conEtiquetas($proyectoModel->delUsuario($idLogueado))
        );

        return view('Creador/crearproyectos', [
            'id_usuario_logueado' => $idLogueado,
            'id_cuenta_visiteda'  => $idLogueado, // Se asume que el desarrollador está en su propia sección
            'etiquetas'           => (new EtiquetaModel())->orderBy('nombre')->findAll(),
            'proyectos'           => $proyectos,
            'abrirFormulario'     => $abrirFormulario,
            'invitaciones'        => (new ColaboradorModel())->pendientesDe($idLogueado),
            'limiteAlcanzado'     => $proyectoModel->alcanzoLimite($idLogueado),
            'proyectosActivos'    => $proyectoModel->contarCreados($idLogueado),
            'maxProyectos'        => ProyectoModel::MAX_POR_DESARROLLADOR,
        ]);
    }

    private function mensajeLimite(): string
    {
        $max = ProyectoModel::MAX_POR_DESARROLLADOR;

        return ProyectoModel::CONTAR_SOLO_ACTIVOS
            ? "Alcanzaste el máximo de {$max} proyectos activos. Cuando uno llegue a su meta podrás crear otro."
            : "Alcanzaste el máximo de {$max} proyectos por desarrollador.";
    }

    // Procesa y guarda los datos enviados por el formulario
    public function guardar()
    {
        $idUsuario = (int) session()->get('id');
        $model     = new ProyectoModel();

        if ($model->alcanzoLimite($idUsuario)) {
            return redirect()->to('desarrollador/proyectos')->with('error', $this->mensajeLimite());
        }

        $reglas = [
            'titulo'           => 'required|max_length[100]',
            'descripcion'      => 'required|max_length[500]',
            'dinero_conseguir' => 'required|is_natural_no_zero',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $etiquetaModel = new EtiquetaModel();

        // Etiquetas elegidas en el formulario (checkboxes name="etiquetas[]")
        $idsEtiquetas = array_slice((array) $this->request->getPost('etiquetas'), 0, self::MAX_ETIQUETAS);

        $data = [
            'id_usuario'        => $idUsuario,
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

        if (! $idNuevo || ! $db->transStatus()) {
            return redirect()->back()->withInput()->with('error', 'No se pudo guardar el proyecto');
        }

        // Las imágenes se guardan una vez creado el proyecto; si alguna falla, el proyecto igual queda publicado
        $imagenes  = ImagenesProyecto::guardar((int) $idNuevo, $this->request);
        $respuesta = redirect()->to('desarrollador/proyectos')->with('exito', 'Proyecto publicado con éxito.');

        if (! empty($imagenes['errores'])) {
            $respuesta = $respuesta->with('error', 'El proyecto se publicó, pero: ' . implode(' ', $imagenes['errores']));
        }

        return $respuesta;
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

        $acceso = AccesoProyecto::de($proyecto);

        // Los proyectos que llegaron a su meta se ocultan al público
        if (! $acceso['puedeVer']) {
            throw PageNotFoundException::forPageNotFound('No existe el proyecto solicitado.');
        }

        $proyecto      = $model->conProgreso($model->conEtiquetas([$proyecto]))[0];
        $colaboradores = new ColaboradorModel();
        $donaciones    = new DonacionModel();

        return view('Proyectos/ver', $acceso + [
            'proyecto'       => $proyecto,
            'equipo'         => $colaboradores->equipo($id),
            'invitados'      => $acceso['esDueno'] ? $colaboradores->invitadosPendientes($id) : [],
            'imagenes'       => (new ImagenModel())->deProyecto($id),
            'comentarios'    => (new ComentarioModel())->deProyecto($id),
            'miCalificacion' => $acceso['tipo'] === 'inversionista' ? (new CalificacionModel())->de($id, $acceso['yo']) : 0,
            'miAporte'       => $acceso['tipo'] === 'inversionista' ? $donaciones->totalDeUsuarioEnProyecto($acceso['yo'], $id) : 0,
            'recientes'      => $acceso['esEquipo'] ? $donaciones->recientesDeProyecto($id, 10) : [],
        ]);
    }
}
