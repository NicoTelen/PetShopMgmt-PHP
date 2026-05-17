<?php
session_start();
if ($_SESSION["admin"] == NULL) {
	header("location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-sign-in.html");
	exit();
}

require 'connect.php';

$order_id = $_GET['order_id'] ?? 0;
$prod_id = $_GET['prod_id'] ?? 0;
$qty = (int) ($_GET['qty'] ?? 0);

// Get product from Node.js API to check stock
$products = apiGet('/products');
$product = null;

if ($products) {
	foreach ($products as $p) {
		if ($p['id'] == $prod_id) {
			$product = $p;
			break;
		}
	}
}

if (!$product) {
	$_SESSION["message"] = "Product not found. Please insert product first.";
	header('Location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-orders.php');
	exit();
}

if ($product['qty'] < $qty) {
	$_SESSION["message"] = "Insufficient product quantity in inventory. Update quantity of product.";
	header('Location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-orders.php');
	exit();
}

// Deduct stock via Node.js API
$newQty = $product['qty'] - $qty;
$updateStock = apiPut('/products/' . $prod_id, [
	'name' => $product['name'],
	'category' => $product['category'],
	'pet_type' => $product['pet_type'],
	'qty' => $newQty,
	'price' => $product['price'],
	'company' => $product['company']
]);

if (!isset($updateStock['success']) || !$updateStock['success']) {
	$_SESSION["message"] = "Failed to update quantity!";
	header('Location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-orders.php');
	exit();
}

// Update order status to shipped via Node.js API
$updateStatus = apiPut('/orders/' . $order_id . '/status', [
	'status' => 'shipped'
]);

if (isset($updateStatus['success']) && $updateStatus['success']) {
	$_SESSION["message"] = "Order successfully marked as shipped!";
} else {
	$_SESSION["message"] = "Failed to update order status!";
}

header('Location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-orders.php');
exit();
?>