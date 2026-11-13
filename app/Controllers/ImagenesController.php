<?php

namespace App\Controllers;

use App\Libraries\AccesoProyecto;
use App\Libraries\ImagenesProyecto;
use App\Models\ImagenModel;
use App\Models\ProyectoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ImagenesController extends BaseController
{
    /** POST desarrollador/proyectos/{id}/imagenes : agrega imágenes (solo el equipo del proyecto) */
    public function subir(int $idProyecto)
    {
        $volver = redirect()->to('proyecto/' . $idProyecto);

        if (! $this->esEquipo($idProyecto)) {
            return $volver->with('error', 'Solo el equipo del proyecto puede agregar imágenes.');
        }

        $resultado = ImagenesProyecto::guardar($idProyecto, $this->request);

        if ($resultado['guardadas'] === 0 && empty($resultado['errores'])) {
            return $volver->with('error', 'Selecciona al menos una imagen.');
        }

        if ($resultado['guardadas'] > 0) {
            $volver = $volver->with('exito', $resultado['guardadas'] === 1 ? 'Imagen agregada.' : $resultado['guardadas'] . ' imágenes agregadas.');
        }
        if (! empty($resultado['errores'])) {
            $volver = $volver->with('error', implode(' ', $resultado['errores']));
        }

        return $volver;
    }

    /** POST desarrollador/imagenes/{id}/eliminar */
    public function eliminar(int $idImagen)
    {
        $modelo = new ImagenModel();
        $imagen = $modelo->find($idImagen);

        if ($imagen === null) {
            throw PageNotFoundException::forPageNotFound('No existe la imagen.');
        }

        $idProyecto = (int) $imagen['id_proyecto'];
        $volver     = redirect()->to('proyecto/' . $idProyecto);

        if (! $this->esEquipo($idProyecto)) {
            return $volver->with('error', 'Solo el equipo del proyecto puede eliminar imágenes.');
        }

        $modelo->delete($idImagen);
        ImagenesProyecto::borrarArchivo($imagen['archivo']);

        return $volver->with('exito', 'Imagen eliminada.');
    }

    private function esEquipo(int $idProyecto): bool
    {
        $proyecto = (new ProyectoModel())->find($idProyecto);

        if ($proyecto === null) {
            throw PageNotFoundException::forPageNotFound('No existe el proyecto solicitado.');
        }

        return AccesoProyecto::de($proyecto)['esEquipo'];
    }
}
