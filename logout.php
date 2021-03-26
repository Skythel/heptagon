<?php
// Logout validation file
// Inputs: user session
// Outputs: Redirect to home page with a success/error message.

include 'config.php';

if(isset($_SESSION["userid"]) || isset($_SESSION["username"]) || isset($_SESSION["usertag"])) {
    unset($_SESSION["userid"]);
    unset($_SESSION["username"]);
    unset($_SESSION["usertag"]);
    header("Location: ./?logout");
}
else {
    header("Location: ./");
}
?>