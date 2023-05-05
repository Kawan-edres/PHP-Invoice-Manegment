<?php
session_start();

$userid= $_SESSION['user_id'] ?? "";
$username= $_SESSION['user_name'] ?? "";
$useremail= $_SESSION['user_email'] ?? "";
if(!$userid)header("Location:/")


?>

<div class="container mt-5">
    <h2>Welcome <?= $username; ?></h2>
    <h3>your email is :<?= $useremail; ?> </h3>
    <h3>your id is: <?= $userid; ?> </h3>
    <h3>You are now signed in!</h3>
    <h4>sign out <a href='/logout'>Logout</a> </h4>
</div>

