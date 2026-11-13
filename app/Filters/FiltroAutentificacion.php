<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class FiltroAutentificacion implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si el usuario ya está logueado, lo mandamos a la página  principal
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/'); 
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
