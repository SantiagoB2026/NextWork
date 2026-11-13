<?php

if (! function_exists('dinero')) {
    /** 1500 -> "$1.500" | 1500.5 -> "$1.500,50" */
    function dinero($monto): string
    {
        $monto = (float) $monto;

        return '$' . number_format($monto, fmod($monto, 1.0) == 0.0 ? 0 : 2, ',', '.');
    }
}

if (! function_exists('porcentaje_texto')) {
    /** 12.5 -> "12,5" | 100.0 -> "100" */
    function porcentaje_texto($porcentaje): string
    {
        $texto = number_format((float) $porcentaje, 1, ',', '.');

        return rtrim(rtrim($texto, '0'), ',');
    }
}

if (! function_exists('ancho_barra')) {
    /** El ancho visual de la barra nunca pasa de 100 (el porcentaje real sí puede pasar) */
    function ancho_barra($porcentaje): string
    {
        return number_format(min(100, max(0, (float) $porcentaje)), 1, '.', '');
    }
}
