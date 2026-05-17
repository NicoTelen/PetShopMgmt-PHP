<?php
require 'connect.php';

// Get products from Node.js API
$products = apiGet('/products');

if ($products && count($products) > 0) {
    echo '<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th colspan="2">Product</th>
                                <th>Pet Type</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th class="price">
                                    <a href="#" class="btn btn-primary py-1 px-4" 
                                        data-toggle="modal" data-target="#addNewInventory">
                                        Add new item
                                    </a>
                                </th>
                            </tr>
                        </thead>';

    foreach ($products as $row) {
        echo '<tbody>
            <tr class="text-center ftco-animate">
                <td class="product-remove">
                    <a href="phps/deleteProduct.php?prodid=' . $row['id'] . '">
                        <span class="ion-ios-close"></span>
                    </a>
                </td>
                <td class="product-name">
                    <h3>' . $row['name'] . '</h3>
                    <p>Company: ' . $row['company'] . '</p>
                </td>
                <td class="price">' . $row['pet_type'] . '</td>
                <td class="price">' . $row['category'] . '</td>
                <td class="price">₱' . $row['price'] . '</td>
                <td class="price">' . $row['qty'] . '</td>
                <td class="price">
                    <a href="#" onclick="update_form_variables(' .
            $row['id'] . ',\'' . $row['name'] . '\',\'' .
            $row['pet_type'] . '\',\'' . $row['company'] . '\',\'' .
            $row['price'] . '\',\'' . $row['qty'] . '\')" 
                        class="btn btn-primary py-3 px-4" 
                        data-toggle="modal" data-target="#updateInventory">
                        &nbsp Update &nbsp
                    </a>
                </td>
            </tr>
        </tbody>';
    }

    echo '</table>
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
                                <th colspan="5">No products found</th>
                                <th>
                                    <a href="#" class="btn btn-primary py-1 px-4" 
                                        data-toggle="modal" data-target="#addNewInventory">
                                        Add new item
                                    </a>
                                </th>
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