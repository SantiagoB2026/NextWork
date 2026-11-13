<?php

namespace App\Controllers;

use App\Libraries\AccesoProyecto;
use App\Models\CalificacionModel;
use App\Models\ProyectoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class CalificacionesController extends BaseController
{
    /** POST proyecto/{id}/calificar : solo inversionistas (filtro isInversionista en la ruta) */
    public function guardar(int $idProyecto)
    {
        $proyecto = (new ProyectoModel())->find($idProyecto);

        if ($proyecto === null || ! AccesoProyecto::de($proyecto)['puedeVer']) {
            throw PageNotFoundException::forPageNotFound('No existe el proyecto solicitado.');
        }

        $volver  = redirect()->to('proyecto/' . $idProyecto . '#calificacion');
        $puntaje = (int) $this->request->getPost('puntaje');

        if ($puntaje < 1 || $puntaje > 5) {
            return $volver->with('error', 'Elige una calificación de 1 a 5 estrellas.');
        }

        (new CalificacionModel())->guardar($idProyecto, (int) session()->get('id'), $puntaje);

        return $volver->with('exito', 'Gracias por calificar este proyecto.');
    }
}
