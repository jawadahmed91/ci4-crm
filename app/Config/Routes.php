<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ======================
// Public Routes (No Auth)
// ======================
$routes->get('/login', 'Auth::login');
$routes->post('/auth/attemptLogin', 'Auth::attemptLogin');

$routes->get('/api/sso/token', 'Api\SsoController::getToken');
// ======================
// Protected Routes (Require Auth)
// ======================
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Dashboard
    $routes->get('/dashboard', 'Home::index');

    // Logout
    $routes->get('/auth/logout', 'Auth::logout');

    // ======================
    // Customers Module
    // ======================
    $routes->get('/customers', 'Customers::index');
    $routes->get('/customers/create', 'Customers::create');
    $routes->post('/customers/store', 'Customers::store');
    $routes->get('/customers/edit/(:num)', 'Customers::edit/$1');
    $routes->post('/customers/update/(:num)', 'Customers::update/$1');
    $routes->get('/customers/delete/(:num)', 'Customers::delete/$1');

    // ======================
    // Sales Team Module
    // ======================
    $routes->get('/sales_team', 'SalesTeam::index');
    $routes->get('/sales_team/create', 'SalesTeam::create');
    $routes->post('/sales_team/store', 'SalesTeam::store');
    $routes->get('/sales_team/edit/(:num)', 'SalesTeam::edit/$1');
    $routes->post('/sales_team/update/(:num)', 'SalesTeam::update/$1');
    $routes->get('/sales_team/delete/(:num)', 'SalesTeam::delete/$1');

    // ======================
    // Suppliers Module
    // ======================
    $routes->get('/suppliers', 'Suppliers::index');
    $routes->get('/suppliers/create', 'Suppliers::create');
    $routes->post('/suppliers/store', 'Suppliers::store');
    $routes->get('/suppliers/edit/(:num)', 'Suppliers::edit/$1');
    $routes->post('/suppliers/update/(:num)', 'Suppliers::update/$1');
    $routes->get('/suppliers/delete/(:num)', 'Suppliers::delete/$1');
});
