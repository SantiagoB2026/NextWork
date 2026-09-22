<?php
namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    // 1. REGISTRO DE USUARIO
    public function register()
    {
        if(session()->get('isLoggedIn')) {
            return redirect()->to('/'); 
        }

        if (session()->get('isLoggedIn')) { 
            return redirect()->to('/'); 
        }
        return view('auth/register'); 
    }

    // 2. PROCESO DE REGISTRO DE USUARIO
    public function processRegister()
    {
        $rules = [
            'name'   => "required|min_length[3]",
            'email'    => "required|valid_email|is_unique[users.email]", 
            'password' => "required|min_length[8]" 
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $userModel->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'client'
        ]);

        return redirect()->to('/auth/login')
            ->with('exito', 'Registro completado. Ahora podés iniciar sesión.');
    }

    // 3. INICIO DE SESIÓN DE USUARIO
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        return view('auth/login');
    }

    // 4. PROCESO DE INICIO DE SESIÓN
    public function processLogin()
    {
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {

            session()->set([
                'id'         => $user['id'],
                'name'       => $user['name'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'isLoggedIn' => true
            ]);

            return redirect()->to('/');
        }

        return redirect()->back()->withInput()->with('error', 'Correo o contraseña incorrectos.');
    }

    // 5. CIERRE DE SESIÓN
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
}
