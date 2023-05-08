<?php

namespace Details\models;

use Details\Database;
use Details\helpers\UtilHelper;

class Invoice
{
  public ?int $id = null;
  public string $user_id;
  public string $invoice_date;
  public string $total;

  public function __construct($userid)
  {
    $this->user_id = $userid;
  }

  public function load($data, $userId)
  {
    $this->id = $data['id'] ?? null;
    $this->user_id = $userId;
    $this->invoice_date = $data['invoice_date'];
    $this->total = $data['total'];
  }
}
