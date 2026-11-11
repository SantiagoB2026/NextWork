<?php

namespace App\Controllers;

use App\Models\EtiquetaModel;
use App\Models\ProyectoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EtiquetasController extends BaseController
{
    // ---------- PÚBLICO ----------

    /** Todas las etiquetas ("Descubrir") */
    public function index()
    {
        return view('Etiquetas/index', [
            'etiquetas' => (new EtiquetaModel())->todasConConteo(),
        ]);
    }

    /** Proyectos de una etiqueta: /etiqueta/musica */
    public function ver(string $slug)
    {
        $etiquetaModel = new EtiquetaModel();
        $etiqueta      = $etiquetaModel->porSlug($slug);

        if ($etiqueta === null) {
            throw PageNotFoundException::forPageNotFound('No existe la etiqueta "' . $slug . '".');
        }

        $proyectoModel = new ProyectoModel();
        $proyectos     = $proyectoModel->conProgreso(
            $proyectoModel->conEtiquetas(
                $proyectoModel->porEtiqueta((int) $etiqueta['id_etiqueta'])
            )
        );

        return view('Etiquetas/ver', [
            'etiqueta'  => $etiqueta,
            'proyectos' => $proyectos,
        ]);
    }

    // ---------- ADMINISTRADOR (rutas bajo /Administrador, protegidas por AuthFilter) ----------

    public function admin()
    {
        return view('Etiquetas/admin', [
            'etiquetas' => (new EtiquetaModel())->todasConConteo(),
        ]);
    }

    public function guardar()
    {
        $model  = new EtiquetaModel();
        $nombre = trim((string) $this->request->getPost('nombre'));
        $slug   = EtiquetaModel::crearSlug($nombre);

        if ($slug === '') {
            return redirect()->back()->withInput()->with('error', 'El nombre de la etiqueta no es válido.');
        }

        // "Música" y "Musica" generarían el mismo slug
        if ($model->porSlug($slug) !== null) {
            return redirect()->back()->withInput()->with('error', 'Ya existe una etiqueta con ese nombre.');
        }

        if (! $model->insert(['nombre' => $nombre])) {
            return redirect()->back()->withInput()->with('error', implode(' ', $model->errors()));
        }

        return redirect()->to('Administrador/etiquetas')->with('exito', 'Etiqueta creada.');
    }

    public function eliminar(int $id)
    {
        $model = new EtiquetaModel();

        if ($model->find($id) === null) {
            throw PageNotFoundException::forPageNotFound('No existe la etiqueta.');
        }

        // La tabla pivote tiene ON DELETE CASCADE: solo se quita la etiqueta de los proyectos
        $model->delete($id);

        return redirect()->to('Administrador/etiquetas')->with('exito', 'Etiqueta eliminada.');
    }
}
