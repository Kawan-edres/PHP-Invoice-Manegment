<style>
  .modal {
    position: absolute;
    width: 100vw;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal .modal-container {
    background-color: #eee;
    width: 50rem;
    height: 25rem;
    border-radius: 30px;
    padding: 30px;
  }
</style>

<h2>New Invoice</h2>
<div>
  <button class="add-product">Add product</button>
</div>

<div class="modal">
  <div class="modal-container">
    <h3>Products</h3>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Product name</th>
          <th scope="col">Price</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
</div>

<script>

</script>