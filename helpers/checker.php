<?php
session_start();

$userid= $_SESSION['user_id'] ?? "";
$username= $_SESSION['user_name'] ?? "";
$useremail= $_SESSION['user_email'] ?? "";
if(!$userid && $_SERVER['REQUEST_URI'] !== "/") {
    header("Location:/");
    exit();
}


?>