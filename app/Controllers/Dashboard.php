<?php

namespace App\Controllers;

class Dashboard extends BaseController{
    public function inversionista(){
        if (!session()->get('isLoggedIn') || session()->get('tipo') !== 'inversionista') {
            return redirect()->to('/login')->with('errores', ['login' => 'Acceso exclusivo para inversionistas.']);
        }
        
        return view('Usuarios/inversionista');
    }

    public function desarrollador(){
        if (!session()->get('isLoggedIn') || session()->get('tipo') !== 'desarrollador') {
            return redirect()->to('/login')->with('errores', ['login' => 'Acceso exclusivo para desarrolladores.']);
        }
        
        
        return view('Usuarios/desarrollador');
    }
}

