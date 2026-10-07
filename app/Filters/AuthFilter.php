<<<<<<< HEAD
<?php
namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
 public function before(RequestInterface $request, $arguments = null)
 {
 if (! session()->get('logueado')) {
 return redirect()->to('/login')->with('error', 'Tenés que iniciar sesión.');
 };
 if (! session()->get('role')==='admin'){
    return redirect()->to('/home')->with('error','No tienes acceso como administrador porque no lo eres, atentamente los admins')
 }
 }
 public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
 {
 }
};

=======
>>>>>>> eb7faa6fa79e9b86edadd419b7382a6e53995850
