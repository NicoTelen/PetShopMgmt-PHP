<?php
require 'connect.php';

$fname = $_GET['fname'] ?? '';
$lname = $_GET['lname'] ?? '';
$emailid = $_GET['emailid'] ?? '';
$phone = $_GET['phone'] ?? 'N/A';
$password = $_GET['password'] ?? '';
$password1 = $_GET['password1'] ?? '';

if ($password != $password1) {
	header("Location: ../sign-up.html?status=nomatch");
	exit();
}

$result = apiPost('/customers', [
	'fname' => $fname,
	'lname' => $lname,
	'email' => $emailid,
	'phone' => $phone,
	'password' => $password
]);

if (isset($result['success']) && $result['success']) {
	header("Location: ../sign-up.html?status=success");
} else {
	header("Location: ../sign-up.html?status=error");
}
exit();
?>