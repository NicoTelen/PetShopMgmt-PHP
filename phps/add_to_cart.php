<?php
session_start();
require 'connect.php';

$product = $_GET['product'] ?? '';
$qty = $_GET['qty'] ?? 1;
$userid = $_SESSION['userid'];

// Get product details from Node.js API
$products = apiGet('/products');
$prodid = null;

if ($products) {
    foreach ($products as $p) {
        if ($p['name'] == $product) {
            $prodid = $p['id'];
            break;
        }
    }
}

if ($prodid) {
    // Add to cart in MySQL (cart stays in local DB)
    $query = "INSERT into cart(userid, prodid, qty) 
              VALUES ('$userid', '$prodid', '$qty') 
              ON DUPLICATE KEY UPDATE qty = qty + $qty";

    if (mysqli_query($conn, $query)) {
        header("location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/home.php");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
} else {
    echo "Product not found!";
}
exit();
?>