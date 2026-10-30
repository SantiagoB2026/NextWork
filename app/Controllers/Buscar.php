<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProModel;

class Buscar extends BaseController
{
    public function index()
    {
        // CAPTURA EL PARÁMETRO 'query' DEL FORMULARIO
        $keyword = $this->request->getGet('query'); 

        $resultados = [
            'usuarios'  => [],
            'proyectos' => [],
            'keyword'   => $keyword
        ];

        if (!empty($keyword)) {
            $userModel = new UserModel();
            $proModel  = new ProModel();

            $resultados['usuarios'] = $userModel->like('alias', $keyword)
                                                ->orLike('nombre', $keyword)
                                                ->orLike('apellido', $keyword)
                                                ->findAll();

            $resultados['proyectos'] = $proModel->groupStart()
                                                    ->like('titulo', $keyword)
                                                    ->orLike('descripcion', $keyword)
                                                    ->orLike('etiqueta', $keyword)
                                                ->groupEnd()
                                                ->findAll();
        }

        return view('Buscador/buscar_resultados', $resultados);
    }
}