<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RedirectIfAuthenticated implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Validá si la sesión del usuario está activa.
        // Cambiá 'isLoggedIn' por la variable exacta que usás al loguear al usuario
        if (session()->get('isLoggedIn')) {
            
            // 2. Redireccioná al panel principal (ej: /dashboard o /home)
            return redirect()->to('/dashboard'); 
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita lógica aquí
    }
}