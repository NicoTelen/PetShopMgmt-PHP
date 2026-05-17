<?php
session_start();
require 'connect.php';

$prod_id = $_POST['update_prod_id'] ?? 0;
$prod_name = $_POST['update_prod_name'] ?? '';
$pet_name = $_POST['update_pet_name'] ?? '';
$company_name = $_POST['update_company_name'] ?? '';
$price = $_POST['update_price'] ?? 0;
$quantity = $_POST['update_quantity'] ?? 0;
$category = $_POST['update_category'] ?? 'General';

// Update product via Node.js API
$result = apiPut('/products/' . $prod_id, [
    'name' => $prod_name,
    'category' => $category,
    'pet_type' => $pet_name,
    'qty' => $quantity,
    'price' => $price,
    'company' => $company_name
]);

if (isset($result['success']) && $result['success']) {
    $_SESSION["message"] = "Product updated successfully!";
    $_SESSION["message_desc"] = "Changes reflected in the system.";
} else {
    $_SESSION["message"] = "Failed to update product!";
}

header('Location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-inventory.php');
exit();
?>