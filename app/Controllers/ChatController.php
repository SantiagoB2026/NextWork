<?php

namespace App\Controllers;

use App\Models\MensajeModel;
use App\Models\UserModel;

class ChatController extends BaseController
{
    private const MAX_CARACTERES = 500;

    /** mensajes : bandeja con todas mis conversaciones */
    public function index()
    {
        return view('Chat/index', [
            'conversaciones' => (new MensajeModel())->conversacionesDe((int) session()->get('id')),
        ]);
    }

    /** mensajes/{id} : conversación con otro usuario */
    public function conversacion(int $idOtro)
    {
        [$otro, $error] = $this->validarInterlocutor($idOtro);

        if ($otro === null) {
            return redirect()->to('mensajes')->with('error', $error);
        }

        $yo      = (int) session()->get('id');
        $model   = new MensajeModel();
        $model->marcarLeidos($idOtro, $yo);

        $mensajes = array_map(
            static fn ($m) => MensajeModel::formatear($m, $yo),
            $model->entre($yo, $idOtro)
        );

        return view('Chat/conversacion', [
            'otro'     => $otro,
            'mensajes' => $mensajes,
            'ultimoId' => $mensajes ? end($mensajes)['id'] : 0,
        ]);
    }

    /** POST mensajes/{id}/enviar : guarda un mensaje y lo devuelve en JSON */
    public function enviar(int $idOtro)
    {
        [$otro, $error] = $this->validarInterlocutor($idOtro);

        if ($otro === null) {
            return $this->respuestaError($error, 403);
        }

        $texto = trim((string) $this->request->getPost('texto'));

        if ($texto === '' || mb_strlen($texto) > self::MAX_CARACTERES) {
            return $this->respuestaError('El mensaje debe tener entre 1 y ' . self::MAX_CARACTERES . ' caracteres.', 422);
        }

        $yo    = (int) session()->get('id');
        $model = new MensajeModel();
        $id    = $model->insert([
            'id_emisor'   => $yo,
            'id_receptor' => $idOtro,
            'texto'       => $texto,
        ]);

        if (! $id) {
            return $this->respuestaError('No se pudo guardar el mensaje.', 500);
        }

        return $this->response->setJSON([
            'ok'      => true,
            'mensaje' => MensajeModel::formatear($model->find($id), $yo),
            'csrf'    => csrf_hash(), // el token cambia en cada POST
        ]);
    }

    /** GET mensajes/{id}/nuevos?desde=ID : mensajes posteriores al último que ya tiene el navegador */
    public function nuevos(int $idOtro)
    {
        [$otro, $error] = $this->validarInterlocutor($idOtro);

        if ($otro === null) {
            return $this->respuestaError($error, 403);
        }

        $yo      = (int) session()->get('id');
        $desde   = max(0, (int) $this->request->getGet('desde'));
        $model   = new MensajeModel();
        $nuevos  = $model->entre($yo, $idOtro, $desde);

        if (! empty($nuevos)) {
            $model->marcarLeidos($idOtro, $yo);
        }

        return $this->response->setJSON([
            'ok'       => true,
            'mensajes' => array_map(static fn ($m) => MensajeModel::formatear($m, $yo), $nuevos),
        ]);
    }

    /** Devuelve [usuario, null] si se puede chatear con él, o [null, motivo] si no */
    private function validarInterlocutor(int $idOtro): array
    {
        if ($idOtro === (int) session()->get('id')) {
            return [null, 'No puedes enviarte mensajes a ti mismo.'];
        }

        $otro = (new UserModel())->find($idOtro);

        if ($otro === null) {
            return [null, 'Ese usuario no existe.'];
        }

        if (! MensajeModel::puedenChatear(session()->get('tipo'), $otro['tipo'] ?? null)) {
            return [null, 'No puedes chatear con este tipo de cuenta.'];
        }

        return [$otro, null];
    }

    private function respuestaError(string $mensaje, int $codigo)
    {
        return $this->response->setStatusCode($codigo)->setJSON([
            'ok'    => false,
            'error' => $mensaje,
            'csrf'  => csrf_hash(),
        ]);
    }
}
