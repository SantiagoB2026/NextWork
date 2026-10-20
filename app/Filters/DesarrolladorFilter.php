<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class DesarrolladorFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        
        if (!session()->get('isLoggedIn') || session()->get('tipo') !== 'desarrollador') {
            return redirect()->to('/')->with('errores', ['acceso' => 'Acceso exclusivo para desarrolladores.']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    
    }
}
