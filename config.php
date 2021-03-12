<?php
// DB login info
file_exists('secrets.php') AND include 'secrets.php';

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
if ($conn -> connect_errno) {
    echo $conn->connect_error;
    exit();
}

// Versioning for easier reference
$app_ver = "1.1.0"; // General application version
$assets_ver = "1.1.0"; // Stylesheets version
$scripts_ver = "1.1.0"; // Scripts version
?>