<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$userid= $_SESSION['user_id'] ?? "";
$username= $_SESSION['user_name'] ?? "";
$useremail= $_SESSION['user_email'] ?? "";
if(!$userid) {
    header("Location:/");
    exit();
}
 ?>
 <div class="update-section">


<h1>Update Product </h1>
<?php if (!empty($errors)): ?>
   <div class="alert alert-danger">
      <?php foreach ($errors as $error): ?>
           <div><?php echo $error ?></div>
      <?php endforeach; ?>
   </div>
<?php endif; ?>

<div id="alert"></div>

<form id="update-form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="update">
    <?php if ($product['image']): ?>
        <img class="update-img" src="/assets/<?php echo $product['image'] ?>" class="product-img-view">

    <?php endif; ?>
    <div class="form-group">
        <label>Product Image</label><br>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $product['name'] ?>">
    </div>
    <div class="form-group">
        <label>Product description</label>
        <textarea class="form-control" name="description"><?php echo $product['description'] ?></textarea>
    </div>
    <div class="form-group">
        <label>Product price</label>
        <input type="number" step=".01" name="price" class="form-control" value="<?php echo $product['price'] ?>">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>

<!-- <script>
    var form = document.getElementById('update-form');
    var alertDiv = document.getElementById('alert');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(form);
        console.log(formData)

        fetch('../../index.php?action=update_product', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Network response was not ok.');
                }
            })
            .then(data => {
                console.log(data);
                form.reset();

                if (data.hasOwnProperty('error')) {
                    alertDiv.classList.add('alert', 'alert-danger');
                    alertDiv.textContent = data.error;
                } else if (data.hasOwnProperty('success')) {
                    alertDiv.classList.add('alert', 'alert-success');
                    alertDiv.textContent = 'Sign up successful!';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script> -->
