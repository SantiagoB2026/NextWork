<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('productos', ['filter' => 'auth'], static function ($routes) {
 $routes->get('', 'Usuario::index');
 $routes->get('nuevo', 'Usuarios::nuevo');
 $routes->post('guardar', 'Usuarios::guardar');
 $routes->get('editar/(:num)', 'Usuarios::editar/$1');
 $routes->post('actualizar/(:num)', 'Usuaris::actualizar/$1');
 $routes->post('eliminar/(:num)', 'Usuarios::eliminar/$1');
});

$routes->get('/', 'Home::index');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
