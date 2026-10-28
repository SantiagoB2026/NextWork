<?php
namespace App\Controllers;

class Proyecto extends BaseController
{
    public function guardar()
    {
        $session = session();
        
        // 1. Seguridad: Verificar sesión activa
        if (!$session->has('id_usuario')) {
            return redirect()->to('/login');
        }

        // 2. Recolectar datos del formulario
        $dataProyecto = [
            'id_usuario'      => $session->get('id_usuario'),
            'titulo'          => $this->request->getPost('titulo'),
            'descripcion'     => $this->request->getPost('descripcion'),
            'dinero_objetivo' => $this->request->getPost('dinero_objetivo')
        ];

        // 3. Insertar en la Base de Datos
        $db = \Config\Database::connect();
        $db->table('proyectos')->insert($dataProyecto);

        // 4. Redirigir de vuelta al PERFIL del usuario con un mensaje
        return redirect()->to('/perfil')->with('success', 'Proyecto creado con éxito.');
    }
}
