<?php
session_start();
require 'connect.php';

$orderid = $_GET['orderid'] ?? 0;

// Update order status to received via Node.js API
$result = apiPut('/orders/' . $orderid . '/status', [
    'status' => 'received'
]);

header("Location: ../myorders.php?status=received");
exit();
?>