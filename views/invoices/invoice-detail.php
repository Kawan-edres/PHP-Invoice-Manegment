<main class="container">
  <h2>Invoice details</h2>
  <table class="table mt-3">
    <thead>
      <tr>
        <th>#</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total Price</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $key => $item) : ?>
        <tr>
          <td><?= $key + 1 ?></td>
          <td><?= $item['name'] ?></td>
          <td><?= $item['quantity'] ?></td>
          <td>$<?= $item['price'] ?></td>
          <td>$<?= $item['price'] * $item["quantity"] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>