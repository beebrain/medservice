<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/ExampleController/(:any)', 'ExampleController::$1');
$routes->get('/ai/get-count', 'AiController::getCount');
$routes->get('/ai/reference-ranges', 'AiController::referenceRanges');
