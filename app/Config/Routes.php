<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- RUTA RAÍZ Y PÚBLICAS ---
$routes->get('/', 'Home::index');
$routes->get('logout', 'Auth::logout');
$routes->get('search/results', 'Buscar::index');

// --- ETIQUETAS (públicas): listado general y filtro de proyectos por etiqueta ---
$routes->get('etiquetas', 'EtiquetasController::index');
$routes->get('etiqueta/(:segment)', 'EtiquetasController::ver/$1');

// --- PÁGINA DE UN PROYECTO (pública: cada rol ve su versión) ---
$routes->get('proyecto/(:num)', 'ProyectosController::ver/$1');

// --- RUTAS DE INVITADOS (Solo si NO estás logueado) ---
$routes->get('login', 'Auth::login', ['filter' => 'redirectIfAuth']);
$routes->post('login', 'Auth::processLogin');
$routes->get('register', 'Auth::register', ['filter' => 'redirectIfAuth']);
$routes->post('register', 'Auth::processRegister'); 

// --- RUTAS PROTEGIDAS GENERALES (Perfil de usuario) ---
$routes->group('perfil', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Perfil::index');
    $routes->get('(:num)', 'Perfil::index/$1');
});

// --- RESTRICCIÓN: SOLO DESARROLLADORES (Tus Proyectos) ---
$routes->group('desarrollador', ['filter' => 'isDesarrollador'], function($routes) {
    $routes->get('proyectos', 'ProyectosController::mios');
    $routes->get('proyectos/nuevo', 'ProyectosController::nuevo');
    $routes->post('proyectos/guardar', 'ProyectosController::guardar'); 
});

// --- RESTRICCIÓN: SOLO INVERSIONISTAS (donar y ver sus inversiones) ---
$routes->group('inversionista', ['filter' => 'isInversionista'], function($routes) {
    $routes->get('donaciones', 'DonacionesController::mias');
    $routes->get('proyectos/(:num)/donar', 'DonacionesController::formulario/$1');
    $routes->post('proyectos/(:num)/donar', 'DonacionesController::guardar/$1');
});

// --- RESTRICCIÓN: SOLO ADMINISTRADORES ---
$routes->group('Administrador', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Usuario::home');
    $routes->get('nuevo', 'Usuarios::nuevo');
    $routes->post('guardar', 'Usuarios::guardar');
    $routes->get('editar/(:num)', 'Administrador::editar/$1');
    $routes->post('actualizar/(:num)', 'Administrador::actualizar/$1');
    $routes->post('eliminar/(:num)', 'Administrador::eliminar/$1');

    // Gestión de etiquetas (AuthFilter exige tipo 'admin' bajo /Administrador)
    $routes->get('etiquetas', 'EtiquetasController::admin');
    $routes->post('etiquetas/guardar', 'EtiquetasController::guardar');
    $routes->post('etiquetas/eliminar/(:num)', 'EtiquetasController::eliminar/$1');
});
