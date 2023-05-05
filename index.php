<?php

require_once __DIR__ . '/vendor/autoload.php';

use Details\controllers\UserController;
use Details\Router;

$router = new Router();
$userController = new UserController();



$router->get('/', [$userController, 'signin']);
$router->post('/', [$userController, 'signin']);

$router->get('/signin', [$userController, 'signin']);
$router->post('/signin', [$userController, 'signin']);

$router->get('/signup', [$userController, 'signup']);
$router->post('/signup', [$userController, 'signup']);

$router->get('/home', [$userController, 'home']);
$router->post('/home', [$userController, 'home']);

$router->get('/logout', [$userController, 'logout']);
$router->post('/logout', [$userController, 'logout']);
$router->resolve();
