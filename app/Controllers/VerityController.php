<?php

namespace App\Controllers;

use App\Models\DeveloperModel;
use App\Models\InvestorModel;

class Dashboard extends BaseController
{
    public function index(){
        $session   = session();
        $idUsuario = $session->get('id');
        $tipo      = $session->get('tipo');

        // 2. Verificar según el tipo si ya completó su perfil adicional
        if ($tipo === 'desarrollador') {
            $devModel = new DeveloperModel();
            $perfil   = $devModel->find($idUsuario);

            // Si no tiene registro en la tabla Desarrollador, va al formulario
            if (!$perfil) {
                return view('perfiles/completar_desarrollador');
            }
        } 
        
        if ($tipo === 'inversionista') {
            $invModel = new InvestorModel();
            $perfil   = $invModel->find($idUsuario);

            // Si no tiene registro en la tabla Inversionista, va al formulario
            if (!$perfil) {
                return view('perfiles/completar_inversionista');
            }
        }

        // 3. Si ya tiene el perfil completo, entra al panel normal
        return view('dashboard/inicio');
    }

    /**
     * Procesa el formulario del Desarrollador
     */
    public function guardarDesarrollador()
    {
        $devModel = new DeveloperModel();

        $data = [
            'id_usuario'   => session()->get('id'),
            'preferencias' => $this->request->getPost('preferencias'),
            'calificacion' => 5.00 // Puntuación inicial por defecto
        ];

        $devModel->insert($data);
        return redirect()->to('/dashboard')->with('msg', '¡Perfil configurado con éxito!');
    }

    /**
     * Procesa el formulario del Inversionista
     */
    public function guardarInversionista()
    {
        $invModel = new InvestorModel();

        $data = [
            'id_usuario'        => session()->get('id'),
            'dinero_disponible' => $this->request->getPost('dinero_disponible'),
            'donacion_total'    => 0.00 // Inicia en cero
        ];

        $invModel->insert($data);
        return redirect()->to('/dashboard')->with('msg', '¡Perfil configurado con éxito!');
    }
}
