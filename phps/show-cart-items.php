<?php
require 'connect.php';

$sql = 'SELECT * from cart WHERE userid="' . $_SESSION['userid'] . '"';
$total = 0;

if ($res = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($res) > 0) {

        // Get all products from Node.js API once
        $apiProducts = apiGet('/products');

        echo '<section class="ftco-section-md0 ftco-cart">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <table class="table bg-light">
                            <thead class="thead-primary">
                                <tr class="text-center">
                                    <th>&nbsp</th>
                                    <th colspan="2">Product</th>
                                    <th>Pet</th>
                                    <th>Quantity</th>
                                    <th class="price">Price</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>';

        while ($row = mysqli_fetch_array($res)) {
            $product_id = $row['prodid'];
            $product_qty = $row['qty'];

            // Find product from Node.js API by id
            $product_name = 'Unknown';
            $product_company = 'Pet Shop';
            $product_mrp = 0;
            $pet_type = '';

            if ($apiProducts) {
                foreach ($apiProducts as $p) {
                    if ($p['id'] == $product_id) {
                        $product_name = $p['name'];
                        $product_company = $p['company'];
                        $product_mrp = $p['price'];
                        $pet_type = $p['pet_type'];
                        break;
                    }
                }
            }

            $subtotal = $product_qty * $product_mrp;
            $total += $subtotal;

            echo '<tbody>
                <tr class="text-center ftco-animate">
                    <td class="image-prod"><div class="img"></div></td>
                    <td class="product-name">
                        <h3>' . $product_name . '</h3>
                        <p>Company: ' . $product_company . '</p>
                    </td>
                    <td class="price"><p>' . $pet_type . '</p></td>
                    <td class="price">₱' . $product_mrp . '</td>
                    <td class="price">' . $product_qty . '</td>
                    <td class="product-remove">
                        <a href="phps/remove-from-cart.php?prodid=' . $product_id . '">
                            <span class="ion-ios-close"></span>
                        </a>
                    </td>
                </tr>
            </tbody>';
        }

        $_SESSION["total_amt"] = $total;

        echo '</table>
                    </div>
                </div>
            </div>
        </div>
        </section>

        <section class="ftco-section ftco-cart">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col col-lg-5 col-md-6 mt-5 cart-wrap ftco-animate bg-light">
                    <div class="cart-total mb-3">
                        <h3>Cart Totals</h3>
                        <p class="d-flex">
                            <span>Subtotal</span>
                            <span>₱' . $total . '</span>
                        </p>
                        <p class="d-flex">
                            <span>Delivery</span>
                            <span>₱0.00</span>
                        </p>
                        <hr>
                        <p class="d-flex total-price">
                            <span>Total</span>
                            <span>₱' . $total . '</span>
                        </p>
                    </div>
                    <form action="checkout">
                        <p class="text-center">
                            <input type="submit" class="btn btn-primary py-3 px-4" 
                                   value="Proceed to checkout">
                        </p>
                    </form>
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
                                    <th colspan="5">The cart is empty</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </section>';
    }
} else {
    echo '<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th colspan="5">There is a problem with the connection!</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </section>';
}

mysqli_close($conn);
?>