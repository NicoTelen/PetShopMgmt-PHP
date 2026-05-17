<?php
session_start();
require 'connect.php';

$emailid = $_GET['emailid'] ?? '';
$password = $_GET['password'] ?? '';

// Login via Node.js API
$result = apiPost('/customers/login', [
    'email' => $emailid,
    'password' => $password
]);

if (isset($result['success']) && $result['success']) {
    $_SESSION["user"] = $result['customer']['fname'];
    $_SESSION["userid"] = $result['customer']['id'];
    $_SESSION["email"] = $result['customer']['email'];
    header("location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/home.php");
} else {
    $_SESSION["message"] = "Failed to login!";
    header("location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/index.html");
}
exit();
?>