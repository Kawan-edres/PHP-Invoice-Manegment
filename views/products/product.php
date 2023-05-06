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

<div class="container-fluid">
<h1>Product List</h1>
<?php ?>
 
 <p>
 <a href="/products/create" class="btn btn-success">Create Product</a>
</p>

<form action="" method="get">
 <div class="input-group mb-3">
     <input type="text" class="form-control" placeholder="Search for Products" name="search" value="<?php echo $search ?>">
     <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
 </div>
</form>
<table class="table">
 <thead>
     <tr>
         <th scope="col">#</th>
         <th scope="col">Image</th>
         <th scope="col">Name</th>
         <th scope="col">Price</th>
         <th scope="col">Create_Date</th>
         <th scope="col">Action</th>

     </tr>
 </thead>
 <tbody>

     <?php foreach ($products as $i => $product) : ?>
         <tr>
             <th scope="row"><?php echo $i + 1 ?></th>
             <td>
                <?php if($product['image']): ?>
                <img class="product-img" src="/assets/<?php echo $product['image'] ?>">
                <?php endif ?>
             </td>
             <td><?php echo $product["name"] ?></td>
             <td><?php echo $product["price"] ?></td>
             <td><?php echo $product["create_date"] ?></td>
             <td>

             <a href="/products/update?id=<?= $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>

                 <form style="display: inline-block;" method="post" action="/products/delete">
                     <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                     <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                 </form>

             </td>

         </tr>

     <?php endforeach; ?>
 </tbody>
</table>

</div>