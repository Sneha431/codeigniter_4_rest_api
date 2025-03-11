<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/(:num)', 'Home::index/$1');
$routes->get('delete/(:num)', 'Home::delete/$1');
$routes->get('status/(:num)/(:any)', 'Home::status/$1/$2');