<?php
namespace App\Controllers; 

class Perfil extends BaseController
{
    public function index($id_perfil_visitado = null)
    {
        $session = session();
        $db = \Config\Database::connect();
        
        if ($id_perfil_visitado === null) {
            $id_perfil_visitado = $session->get('id');
        }

        $usuarioDb = $db->table('Usuario')
                        ->where('id_usuario', $id_perfil_visitado)
                        ->get()
                        ->getRowArray();

        if (!$usuarioDb) {
            $usuarioDb = [
                'alias'       => 'Sin Alias',
                'nombre'      => $session->get('name') ?? 'Usuario',
                'apellido'    => '',
                'foto_perfil' => null // Plan B por si no encuentra el usuario
            ];
        }

        $data = [
            'id_usuario_logueado' => $session->get('id'), 
            'id_cuenta_visitada'  => $id_perfil_visitado,
            'es_el_propio_perfil' => ($session->get('id') == $id_perfil_visitado),
            
            'alias'               => $usuarioDb['alias'] ?? 'Sin Alias', 
            'nombre'              => $usuarioDb['nombre'], 
            'apellido'            => $usuarioDb['apellido'], 
            'foto_perfil'         => $usuarioDb['foto_perfil'] ?? null, // Pasamos la foto a la vista
            'email'               => $session->get('email'), 
            'tipo'                => $session->get('tipo') 
        ];
        
        return view('perfil/mi_cuenta_view', $data);
    }

    public function subirFoto()
    {
        $session = session();
        $id_usuario = $session->get('id');

        if (!$id_usuario) {
            return redirect()->to(base_url('login'));
        }

        // Validación del archivo (máximo 2MB, solo imágenes)
        $validacion = $this->validate([
            'foto' => [
                'uploaded[foto]',
                'mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]',
                'max_size[foto,2048]',
            ]
        ]);

        if (!$validacion) {
            return redirect()->back()->with('error', 'Archivo no válido. Asegúrate de que sea una imagen de menos de 2MB.');
        }

        $file = $this->request->getFile('foto');

        if ($file->isValid() && !$file->hasMoved()) {
            // Genera un nombre aleatorio seguro para la imagen
            $nuevoNombre = $file->getRandomName();
            
            // Movemos el archivo a la carpeta pública 'public/uploads/perfiles/'
            $file->move(FCPATH . 'uploads/perfiles/', $nuevoNombre);

            // Actualizamos la base de datos
            $db = \Config\Database::connect();
            $db->table('Usuario')
               ->where('id_usuario', $id_usuario)
               ->update(['foto_perfil' => $nuevoNombre]);

            return redirect()->back()->with('mensaje', 'Foto de perfil actualizada correctamente.');
        }

        return redirect()->back()->with('error', 'Error al subir el archivo.');
    }
}