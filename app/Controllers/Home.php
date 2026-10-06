<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController {
    protected $Usuarios;
    
    private UserModel $Usuario;
    public function __construct(){
 $this->Usuarios = new UserModel();
 }
    public function index(){
        return view('Usuarios/index', [
            'Usuarios' => $this->Usuarios->orderBy('alias')->findAll()
    ]);
 }

    public function nuevo(){
        return view('Usuarios/form', ['Usuarios' => null]);
 }
 
    public function guardar(){
        $datos = $this->request->getPost(['alias', 'nombre', 'apellido', 'contraseña', 'fecha_nacimiento', 'correo_eletronico']);
    if (! $this->Usuarios->insert($datos)) {
        return redirect()->back()->withInput()
            ->with('errores', $this->Usuarios->errors());
 }
        return redirect()->to('/Usuarios')->with('mensaje', 'Usuarios creado.');
 }
 
        public function editar(int $id){
            return view('Usuarios/form', ['Usuarios' => $this->buscar($id)]);
 }
 
        public function actualizar(int $id)
 {
            $this->buscar($id);
        $datos = $this->request->getPost(['alias', 'nombre', 'apellido', 'contraseña', 'fecha_nacimiento', 'correo_eletronico']);
        if (! $this->Usuarios->update($id, $datos)) {
            return redirect()->back()->withInput()
                ->with('errores', $this->productos->errors());
 }
            return redirect()->to('/Usuarios')->with('mensaje', 'Usuario editado.');
 }
 
        public function eliminar(int $id)
 {
            $this->buscar($id);
            $this->Usuarios->delete($id);
        return redirect()->to('/Usuarios')->with('mensaje', 'Usuario eliminado.');
 }
 
        private function buscar(int $id): array
 {
        $Usuarios = $this->Usuarios->find($id);
            if ($Usuarios === null) {
                throw PageNotFoundException::forPageNotFound('No existe el Usuario' . $id);
 }
 return $Usuarios;
 }
}
