<?php
session_start();
require 'connect.php';

$fname = $_GET['fname'] ?? '';
$lname = $_GET['lname'] ?? '';
$country = $_GET['country'] ?? '';
$street = $_GET['street'] ?? '';
$apt = $_GET['apt'] ?? '';
$city = $_GET['city'] ?? '';
$zipcode = $_GET['zipcode'] ?? '';
$phone = $_GET['phone'] ?? '';
$email = $_GET['email'] ?? '';
$optradio = $_GET['optradio'] ?? '';
$userid = $_SESSION['userid'];

// Group cart items by product to avoid duplicates
$cart_query = 'SELECT prodid, SUM(qty) as total_qty FROM cart WHERE userid="' . $userid . '" GROUP BY prodid';

if ($cart_res = mysqli_query($conn, $cart_query)) {
    while ($cart_row = mysqli_fetch_array($cart_res)) {
        $prodid = $cart_row['prodid'];
        $qty = $cart_row['total_qty'];

        // Get product details from Node.js API
        $products = apiGet('/products');
        $prod_name = '';
        $prod_company = 'Pet Shop';
        $mrp = 0;
        $total_amt = 0;

        if ($products) {
            foreach ($products as $product) {
                if ($product['id'] == $prodid) {
                    $prod_name = $product['name'];
                    $prod_company = $product['company'];
                    $mrp = $product['price'];
                    $total_amt = $mrp * $qty;
                    break;
                }
            }
        }

        // Create order via Node.js API — only once!
        $result = apiPost('/orders', [
            'customer_id' => $userid,
            'product_id' => $prodid,
            'product_name' => $prod_name,
            'qty' => $qty,
            'total' => $total_amt
        ]);

        if (isset($result['success']) && $result['success']) {
            // Save delivery address for this order
            apiPost('/addresses', [
                'order_id' => $result['id'],
                'fname' => $fname,
                'lname' => $lname,
                'country' => $country,
                'street' => $street,
                'apt' => $apt,
                'city' => $city,
                'zipcode' => $zipcode,
                'phone' => $phone,
                'email' => $email,
                'payment_method' => $optradio
            ]);

            // Delete from cart
            $cart_delete = 'DELETE FROM cart WHERE prodid=' . $prodid . ' AND userid=' . $userid;
            mysqli_query($conn, $cart_delete);
        }
    }

    $_SESSION["message"] = "Order Placed Successfully!";
    $_SESSION['message_desc'] = "You can continue shopping!";
    header("location:/PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/home.php");
} else {
    echo "Cart data retrieval failed!";
}
?>