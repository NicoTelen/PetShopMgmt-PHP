<?php
if (!isset($_SESSION))
    session_start();
if ($_SESSION["admin"] == NULL) {
    header("location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-sign-in.html");
    exit();
}

require 'connect.php';

// Get pending orders from Node.js API
$pendingOrders = apiGet('/orders/pending');

if ($pendingOrders && count($pendingOrders) > 0) {
    echo '<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <h3 class="text-center">New Orders</h3>
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>';

    foreach ($pendingOrders as $order) {
        echo '<tbody>
            <tr class="text-center">
                <td class="price"><p>' . $order['id'] . '</p></td>
                <td class="price"><p>' . $order['customer_id'] . '</p></td>
                <td class="product-name">
                    ' . $order['product_name'] . '<br/>
                    Company: Pet Shop
                </td>
                <td class="price"><h3>' . $order['qty'] . '</h3></td>
                <td class="price"><p>₱' . $order['total'] . '</p></td>
                <td class="product-remove">
                    <form action="phps/orderShipped.php" method="GET">
                        <input type="hidden" name="order_id" value="' . $order['id'] . '">
                        <input type="hidden" name="prod_id" value="' . $order['product_id'] . '">
                        <input type="hidden" name="qty" value="' . $order['qty'] . '">
                        <input type="submit" class="btn btn-primary py-2 px-4" value="mark as shipped">
                    </form>
                </td>
            </tr>
        </tbody>';
    }

    echo '</table>
                </div>
            </div>
        </div>
    </div>
    </section>';

} else {
    echo '<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <h3 class="text-center">New Orders</h3>
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th>No new orders found</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </section>';
}

// Get shipped orders from Node.js API
$allOrders = apiGet('/orders');
$shippedOrders = [];
$invoice_amount = 0;

if ($allOrders) {
    foreach ($allOrders as $order) {
        if ($order['status'] == 'shipped') {
            $shippedOrders[] = $order;
            $invoice_amount += $order['total'];
        }
    }
}

if (count($shippedOrders) > 0) {
    echo '<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <h3 class="text-center">Shipped Orders</h3>
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>';

    foreach ($shippedOrders as $order) {
        echo '<tbody>
            <tr class="text-center">
                <td class="price"><p>' . $order['id'] . '</p></td>
                <td class="price"><p>' . $order['customer_id'] . '</p></td>
                <td class="product-name">
                    ' . $order['product_name'] . '<br/>
                    Company: Pet Shop
                </td>
                <td class="price"><h3>' . $order['qty'] . '</h3></td>
                <td class="price"><p>₱' . $order['total'] . '</p></td>
                <td class="price"><p>Shipped</p></td>
            </tr>
        </tbody>';
    }

    echo '</table>
            </div>
        </div>
    </div>

    <div class="row justify-content-end">
        <div class="col col-lg-5 col-md-6 mt-5 cart-wrap ftco-animate">
            <div class="cart-total mb-3">
                <h3>Sales</h3>
                <hr>
                <p class="d-flex">
                    <span>Total Shipped Orders</span>
                    <span>' . count($shippedOrders) . '</span>
                </p>
                <p class="d-flex total-price">
                    <span>Total Earning</span>
                    <span>₱' . $invoice_amount . '</span>
                </p>
            </div>
        </div>
    </div>
    </div>
    </section>';

} else {
    echo '<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <h3 class="text-center">Shipped Orders</h3>
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th>No shipped orders found</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </section>';
}
?>