<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['as' => 'home']);

// Rotte per Annunci
$routes->get('/annunci/index', 'AnnunciController::index', ['as' => 'annunci.index']);

$routes->group("", ["filter" => "login"], static function ($routes) {
    $routes->get('/annunci/new', 'AnnunciController::new', ['as' => 'annunci.new']);
    $routes->post('/annunci/create', 'AnnunciController::create', ['as' => 'annunci.create']);

});


$routes->group("admin", ["filter" => "group:superadmin"], static function ($routes) {
    $routes->get('users', 'UserController::index', ['as' => 'users.index']);
    $routes->get('users/create', 'UserController::create', ['as' => 'users.create']);
    $routes->post('users/store', 'UserController::store', ['as' => 'users.store']);
    $routes->get('users/edit/(:num)', 'UserController::edit/$1', ['as' => 'users.edit']);
    $routes->post('users/update/(:num)', 'UserController::update/$1', ['as' => 'users.update']);
    $routes->get('users/delete/(:num)', 'UserController::delete/$1', ['as' => 'users.delete']);
    $routes->get('users/(:num)/groups', 'UserController::groups/$1', ['as' => 'users.groups']);


});


// Rotte per Utenti
// $routes->get('/users', 'UserController::index', ['as' => 'users.index']);
// $routes->get('/users/create', 'UserController::create', ['as' => 'users.create']);
// $routes->post('/users/store', 'UserController::store', ['as' => 'users.store']);
// $routes->get('/users/edit/(:num)', 'UserController::edit/$1', ['as' => 'users.edit']);
// $routes->post('/users/update/(:num)', 'UserController::update/$1', ['as' => 'users.update']);
// $routes->get('/users/delete/(:num)', 'UserController::delete/$1', ['as' => 'users.delete']);
// $routes->post('/my_register', 'MyRegisterController::registerAction', ['as' => 'register']);

// Rotte di autenticazione (CodeIgniter Shield)
service('auth')->routes($routes);


