<?php

namespace Details\controllers;

use Details\models\Invoice;
use Details\models\InvoiceItem;
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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = json_decode(file_get_contents("php://input"), true);
      $invoice = new Invoice($userid);

      $invoice->load($data["total"], $userid);
      $response = $invoice->save();

      if (!empty($response["error"])) {
        header('Content-Type: application/json');
        echo json_encode(['error' => $response["error"]]);
        exit;
      }

      foreach ($data["data"] as $invoiceItem) {
        $invoice_item = new InvoiceItem($response, $invoiceItem);
        $responseInvoiceItem = $invoice_item->save();
        if (!empty($responseInvoiceItem["error"])) {
          header('Content-Type: application/json');
          echo json_encode(['error' => $responseInvoiceItem["error"]]);
          exit;
        }
      }

      header('Content-Type: application/json');
      echo json_encode(['success' => "Invoice created successfully!"]);
      exit;

      // $router->renderView("invoices/create", ["post" => $data]);
    } else {
      $products = $router->db->getProducts();
      $router->renderView('invoices/create', ['errors' => $errors, "products" => $products]);
    }
  }
}
