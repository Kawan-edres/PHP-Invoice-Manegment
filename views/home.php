<?php


$userid = $_SESSION['user_id'] ?? "";
$username = $_SESSION['user_name'] ?? "";
$useremail = $_SESSION['user_email'] ?? "";
// var_dump($_SESSION["is_admin"]);
if (!$userid) {
    header("Location:/");
    exit();
}


?>


<div class="container-fluid">
    <h2>Welcome <?= $username; ?></h2>
</div>