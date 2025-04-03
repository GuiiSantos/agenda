<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'WebController::index');
$routes->get('/register', 'WebController::register');
$routes->post('/createAccount', 'WebController::createAccount');
$routes->get('/calendar', 'WebController::calendar');
$routes->get('/login', 'WebController::login');
$routes->post('/authenticate', 'WebController::authenticate');
$routes->get('/activities', 'WebController::index');
$routes->get('/activities/getActivities', 'WebController::getActivities');
$routes->post('/activities/create', 'WebController::createActivities');
$routes->post('/activities/update', 'WebController::updateActivities');
$routes->delete('/activities/delete/(:num)', 'WebController::deleteActivity/$1');
$routes->get('/activities/getCalendarActivities', 'WebController::getCalendarActivities');
$routes->get('/logout', 'WebController::logout');
