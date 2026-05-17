<?php
session_start();
require 'connect.php';

$prod_name = $_POST['prod_name'] ?? '';
$pet_name = $_POST['pet_name'] ?? '';
$company_name = $_POST['company_name'] ?? '';
$price = $_POST['price'] ?? 0;
$quantity = $_POST['quantity'] ?? 0;
$category = $_POST['category'] ?? 'General';

$result = apiPost('/products', [
    'name' => $prod_name,
    'category' => $category,
    'pet_type' => $pet_name,
    'qty' => (int) $quantity,
    'price' => (float) $price,
    'company' => $company_name
]);

if (isset($result['success']) && $result['success']) {
    $_SESSION["message"] = "New product added successfully!";
} else {
    $_SESSION["message"] = "Failed to add product!";
}

header('Location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-inventory.php');
exit();
?>