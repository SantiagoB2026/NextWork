<?php

namespace App\Libraries;

use App\Models\ImagenModel;
use CodeIgniter\HTTP\IncomingRequest;

/** Subida y borrado de las imágenes de un proyecto (public/uploads/proyectos) */
class ImagenesProyecto
{
    public const MAX_POR_PROYECTO = 6;
    public const MAX_BYTES        = 2097152; // 2 MB

    private const TIPOS = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    /** Guarda las imágenes enviadas en el campo "imagenes[]". Devuelve ['guardadas' => n, 'errores' => [...]] */
    public static function guardar(int $idProyecto, IncomingRequest $request, string $campo = 'imagenes'): array
    {
        $archivos  = $request->getFileMultiple($campo) ?: [];
        $modelo    = new ImagenModel();
        $existentes = $modelo->contar($idProyecto);
        $guardadas = 0;
        $errores   = [];

        $carpeta = FCPATH . 'uploads/proyectos';
        if (! is_dir($carpeta)) {
            mkdir($carpeta, 0755, true);
        }

        foreach ($archivos as $archivo) {
            if ($archivo->getError() === UPLOAD_ERR_NO_FILE) {
                continue; // no eligió ninguna imagen
            }

            $nombre = $archivo->getClientName();

            if ($existentes + $guardadas >= self::MAX_POR_PROYECTO) {
                $errores[] = 'Máximo ' . self::MAX_POR_PROYECTO . ' imágenes por proyecto.';
                break;
            }

            if (! $archivo->isValid()) {
                $errores[] = "«{$nombre}» no se pudo subir.";
                continue;
            }

            if ($archivo->getSize() > self::MAX_BYTES) {
                $errores[] = "«{$nombre}» pesa más de 2 MB.";
                continue;
            }

            // Se comprueba el contenido real del archivo, no solo la extensión
            $mime = $archivo->getMimeType();
            if (! isset(self::TIPOS[$mime]) || @getimagesize($archivo->getTempName()) === false) {
                $errores[] = "«{$nombre}» no es una imagen válida (solo JPG, PNG o WebP).";
                continue;
            }

            $guardadoComo = bin2hex(random_bytes(12)) . '.' . self::TIPOS[$mime];

            try {
                $archivo->move($carpeta, $guardadoComo);
            } catch (\Throwable $e) {
                $errores[] = "No se pudo guardar «{$nombre}».";
                continue;
            }

            $modelo->insert(['id_proyecto' => $idProyecto, 'archivo' => $guardadoComo]);
            $guardadas++;
        }

        return ['guardadas' => $guardadas, 'errores' => $errores];
    }

    public static function borrarArchivo(string $archivo): void
    {
        @unlink(FCPATH . 'uploads/proyectos/' . basename($archivo));
    }
}
