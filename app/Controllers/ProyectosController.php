<?php

namespace App\Controllers;

use App\Models\EtiquetaModel;
use App\Models\ProyectoModel;

class ProyectosController extends BaseController
{
    private const MAX_ETIQUETAS = 5;

    // Carga la vista del formulario inyectando las variables de sesión requeridas
    public function nuevo()
    {
        $idLogueado = session()->get('id');

        $data = [
            'id_usuario_logueado' => $idLogueado,
            'id_cuenta_visiteda'  => $idLogueado, // Se asume que el desarrollador está en su propia sección
            'etiquetas'           => (new EtiquetaModel())->orderBy('nombre')->findAll(),
        ];

        return view('Creador/crearproyectos', $data);
    }

    // Procesa y guarda los datos enviados por el formulario
    public function guardar()
    {
        $model         = new ProyectoModel();
        $etiquetaModel = new EtiquetaModel();

        // Etiquetas elegidas en el formulario (checkboxes name="etiquetas[]")
        $idsEtiquetas = array_slice((array) $this->request->getPost('etiquetas'), 0, self::MAX_ETIQUETAS);

        $data = [
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
            return redirect()->to('/')->with('exito', 'Proyecto guardado con éxito');
        }

        return redirect()->back()->withInput()->with('error', 'No se pudo guardar el proyecto');
    }
}
