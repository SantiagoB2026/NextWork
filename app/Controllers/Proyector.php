<?php
namespace App\Controllers;

// 1. Importamos tu modelo exacto
use App\Models\ProModel;

class Proyecto extends BaseController
{
    public function guardar()
    {
        $session = session();
        
        // Verificar sesión activa
        if (!$session->has('id_usuario')) {
            return redirect()->to('/login');
        }

        // 2. Instanciar tu ProModel
        $proModel = new ProModel();

        // 3. Recolectar y adaptar datos del formulario
        // Nota: Agregamos los campos obligatorios ('NOT NULL') de tu migración
        $dataProyecto = [
            'titulo'             => $this->request->getPost('titulo'),
            'descripcion'        => $this->request->getPost('descripcion'),
            
            // Mapeamos 'dinero_objetivo' del formulario al 'dinero_a_conseguir' de tu BD
            'dinero_a_conseguir' => $this->request->getPost('dinero_objetivo'),
            
            // Datos requeridos por tu migración que no vienen del formulario:
            'autor'              => $session->get('nombre_usuario') ?? 'Usuario_' . $session->get('id_usuario'), // Usá la variable de sesión que guarde su nombre
            'fecha_publicacion'  => date('Y-m-d'),
            'etiqueta'           => 'General' // O el valor por defecto que prefieras
        ];

        // 4. Insertar usando los superpoderes de tu Modelo
        if ($proModel->insert($dataProyecto)) {
            // Redirigir de vuelta al PERFIL con mensaje de éxito
            return redirect()->to('/perfil')->with('success', 'Proyecto creado con éxito.');
        } else {
            // En caso de que falle la inserción o las validaciones del modelo
            return redirect()->back()->withInput()->with('error', 'No se pudo guardar el proyecto.');
        }
    }
}