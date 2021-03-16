<?php // Set page title
$cfg_title = "Home"; 
// Load standard header from file
include 'header.php'; 
?>
<h1>MemoryMaze</h1>
<?php
if(isset($_GET["login"])) {
    ?>
    <div class="success message">You have successfully logged in.</div>
    <?php
}
// Load game file
include 'game.php'; 
// Load footer
include 'footer.php'; 
?>
