<?php
session_start();
if ($_SESSION["admin"] == NULL) {
  header("location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-sign-in.html");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>PetShop - Inventory</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet">
  <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/ionicons.min.css">
  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="css/jquery.timepicker.css">
  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/icomoon.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light ftco-navbar-light-2"
    id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="#">Petshop</a>
      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="phps/logout.php">LOGOUT</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
    <div class="col-md-15">
      <div class="row no-gutters slider-text align-items-center justify-content-center"
        style="background-color: white;margin-bottom: 30px; opacity: 0.9;">
        <div class="col-md-9 ftco-animate text-center">
          <h1 class="mb-0 bread">Inventory</h1>
          <p class="breadcrumbs">
            <span class="mr-1" style="color: brown;">Inventory</span> |
            <span><a href="admin-orders.php">Orders</a></span>
          </p>
        </div>
      </div>
    </div>
  </div>

  <?php include 'phps/show-inventory.php'; ?>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
        stroke="#F96D00" />
    </svg></div>

  <!-- ADD NEW INVENTORY MODAL -->
  <div class="modal fade" id="addNewInventory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add new product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="phps/addNewInventory.php" method="POST">
            <div class="form-group">
              <label class="col-form-label">Product Name</label>
              <input type="text" class="form-control border" name="prod_name" id="prod_name" required="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Pet Type</label>
              <select class="form-control border" name="pet_name" id="pet_name" required="">
                <?php $operation = "add";
                include "phps/pet_list.php"; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="col-form-label">Category</label>
              <select class="form-control border" name="category" id="category" required="">
                <option value="Foods">Foods</option>
                <option value="Toys">Toys</option>
                <option value="Health and Care">Health and Care</option>
                <option value="Collars">Collars</option>
                <option value="Training and Aids">Training and Aids</option>
                <option value="General">General</option>
              </select>
            </div>
            <div class="form-group">
              <label class="col-form-label">Company</label>
              <input type="text" class="form-control border" name="company_name" id="company_name" required="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Price</label>
              <input type="text" class="form-control border" name="price" id="price" required="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Quantity</label>
              <input type="text" class="form-control border" name="quantity" id="quantity" required="">
            </div>
            <div class="right-w3l">
              <input type="submit" class="btn btn-primary py-2 px-4" value="save">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- UPDATE INVENTORY MODAL -->
  <div class="modal fade" id="updateInventory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="phps/updateInventory.php" method="POST">
            <div class="form-group" style="display: none;">
              <input type="text" class="form-control border" name="update_prod_id" id="update_prod_id" required="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Product Name</label>
              <input type="text" class="form-control border" name="update_prod_name" id="update_prod_name" required="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Pet Type</label>
              <select class="form-control border" name="update_pet_name" id="update_pet_name" required="">
                <?php $operation = "update";
                include "phps/pet_list.php"; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="col-form-label">Category</label>
              <select class="form-control border" name="update_category" id="update_category" required="">
                <option value="Foods">Foods</option>
                <option value="Toys">Toys</option>
                <option value="Health and Care">Health and Care</option>
                <option value="Collars">Collars</option>
                <option value="Training and Aids">Training and Aids</option>
                <option value="General">General</option>
              </select>
            </div>
            <div class="form-group">
              <label class="col-form-label">Company</label>
              <input type="text" class="form-control border" name="update_company_name" id="update_company_name"
                required="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Price</label>
              <input type="text" class="form-control border" name="update_price" id="update_price" required="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Quantity</label>
              <input type="text" class="form-control border" name="update_quantity" id="update_quantity" required="">
            </div>
            <div class="right-w3l">
              <input type="submit" class="btn btn-primary py-2 px-4" value="update">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- DELETE MODAL -->
  <div class="modal fade" id="deleteInventoryModal" tabindex="-1" role="dialog" aria-hidden="">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Warning</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="phps/deleteProduct.php" method="GET">
            <h3>Are you sure you want to delete this product?</h3>
            <div class="form-group" style="display: none;">
              <input type="text" class="form-control border" name="prodid" id="delete_prod_id" required="">
            </div>
            <div class="right-w3l">
              <input type="submit" class="btn btn-primary py-2 px-4" value="delete">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include "phps/show-message.php" ?>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="js/main.js"></script>

  <script>
    $(window).load(function () {
      $('#messageModal').modal('show');
    });

    function update_form_variables(prod_id, prod_name, pet_name, company_name, price, quantity) {
      document.getElementById("update_prod_id").value = prod_id;
      document.getElementById("update_prod_name").value = prod_name;
      document.getElementById("update_company_name").value = company_name;
      document.getElementById("update_price").value = price;
      document.getElementById("update_quantity").value = quantity;
      var petOption = document.getElementById(pet_name);
      if (petOption) petOption.setAttribute("selected", true);
    }

    function delete_form_variables(prod_id) {
      document.getElementById("delete_prod_id").value = prod_id;
    }
  </script>

</body>

</html>