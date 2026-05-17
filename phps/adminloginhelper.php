<?php
session_start();

$emailid = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';

if ($emailid == "admin" && $password == "admin123") {
    $_SESSION["admin"] = "admin";
    header('location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-inventory.php');
} else {
    $_SESSION["message"] = "Login Failed.";
    $_SESSION["message_desc"] = "Cross-verify your user ID or password.";
    header('location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-sign-in.html');
}
exit();
?>