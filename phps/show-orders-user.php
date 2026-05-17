<?php
if (!isset($_SESSION))
    session_start();
if ($_SESSION["user"] == NULL) {
    header("location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/index.html");
    exit();
}

require 'connect.php';
$userid = $_SESSION['userid'];

// Get orders from Node.js API
$allOrders = apiGet('/orders');
$orders = [];

if ($allOrders) {
    foreach ($allOrders as $order) {
        if ($order['customer_id'] == $userid) {
            $orders[] = $order;
        }
    }
}

if (count($orders) > 0) {
    echo '<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>';

    foreach ($orders as $row) {
        echo '<tbody>
            <tr class="text-center">
                <td class="price"><p>' . $row['id'] . '</p></td>
                <td class="product-name">
                    ' . $row['product_name'] . '<br/>
                    Company: Pet Shop
                </td>
                <td class="price"><p>' . $row['qty'] . '</p></td>
                <td class="price"><p>₱' . $row['total'] . '</p></td>
                <td class="price">
                    <p>' . $row['status'] . '</p>';

        if ($row['status'] == 'shipped') {
            echo '<form action="phps/order-received.php" method="GET">
                <input type="hidden" name="orderid" value="' . $row['id'] . '">
                <input type="hidden" name="userid" value="' . $userid . '">
                <button type="submit" class="btn btn-success py-2 px-3">
                    Order Received ✅
                </button>
            </form>';
        }

        echo '  </td>
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
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th>No orders found</th>
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