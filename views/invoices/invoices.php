<main class="container">
  <div>
    <h2>Invoices</h2>
    <p>
      <a href="/checkout/create" class="btn btn-success">Add Invoice</a>
    </p>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Invoice date</th>
        <th scope="col">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($invoices as $i => $invoice) :
      ?>
        <tr>
          <th scope="row">
            <a href="/checkout/detail/<?php echo $invoice["id"] ?>">
              <?php echo $i + 1 ?>
            </a>
          </th>
          <td>
            <?php echo $invoice["invoice_date"] ?>
          </td>
          <td>
            $<?php echo $invoice["total"] ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</main>