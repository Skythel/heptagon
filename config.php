<?php
// DB login info
include 'secrets.php';

// Start the session if not exists
if(!isset($_SESSION)) {
    session_start();
}

// Initialise logged in variable
if(!isset($logged_in)) {
    $logged_in = false;
}

// Create connection
$conn = new mysqli($db_serv, $db_user, $db_pass, $db_name);

// Versioning for easier reference
$app_ver = "0.0.0"; // General application version
$assets_ver = "0.0.0"; // Stylesheets version
$scripts_ver = "0.0.0"; // Scripts version
?>