<?php

require_once __DIR__ . '/vendor/autoload.php';

use Details\controllers\ProductController;
use Details\controllers\UserController;
use Details\Router;

$router = new Router();
$userController = new UserController();
$productController = new ProductController();



$router->get('/', [$userController, 'index']);
$router->post('/', [$userController, 'index']);

$router->get('/signin', [$userController, 'signin']);
$router->post('/signin', [$userController, 'signin']);

$router->get('/signup', [$userController, 'signup']);
$router->post('/signup', [$userController, 'signup']);

$router->get('/home', [$userController, 'home']);
$router->post('/home', [$userController, 'home']);

$router->get('/logout', [$userController, 'logout']);
$router->post('/logout', [$userController, 'logout']);

// products 
// $router->get('/products',[$productController,'index']);
// $router->get('/products/create',[$productController,'create']);
// $router->post('/products/create',[$productController,'create']);
// $router->get('/products/update',[$productController,'update']);
// $router->post('/products/update',[$productController,'update']);
// $router->post('/products/delete',[$productController,'delete']);
$router->resolve();
