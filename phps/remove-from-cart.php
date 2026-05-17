<?php
session_start();
require 'connect.php';

$prodid = $_GET['prodid'] ?? 0;
$userid = $_SESSION['userid'];

$query = "DELETE FROM cart WHERE prodid='$prodid' AND userid='$userid'";
mysqli_query($conn, $query);

header("location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/cart.html");
exit();
?>