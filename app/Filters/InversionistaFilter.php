<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class InversionistaFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('errores', ['acceso' => 'Inicia sesión para continuar.']);
        }

        if (session()->get('tipo') !== 'inversionista') {
            return redirect()->to('/')->with('errores', ['acceso' => 'Acceso exclusivo para inversionistas.']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
