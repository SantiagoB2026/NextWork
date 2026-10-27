<?php
namespace App\Controllers; 

class Perfil extends BaseController
{
    public function index($id_perfil_visitado = null)
    {
        $session = session();
        
        // Si no viene ningún ID en la URL, usamos el de la sesión
        if ($id_perfil_visitado === null) {
            $id_perfil_visitado = $session->get('user_id');
        }

        // Armamos los datos usando puramente lo que está en la sesión
        $data = [
            'id_usuario_logueado' => $session->get('user_id'),
            'id_cuenta_visitada'  => $id_perfil_visitado,
            
            // Evaluamos si está viendo su propio perfil
            'es_el_propio_perfil' => ($session->get('user_id') == $id_perfil_visitado),

            // Traemos el alias de la sesión (si no existe, usa el name como respaldo)
            'alias'    => $session->get('alias') ?? $session->get('name') ?? 'Sin Alias',
            'nombre'   => $session->get('name'),
            'apellido' => $session->get('last_name'),
            'email'    => $session->get('email'),
            'tipo'     => $session->get('tipo')
        ];
        
        return view('perfil/mi_cuenta_view', $data);
    }
}
