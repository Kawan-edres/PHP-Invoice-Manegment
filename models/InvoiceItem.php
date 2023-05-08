<?php

namespace Details\models;

use Details\Database;
use Details\helpers\UtilHelper;

class InvoiceItem
{
  public int $invoice_id;
  public int $product_id;
  public int $qty;
  public float $price;

  public function __construct($invoice_id, $data)
  {
    $this->invoice_id = (int)$invoice_id;
    $this->product_id = (int)$data["id"];
    $this->qty = (int)$data["qty"];
    $this->price = (float)$data["price"];
  }

  public function save()
  {
    if ($this->qty < 0) $error[] = "Quantity can't be 0 or less";
    if (!empty($error))
      return $error;

    $db = Database::$db;
    return $db->createInvoiceItem($this);
  }
}
