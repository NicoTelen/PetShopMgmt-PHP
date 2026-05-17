<?php

session_start();

$_SESSION['pet_id_filter'] = $_GET['animal_id_for_filter'];

header("location: /PetShopMgmt-NodeJS/PetShopMgmt-NodeJS/admin-inventory");

?>