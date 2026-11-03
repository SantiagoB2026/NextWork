<?php

namespace App\Controllers;

use App\Models\ProyectoModel;

class ProyectosController extends BaseController
{
    // Carga la vista del formulario inyectando las variables de sesión requeridas
    public function nuevo()
    {
        $idLogueado = session()->get('id'); 

        $data = [
            'id_usuario_logueado' => $idLogueado,
            'id_cuenta_visiteda'  => $idLogueado // Se asume que el desarrollador está en su propia sección
        ];

        // Se pasa el array $data para que la vista reconozca las variables
        return view('Creador/crearproyectos', $data); 
    }

    // Procesa y guarda los datos enviados por el formulario
    public function guardar()
    {
        $model = new ProyectoModel();

        // Recolectamos los datos y añadimos la información automática del autor
        $data = [
            'titulo'            => $this->request->getPost('titulo'),
            'descripcion'       => $this->request->getPost('descripcion'),
            'dinero_conseguir'  => $this->request->getPost('dinero_conseguir'),
            'fecha_publicacion' => date('Y-m-d'), 
            'autor'             => session()->get('alias') ?? 'Anonimo', 
            'etiqueta'          => 'General'
        ];

        if ($model->insert($data)) {
            return redirect()->to('/')->with('exito', 'Proyecto guardado con éxito');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo guardar el proyecto');
        }
    }
}
