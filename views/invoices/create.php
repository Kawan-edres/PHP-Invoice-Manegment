<style>
  .modal {
    position: absolute;
    width: 100vw;
    height: 100vh;
    display: none;
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

  .select-product:hover {
    cursor: pointer;
    background-color: rgb(120, 120, 120);
  }
</style>

<main class="container">
  <div id="alert"></div>

  <h2>New Invoice</h2>
  <div>
    <button class="add-product">Add product</button>
    <div class="the-table">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Product</th>
            <th scope="col">Price</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody class="forTheTable"></tbody>
      </table>
    </div>
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
          <?php foreach ($products as $i => $product) : ?>
            <tr class="select-product" id="<?php echo $product["id"] ?>" product-name="<?php echo $product["name"]  ?>" price="<?php echo $product["price"] ?>">
              <th scope="row"><?php echo $i + 1 ?></th>
              <td><?php echo $product["name"] ?></td>
              <td>$<?php echo $product["price"] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="d-flex justify-content-between">
    <div class="d-flex">
      <p>Total:</p>
      <p class="total ml-1">$0</p>
    </div>
    <button class="confirmBtn">Confirm</button>
  </div>
</main>

<script>
  let alertDiv = document.getElementById('alert');

  const AllRows = document.querySelectorAll(".select-product");
  const tbody = document.querySelector(".forTheTable");
  const total = document.querySelector(".total");
  const confirmBtn = document.querySelector(".confirmBtn");
  const addProductBtn = document.querySelector(".add-product");
  addProductBtn.addEventListener("click", () => {
    document.querySelector(".modal").style.display = "flex";
  });
  console.log(tbody.innerHTML);
  console.log(AllRows);

  let data = [];

  const checkTotal = () => {
    total.textContent = data.reduce((newValue, currentValue) => {
      return `$${currentValue.price * currentValue.qty + newValue}`
    }, 0);
    // console.log(isis)
  };

  AllRows.forEach(tr => {
    const addToCheckout = (e) => {
      const price = tr.getAttribute("price");
      const name = tr.getAttribute("product-name");

      const findProduct = data.find(product => product.id === tr.id);
      if (findProduct) {
        const index = data.indexOf(findProduct);
        data[index].qty++;
      } else {
        data.push({
          name,
          price,
          id: tr.id,
          qty: 1
        });
      }
      checkTotal()

      tbody.innerHTML = data.map((product, index) => `<tr><th>${index+1}</th>
      <td>${product.name}</td>
      <td>${product.price}</td/>
      <td><input value="${product.qty}" type='number' index='${index}'/></td/>
      </tr>`);
      document.querySelectorAll("input[type='number']").forEach(input => {
        input.addEventListener("input", (e) => {
          data[e.target.getAttribute("index")].qty = e.target.value;
          checkTotal()
        })
      })
      document.querySelector(".modal").style.display = "none";
    }

    tr.addEventListener("click", addToCheckout);
  });

  confirmBtn.addEventListener("click", () => {
    fetch("/checkout/create", {
      method: "POST",
      body: JSON.stringify({
        data,
        total: total.textContent.replace("$", "")
      }),
      headers: {
        "Content-Type": "application/json",
      },
    }).then(response => {
      if (response.ok) {
        return response.json();
      } else {
        throw new Error('Network response was not ok.');
      }
    }).then(responseJson => {
      console.log(responseJson, "data")
      if (responseJson.hasOwnProperty('error')) {
        alertDiv.classList.add('alert', 'alert-danger');
        alertDiv.textContent = responseJson.error;
      } else if (responseJson.hasOwnProperty('success')) {
        alertDiv.classList.add('alert', 'alert-success');
        alertDiv.textContent = 'created successful!';
        window.location.href = "/checkout";
      }
    })
  })
</script>