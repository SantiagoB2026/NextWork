<?php

namespace App\Controllers;

use App\Models\ProyectoModel;

class ProyectosController extends BaseController
{
    public function nuevo()
    {
        return view('nuevo_proyecto');
    }

    public function guardar()
    {
        $model = new ProyectoModel();

        // 1. Recolectar datos del formulario y datos lógicos del sistema
        $data = [
            'titulo'            => $this->request->getPost('titulo'),
            'descripcion'       => $this->request->getPost('descripcion'),
            'dinero_conseguir'  => $this->request->getPost('dinero_conseguir'),
            'fecha_publicacion' => date('Y-m-d'), // Fecha actual
            'autor'             => 'Admin',       // Aquí pondrías el usuario logueado ej: session()->get('username')
            'etiqueta'          => 'General'      // Valor por defecto o dinámico si añades un campo extra
        ];

        // 2. Guardar en la Base de Datos
        if ($model->insert($data)) {
            // Redireccionar con un mensaje de éxito
            return redirect()->to(base_url('proyectos'))->with('mensaje', 'Proyecto guardado con éxito');
        } else {
            // Manejar error en caso de fallo
            return redirect()->back()->withInput()->with('error', 'No se pudo guardar el proyecto');
        }
    }
}
