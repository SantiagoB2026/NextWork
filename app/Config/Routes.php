<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('productos', ['filter' => 'auth'], static function ($routes) {
 $routes->get('', 'Usuario::index');
 $routes->get('nuevo', 'Usuario::nuevo');
 $routes->post('guardar', 'Usuario::guardar');
 $routes->get('editar/(:num)', 'Usuario::editar/$1');
 $routes->post('actualizar/(:num)', 'Usuario::actualizar/$1');
 $routes->post('eliminar/(:num)', 'Usuario::eliminar/$1');
});

$routes->get('/', 'Home::index');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
