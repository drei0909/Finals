<?php
require_once('./classes/database_admin.php'); // adjust path if needed

$con = new adminDatabase();

// SET YOUR CREDENTIALS
$firstname = 'Gian';
$lastname = 'Admin';
$username = 'admin';
$email = 'admin@example.com';
$password = 'Gian0909?';

$adminID = $con->signupAdmin($firstname, $lastname, $username, $email, $password);

if ($adminID) {
    echo "Admin created successfully. ID: " . $adminID;
} else {
    echo "Failed to create admin.";
}
?>
