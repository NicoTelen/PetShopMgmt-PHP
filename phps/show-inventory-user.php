<?php
require 'connect.php';

// Get products from Node.js API
$products = apiGet('/products');

$sql1 = 'SELECT * from cart WHERE userid="' . $_SESSION['userid'] . '"';
$res1 = mysqli_query($conn, $sql1);
$cart_items = $res1 ? mysqli_num_rows($res1) : 0;


echo '
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light bg-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.html">PetShop</a>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link"><span>Hello, ' . $_SESSION['user'] . '</span></a></li>
                    <li class="nav-item"><a href="myorders.php" class="nav-link"><span class="icon-shopping-bag"></span> Your Orders</a></li>
                    <li class="nav-item cta cta-colored"><a href="cart.html" class="nav-link"><span class="icon-shopping_cart"></span>[' . $cart_items . ']</a></li>
                    <li class="nav-item"><a href="phps/logout.php" class="nav-link">Log out <span class="icon-sign-out"></span></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="ftco-section-md0 ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table bg-light">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th colspan="2">Product</th>
                                <th>Pet Type</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th colspan="3">Quantity</th>
                                <th>&nbsp</th>
                            </tr>
                        </thead>';

foreach ($products as $row) {
    $stockColor = $row['qty'] <= 5 ? "red" : "green";
    $stockText = $row['qty'] == 0 ? "Out of Stock" : "Stock: " . $row['qty'];

    echo '<tbody>
            <tr class="text-center ftco-animate">
                <td class="image-prod"><div class="img"></div></td>
                <td class="product-name">
                    <h3>' . $row['name'] . '</h3>
                    <p>Company: ' . $row['company'] . '</p>
                </td>
                <td class="price"><h4>' . $row['pet_type'] . '</h4></td>
                <td class="price"><h4>₱' . $row['price'] . '</h4></td>
                <td class="price">
                    <h4 style="color:' . $stockColor . '">' . $stockText . '</h4>
                </td>
                <form action="phps/add_to_cart.php" class="input-group col-md-8 d-flex mb-3" method="GET">
                    <td class="price">
                        <span class="input-group-btn mr-2">
                            <button type="button" class="quantity-left-minus btn"
                                onclick="javascript:decrement_count(\'decrement_' . $row['id'] . '\',\'qty_' . $row['id'] . '\');">
                                <i class="ion-ios-remove"></i>
                            </button>
                        </span>
                    </td>
                    <td class="price">
                        <input type="text" name="qty" id="qty_' . $row['id'] . '" 
                            class="form-control input-number" value="1" min="1" max="' . $row['qty'] . '">
                    </td>
                    <td class="price">
                        <span class="input-group-btn ml-2">
                            <button type="button" class="quantity-right-plus btn"
                                onclick="javascript:increment_count(\'increment_' . $row['id'] . '\',\'qty_' . $row['id'] . '\');">
                                <i class="ion-ios-add"></i>
                            </button>
                        </span>
                    </td>
                    <td>
                        <input type="hidden" name="product" value="' . $row['name'] . '">
                        <span class="input-group-btn mr-2">';

    if ($row['qty'] == 0) {
        echo '<button class="btn btn-danger py-3 px-4" disabled>Out of Stock</button>';
    } else {
        echo '<input type="submit" class="btn btn-primary py-3 px-4" value="&nbsp Add to cart &nbsp">';
    }

    echo '      </span>
                    </td>
                </form>
            </tr>
        </tbody>';
}

echo '</table>
                </div>
            </div>
        </div>
    </div>
    </section>';
if ($products && count($products) > 0) {

} else {
    echo '<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th colspan="5">No products found</th>
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