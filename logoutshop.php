<?php
// Start the session
session_start();

// Clear the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Optionally, redirect the user to the login page or homepage
header("Location: loginshopowner.php");
exit(); // Ensure no further code is executed
?>
