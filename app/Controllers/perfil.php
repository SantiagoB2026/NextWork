<?php
namespace App\Controllers; 

class Perfil extends BaseController
{
    public function index($id_perfil_visitado = null)
    {
        $session = session();
        $db = \Config\Database::connect();
        
        // CORREGIDO: Tu sesión guarda el ID en la clave 'id'
        if ($id_perfil_visitado === null) {
            $id_perfil_visitado = $session->get('id');
        }

        // Buscamos los datos en la base de datos usando tu ID correcto (el 9)
        $usuarioDb = $db->table('Usuario')
                        ->where('id_usuario', $id_perfil_visitado)
                        ->get()
                        ->getRowArray();

        // Si por alguna razón la consulta falla, dejamos un plan B para que no rompa
        if (!$usuarioDb) {
            $usuarioDb = [
                'alias'    => 'Sin Alias',
                'nombre'   => $session->get('name') ?? 'Usuario',
                'apellido' => ''
            ];
        }
        $data = [
            'id_usuario_logueado' => $session->get('id'), 
            'id_cuenta_visitada'  => $id_perfil_visitado,
            'es_el_propio_perfil' => ($session->get('id') == $id_perfil_visitado),
            
            
            'alias'               => $usuarioDb['alias'] ?? 'Sin Alias', 
            'nombre'              => $usuarioDb['nombre'], 
            'apellido'            => $usuarioDb['apellido'], 
            'email'               => $session->get('email'), 
            'tipo'                => $session->get('tipo') 
        ];
        
        return view('perfil/mi_cuenta_view', $data);
    }
}
