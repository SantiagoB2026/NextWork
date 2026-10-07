<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('Administrador', ['filter' => 'auth'], static function ($routes) {
 $routes->get('/', 'Usuario::home');
 $routes->get('nuevo', 'Usuarios::nuevo');
 $routes->post('guardar', 'Usuarios::guardar');
 $routes->get('editar/(:num)', 'Administrador::editar/$1');
 $routes->post('actualizar/(:num)', 'Administrador::actualizar/$1');
 $routes->post('eliminar/(:num)', 'Administrador::eliminar/$1');
});

$routes->get('/', 'Home::index');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
