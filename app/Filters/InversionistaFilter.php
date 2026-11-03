<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RedirectIfAuthenticated implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Corregido: Si ya inició sesión, redirigir a la raíz '/' o a '/perfil'
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/'); 
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
