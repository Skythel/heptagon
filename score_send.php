<?php include 'config.php';
$gameObj = json_decode($_POST['convertedGame'],true);
// File for processing scores.
if(isset($logged_in) && $logged_in) {
    // Save the score under the user's name
    
}
else {
    // Save it as anon score, allow user to log in

}
?>