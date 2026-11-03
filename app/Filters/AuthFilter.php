<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Si no inició sesión, directo al login
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Tenés que iniciar sesión.');
        }

        // 2. CORREGIDO: Usamos el método getUri() para obtener los segmentos de forma pública
        if ($request->getUri()->getSegment(1) === 'Administrador' && session()->get('tipo') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes acceso como administrador.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
