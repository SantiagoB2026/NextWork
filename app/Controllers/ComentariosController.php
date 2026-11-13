<?php

namespace App\Controllers;

use App\Libraries\AccesoProyecto;
use App\Models\ComentarioModel;
use App\Models\ProyectoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ComentariosController extends BaseController
{
    private const MAX_CARACTERES = 500;

    /** POST proyecto/{id}/comentar : desarrolladores e inversionistas con sesión iniciada */
    public function guardar(int $idProyecto)
    {
        $proyecto = $this->cargarProyecto($idProyecto);
        $acceso   = AccesoProyecto::de($proyecto);
        $volver   = redirect()->to('proyecto/' . $idProyecto . '#comentarios');

        if (! $acceso['puedeVer']) {
            throw PageNotFoundException::forPageNotFound('No existe el proyecto solicitado.');
        }

        if (! in_array($acceso['tipo'], ['desarrollador', 'inversionista'], true)) {
            return $volver->with('error', 'Tu tipo de cuenta no puede comentar.');
        }

        $texto = trim((string) $this->request->getPost('texto'));

        if ($texto === '' || mb_strlen($texto) > self::MAX_CARACTERES) {
            return $volver->with('error', 'El comentario debe tener entre 1 y ' . self::MAX_CARACTERES . ' caracteres.');
        }

        (new ComentarioModel())->insert([
            'id_proyecto' => $idProyecto,
            'id_usuario'  => $acceso['yo'],
            'texto'       => $texto,
        ]);

        return $volver->with('exito', 'Comentario publicado.');
    }

    /** POST desarrollador/comentarios/{id}/eliminar : solo el equipo del proyecto */
    public function eliminar(int $idComentario)
    {
        $modelo     = new ComentarioModel();
        $comentario = $modelo->find($idComentario);

        if ($comentario === null) {
            throw PageNotFoundException::forPageNotFound('No existe el comentario.');
        }

        $idProyecto = (int) $comentario['id_proyecto'];
        $acceso     = AccesoProyecto::de($this->cargarProyecto($idProyecto));
        $volver     = redirect()->to('proyecto/' . $idProyecto . '#comentarios');

        if (! $acceso['esEquipo']) {
            return $volver->with('error', 'Solo el equipo del proyecto puede eliminar comentarios.');
        }

        $modelo->delete($idComentario);

        return $volver->with('exito', 'Comentario eliminado.');
    }

    private function cargarProyecto(int $id): array
    {
        $proyecto = (new ProyectoModel())->find($id);

        if ($proyecto === null) {
            throw PageNotFoundException::forPageNotFound('No existe el proyecto solicitado.');
        }

        return $proyecto;
    }
}
