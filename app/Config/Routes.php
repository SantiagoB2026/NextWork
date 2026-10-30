<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('perfil', [\App\Controllers\Perfil::class, 'index']);
$routes->get('/', 'Home::index');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::processRegister'); 
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::processLogin');      
$routes->get('/logout', 'Auth::logout');
$routes->group('Administrador', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Usuario::home');
    $routes->get('nuevo', 'Usuarios::nuevo');
    $routes->post('guardar', 'Usuarios::guardar');
    $routes->get('editar/(:num)', 'Administrador::editar/$1');
    $routes->post('actualizar/(:num)', 'Administrador::actualizar/$1');
    $routes->post('eliminar/(:num)', 'Administrador::eliminar/$1');
});
$routes->group('desarrollador', ['filter' => 'isDesarrollador'], function($routes) {
    $routes->get('crear-proyecto', 'Proyectos::crear');
    $routes->post('guardar-proyecto', 'Proyectos::guardar');
});
$routes->get('perfil', 'Perfil::index');
$routes->get('perfil/(:num)', 'Perfil::index/$1');
$routes->get('search/results', 'Buscar::index');

$routes->get('/', 'Home::index', ['filter' => 'redirectIfAuth']);
$routes->get('login', 'Auth::login', ['filter' => 'redirectIfAuth']);

