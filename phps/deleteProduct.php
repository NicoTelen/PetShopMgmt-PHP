<?php
session_start();
require 'connect.php';

$prod_id = $_GET['prodid'] ?? 0;

// Check for pending orders via Node.js API
$orders = apiGet('/orders/pending');
$hasPendingOrders = false;

if ($orders) {
    foreach ($orders as $order) {
        if ($order['product_id'] == $prod_id) {
            $hasPendingOrders = true;
            break;
        }
    }
}

if ($hasPendingOrders) {
    $_SESSION["message"] = "Cannot delete this product.";
    $_SESSION['message_desc'] = "Mark all orders of this product as shipped first.";
} else {
    // Delete via Node.js API
    $result = apiDelete('/products/' . $prod_id);
    if (isset($result['success']) && $result['success']) {
        $_SESSION["message"] = "Product deleted successfully!";
    } else {
        $_SESSION["message"] = "Failed to delete product!";
    }
}

header('Location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-inventory.php');
exit();
?>