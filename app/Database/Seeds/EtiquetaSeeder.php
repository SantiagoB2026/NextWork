<?php

namespace App\Database\Seeds;

use App\Models\EtiquetaModel;
use CodeIgniter\Database\Seeder;

class EtiquetaSeeder extends Seeder
{
    public function run()
    {
        // Cambia esta lista por las secciones reales de tu plataforma
        $nombres = [
            'Tecnología', 'Arte', 'Música', 'Videojuegos', 'Educación',
            'Salud', 'Ciencia', 'Moda', 'Comida', 'Impacto social',
        ];

        $model = new EtiquetaModel();

        foreach ($nombres as $nombre) {
            if (! $model->where('slug', EtiquetaModel::crearSlug($nombre))->first()) {
                $model->insert(['nombre' => $nombre]);
            }
        }
    }
}
