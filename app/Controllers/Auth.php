<?php
namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    // 1. REGISTRO DE USUARIO (Queda igual)
    public function register()
    {
        if(session()->get('isLoggedIn')) {
            return redirect()->to('/'); 
        }
        return view('auth/register'); 
    }

    // 2. PROCESO DE REGISTRO DE USUARIO (CORREGIDO)
    public function processRegister()
    {
        $rules = [
            'alias'              => "required|min_length[3]",
            'nombre'             => "required",
            'apellido'           => "required",
            'correo_electronico' => "required|valid_email", 
            'fecha_nacimiento'   => "required|valid_date",
            'contraseña'         => "required|min_length[8]" 
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        // Estructuramos el insert con las columnas reales de tu BD
        $resultado = $userModel->insert([
            'alias'              => $this->request->getPost('alias'),
            'nombre'             => $this->request->getPost('nombre'),
            'apellido'           => $this->request->getPost('apellido'),
            'correo_electronico' => $this->request->getPost('correo_electronico'),
            'fecha_nacimiento'   => $this->request->getPost('fecha_nacimiento'),
            'contraseña'         => password_hash($this->request->getPost('contraseña'), PASSWORD_DEFAULT),
            'tipo' => $this->request->getPost('tipo')
    
            // Nota: Si agregás 'role' a tu BD, recordá ponerlo también en $allowedFields en tu UserModel
        ]);

        if (!$resultado) {
            return redirect()->back()->withInput()->with('errores', $userModel->errors());
        }

        return redirect()->to('/login') // Cambiado a /login según tu ruta
            ->with('exito', 'Registro completado. Ahora podés iniciar sesión.');
    }

    // 3. INICIO DE SESIÓN DE USUARIO (Queda igual)
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('auth/login');
    }

    // 4. PROCESO DE INICIO DE SESIÓN (CORREGIDO)
    public function processLogin()
    {
        $userModel = new UserModel();

        // En la vista de login deberás usar name="correo_electronico" y name="contraseña"
        $email    = $this->request->getPost('correo_electronico');
        $password = $this->request->getPost('contraseña');

        // Buscamos en la columna correcta de tu tabla
        $user = $userModel->where('correo_electronico', $email)->first();

        if ($user && password_verify($password, $user['contraseña'])) {

            session()->set([
                'id'         => $user['id'],
                'name'       => $user['nombre'], // Guardamos el nombre en sesión
                'email'      => $user['correo_electronico'],
                'isLoggedIn' => true
            ]);

            return redirect()->to('/');
        }

        return redirect()->back()->withInput()->with('errores', ['login' => 'Correo o contraseña incorrectos.']);
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}