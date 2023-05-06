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
<h1>Update Product </h1>
<?php include "_form.php"; ?>