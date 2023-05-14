<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use Details\controllers\ProductController;
use Details\controllers\UserController;
use Details\controllers\InvoiceController;
use Details\Router;

$router = new Router();
$userController = new UserController();



$router->get('/', [$userController, 'index']);

$router->get('/signin', [$userController, 'signin']);
$router->post('/signin', [$userController, 'signin']);

$router->get('/signup', [$userController, 'signup']);
$router->post('/signup', [$userController, 'signup']);

$router->get('/home', [$userController, 'home']);
$router->post('/home', [$userController, 'home']);

$router->get('/logout', [$userController, 'logout']);
$router->post('/logout', [$userController, 'logout']);


$router->get('/dashboard', [$userController, 'dashboard']);
$router->post('/dashboard', [$userController, 'dashboard']);

$router->post('/delete-user', [$userController, 'dashboard']);

// products 
$router->get('/products', [ProductController::class, 'index']);
$router->get('/products/create', [ProductController::class, 'create']);
$router->post('/products/create', [ProductController::class, 'create']);
$router->get('/products/update', [ProductController::class, 'update']);
$router->post('/products/update', [ProductController::class, 'update']);
$router->post('/products/delete', [ProductController::class, 'delete']);

$router->get('/checkout', [InvoiceController::class, 'index']);
$router->get('/checkout/create', [InvoiceController::class, 'create']);
$router->post('/checkout/create', [InvoiceController::class, 'create']);

$router->resolve();
