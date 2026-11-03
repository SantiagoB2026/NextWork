<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- RUTA RAÍZ Y PÚBLICAS ---
$routes->get('/', 'Home::index');
$routes->get('logout', 'Auth::logout');
$routes->get('search/results', 'Buscar::index');

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
    $routes->get('proyectos/nuevo', 'ProyectosController::nuevo');
    $routes->post('proyectos/guardar', 'ProyectosController::guardar'); 
});

// --- RESTRICCIÓN: SOLO ADMINISTRADORES ---
$routes->group('Administrador', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Usuario::home');
    $routes->get('nuevo', 'Usuarios::nuevo');
    $routes->post('guardar', 'Usuarios::guardar');
    $routes->get('editar/(:num)', 'Administrador::editar/$1');
    $routes->post('actualizar/(:num)', 'Administrador::actualizar/$1');
    $routes->post('eliminar/(:num)', 'Administrador::eliminar/$1');
});
