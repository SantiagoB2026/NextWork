<?php

namespace App\Controllers;

use App\Models\ColaboradorModel;
use App\Models\ProyectoModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ColaboradoresController extends BaseController
{
    /** POST desarrollador/proyectos/{id}/invitar : el creador invita a otro desarrollador por alias */
    public function invitar(int $idProyecto)
    {
        $yo       = (int) session()->get('id');
        $proyecto = (new ProyectoModel())->find($idProyecto);

        if ($proyecto === null) {
            throw PageNotFoundException::forPageNotFound('No existe el proyecto solicitado.');
        }

        $volver = redirect()->to('proyecto/' . $idProyecto);

        if ((int) ($proyecto['id_usuario'] ?? 0) !== $yo) {
            return $volver->with('error', 'Solo el creador del proyecto puede invitar colaboradores.');
        }

        $alias = ltrim(trim((string) $this->request->getPost('alias')), '@');

        if ($alias === '') {
            return $volver->with('error', 'Escribe el alias del desarrollador que quieres invitar.');
        }

        $invitado = (new UserModel())->where('alias', $alias)->first();

        if ($invitado === null || ($invitado['tipo'] ?? null) !== 'desarrollador') {
            return $volver->with('error', 'No existe un desarrollador con ese alias.');
        }

        $idInvitado = (int) $invitado['id_usuario'];

        if ($idInvitado === $yo) {
            return $volver->with('error', 'Ya eres el creador de este proyecto.');
        }

        $colaboradores = new ColaboradorModel();

        if ($colaboradores->existe($idProyecto, $idInvitado) !== null) {
            return $volver->with('error', 'Ese desarrollador ya fue invitado o ya forma parte del equipo.');
        }

        $colaboradores->invitar($idProyecto, $idInvitado);

        return $volver->with('exito', 'Invitación enviada a @' . $invitado['alias'] . '.');
    }

    /** POST desarrollador/invitaciones/{id_proyecto}/aceptar */
    public function aceptar(int $idProyecto)
    {
        return $this->responder($idProyecto, true);
    }

    /** POST desarrollador/invitaciones/{id_proyecto}/rechazar */
    public function rechazar(int $idProyecto)
    {
        return $this->responder($idProyecto, false);
    }

    private function responder(int $idProyecto, bool $aceptar)
    {
        $yo            = (int) session()->get('id');
        $colaboradores = new ColaboradorModel();
        $invitacion    = $colaboradores->existe($idProyecto, $yo);

        if ($invitacion === null || $invitacion['estado'] !== 'pendiente') {
            return redirect()->to('desarrollador/proyectos')->with('error', 'No tienes una invitación pendiente para ese proyecto.');
        }

        $colaboradores->responder($idProyecto, $yo, $aceptar);

        if ($aceptar) {
            return redirect()->to('proyecto/' . $idProyecto)->with('exito', '¡Ahora eres parte del equipo de este proyecto!');
        }

        return redirect()->to('desarrollador/proyectos')->with('exito', 'Invitación rechazada.');
    }
}
