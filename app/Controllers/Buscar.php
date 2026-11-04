<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProyectoModel;

class Buscar extends BaseController
{
    public function index()
    {
        // CAPTURA EL PARÁMETRO 'query' DEL FORMULARIO
        $keyword = $this->request->getGet('query');

        // Obtiene el ID del usuario logueado desde la sesión
        $miId = session()->get('id');

        $resultados = [
            'usuarios'  => [],
            'proyectos' => [],
            'keyword'   => $keyword
        ];

        if (!empty($keyword)) {
            $userModel     = new UserModel();
            $proyectoModel = new ProyectoModel();

            // BUSCA ÚNICAMENTE POR EL ALIAS (NOMBRE DE USUARIO)
            $userModel->like('alias', $keyword);

            // Excluye tu propio usuario logueado para que no te encuentres a vos mismo
            if ($miId) {
                $campoId = $userModel->primaryKey;
                $userModel->where($campoId . ' !=', $miId);
            }

            $resultados['usuarios'] = $userModel->findAll();

            // Proyectos: por título, descripción o nombre de etiqueta (ya con sus etiquetas cargadas)
            $resultados['proyectos'] = $proyectoModel->conEtiquetas(
                $proyectoModel->buscar($keyword)
            );
        }

        return view('Buscador/buscar_resultados', $resultados);
    }
}
