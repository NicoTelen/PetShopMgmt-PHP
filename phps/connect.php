<?php
// Database connection (for sessions only)
$conn = new mysqli('localhost', 'root', '', 'petshop_api_db');
if ($conn->connect_error) {
    die("Connection failed!" . $conn->connect_error);
}

// Include API helper
require_once 'api_helper.php';
?>