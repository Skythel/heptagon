<?php // Set page title
$cfg_title = "Home - MemoryMaze"; 
// Load standard header from file
include 'header.php'; 
?>
<h1 id="h1-remove">MemoryMaze</h1>
<?php
if(isset($_GET["login"])) {
    ?>
    <div class="success message">You have successfully logged in.</div>
    <?php
}
else if(isset($_GET["logout"])) {
    ?>
    <div class="success message">You have successfully logged out.</div>
    <?php
}
// Load game file
include 'game.php'; 
// Load footer
include 'footer.php'; 
?>
