<?php

namespace App\Controllers;

use App\Models\DonacionModel;
use App\Models\ProyectoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DonacionesController extends BaseController
{
    /** GET inversionista/proyectos/{id}/donar : pantalla especial de donación */
    public function formulario(int $idProyecto)
    {
        return view('Donaciones/donar', [
            'proyecto' => $this->obtenerProyecto($idProyecto),
        ]);
    }

    /** POST inversionista/proyectos/{id}/donar : registra la donación y vuelve al proyecto */
    public function guardar(int $idProyecto)
    {
        $this->obtenerProyecto($idProyecto); // 404 si no existe

        $reglas = ['monto' => 'required|numeric|greater_than_equal_to[1]|less_than[1000000000]'];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('error', 'Ingresa un monto válido (mínimo $1).');
        }

        $monto = round((float) $this->request->getPost('monto'), 2);

        $guardada = (new DonacionModel())->insert([
            'id_proyecto' => $idProyecto,
            'id_usuario'  => (int) session()->get('id'),
            'monto'       => $monto,
        ]);

        if (! $guardada) {
            return redirect()->back()->withInput()->with('error', 'No se pudo registrar la donación. Inténtalo de nuevo.');
        }

        helper('proyectos');

        return redirect()->to('proyecto/' . $idProyecto)
            ->with('exito', '¡Gracias! Tu aporte de ' . dinero($monto) . ' ya cuenta para la meta.');
    }

    /** GET inversionista/donaciones : proyectos a los que aporté */
    public function mias()
    {
        $aportes = (new DonacionModel())->resumenDeUsuario((int) session()->get('id'));

        return view('Donaciones/mias', [
            'aportes'      => $aportes,
            'totalAportado' => array_sum(array_column($aportes, 'mi_aporte')),
        ]);
    }

    private function obtenerProyecto(int $id): array
    {
        $model    = new ProyectoModel();
        $proyecto = $model->find($id);

        if ($proyecto === null) {
            throw PageNotFoundException::forPageNotFound('No existe el proyecto solicitado.');
        }

        return $model->conProgreso([$proyecto])[0];
    }
}
