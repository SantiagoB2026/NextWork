<?php
// Cambiado de "app" a "App" con mayúscula
namespace App\Controllers; 

class Perfil extends BaseController
{
    public function index()
    {
        // 1. Cargamos la sesión para poder usar los datos del usuario logueado
        $session = session();
        
        // 2. Preparamos los datos orientados a la vista
        $data = [
            'nombre'    => $session->get('name'),
            'apellido'  => $session->get('last_name'),
            'email'     => $session->get('email'),
            'fecha_nacimiento' => $session->get('fecha_nacimiento'),
            'tipo'       => $session->get('tipo')
        ];
        
        // 3. Retornamos la vista enviándole el arreglo de datos
        // Asegurate de que el archivo exista en: app/Views/perfil/mi_cuenta_view.php
        return view('perfil/mi_cuenta_view', $data);
    }
}
