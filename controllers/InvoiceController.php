<?php

namespace Details\controllers;

use Details\Router;


$userid = $_SESSION['user_id'] ?? "";
$username = $_SESSION['user_name'] ?? "";

if (!$userid) {
  header("Location:/");
  exit();
}

class InvoiceController
{
  public static function index(Router $router) //atwani xo instance drust bkay la router 
  {
    $search = $_GET['search'] ?? '';
    $invoices = $router->db->getInvoices($search);
    $router->renderView('invoices/invoices', [
      'invoices' => $invoices,
      'search' => $search
    ]);
  }

  public static function create(Router $router)
  {
    $userid = $_SESSION['user_id'];
    $errors = [];
    $products = $router->db->getProducts();
    $router->renderView('invoices/create', ['errors' => $errors, "products" => $products]);
  }
}
