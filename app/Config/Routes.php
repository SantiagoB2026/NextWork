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
    $routes->get('proyectos/nuevo', 'ProyectosController::nuevo');
});

// Ponla aquí afuera para que sea exactamente 'perfil/guardarProyecto'
$routes->post('perfil/guardarProyecto', 'ProyectosController::guardar');

$routes->get('perfil', 'Perfil::index');    
$routes->get('perfil/(:num)', 'Perfil::index/$1');

// --- RUTAS PÚBLICAS (Accesibles por cualquiera) ---
// Quitamos el filtro de aquí para evitar el bucle infinito en el Home
$routes->get('/', 'Home::index');
$routes->get('logout', 'Auth::logout');
$routes->get('search/results', 'Buscar::index');

// --- RUTAS DE INVITADOS (Solo si NO estás logueado) ---
// Si ya estás logueado, 'redirectIfAuth' te sacará de acá mandándote al Home '/'
$routes->get('login', 'Auth::login', ['filter' => 'redirectIfAuth']);
$routes->post('login', 'Auth::processLogin');
$routes->get('register', 'Auth::register', ['filter' => 'redirectIfAuth']);
$routes->post('register', 'Auth::processRegister'); 

// --- RUTAS PROTEGIDAS PARA USUARIOS LOGUEADOS ---
$routes->group('perfil', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Perfil::index');
    $routes->get('(:num)', 'Perfil::index/$1');
});

// --- RESTRICCIÓN: SOLO DESARROLLADORES ---
$routes->group('desarrollador', ['filter' => 'isDesarrollador'], function($routes) {
    $routes->get('crear-proyecto', 'Proyecto::crear'); 
    $routes->post('guardar-proyecto', 'Proyecto::guardar');
});

// --- RESTRICCIÓN: SOLO ADMINISTRADORES ---
$routes->group('Administrador', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Home::index'); 
    $routes->get('nuevo', 'Home::nuevo');
    $routes->post('guardar', 'Home::guardar');
    $routes->get('editar/(:num)', 'Home::editar/$1');
    $routes->post('actualizar/(:num)', 'Home::actualizar/$1');
    $routes->post('eliminar/(:num)', 'Home::eliminar/$1');
});

// --- RUTA COMPATIBLE PROYECTOS ---
$routes->post('proyectos/guardar', 'Proyecto::guardar'); 
