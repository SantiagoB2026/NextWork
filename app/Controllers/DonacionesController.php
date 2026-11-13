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
        $proyecto = $this->obtenerProyecto($idProyecto);

        if (! empty($proyecto['financiado_at'])) {
            return redirect()->to('proyecto/' . $idProyecto)
                ->with('error', 'Este proyecto ya alcanzó su meta y no recibe más donaciones.');
        }

        return view('Donaciones/donar', ['proyecto' => $proyecto]);
    }

    /** POST inversionista/proyectos/{id}/donar : registra la donación y vuelve al proyecto */
    public function guardar(int $idProyecto)
    {
        helper('proyectos');

        $this->obtenerProyecto($idProyecto); // 404 si no existe

        if (! $this->validate(['monto' => 'required|numeric|greater_than[0]|less_than[1000000000]'])) {
            return redirect()->back()->withInput()->with('error', 'Ingresa un monto válido mayor a 0.');
        }

        $monto = round((float) $this->request->getPost('monto'), 2);

        if ($monto <= 0) {
            return redirect()->back()->withInput()->with('error', 'Ingresa un monto válido mayor a 0.');
        }

        // Se bloquea la fila del proyecto mientras se registra el aporte, para que dos donaciones
        // al mismo tiempo no superen la meta
        $db = \Config\Database::connect();
        $db->transBegin();
        $db->query('SELECT id_proyecto FROM ' . $db->prefixTable('Proyectos') . ' WHERE id_proyecto = ? FOR UPDATE', [$idProyecto]);

        $proyecto = $this->obtenerProyecto($idProyecto); // con los totales ya actualizados
        $destino  = redirect()->to('proyecto/' . $idProyecto);

        if (! empty($proyecto['financiado_at'])) {
            $db->transRollback();
            return $destino->with('error', 'Este proyecto ya alcanzó su meta y no recibe más donaciones.');
        }

        $falta = round((float) $proyecto['dinero_conseguir'] - (float) $proyecto['recaudado'], 2);

        if ($monto > $falta) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Solo faltan ' . dinero($falta) . ' para llegar a la meta.');
        }

        $guardada = (new DonacionModel())->insert([
            'id_proyecto' => $idProyecto,
            'id_usuario'  => (int) session()->get('id'),
            'monto'       => $monto,
        ]);

        if (! $guardada) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'No se pudo registrar la donación. Inténtalo de nuevo.');
        }

        // Si con este aporte se completa la meta, el proyecto deja de ser público
        $alcanzoMeta = $monto >= $falta;
        if ($alcanzoMeta) {
            (new ProyectoModel())->update($idProyecto, ['financiado_at' => date('Y-m-d H:i:s')]);
        }

        $db->transCommit();

        return $destino->with(
            'exito',
            $alcanzoMeta
                ? '¡Gracias! Con tu aporte de ' . dinero($monto) . ' el proyecto alcanzó su meta.'
                : '¡Gracias! Tu aporte de ' . dinero($monto) . ' ya cuenta para la meta.'
        );
    }

    /** GET inversionista/donaciones : proyectos a los que aporté */
    public function mias()
    {
        $aportes = (new DonacionModel())->resumenDeUsuario((int) session()->get('id'));

        return view('Donaciones/mias', [
            'aportes'       => $aportes,
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
