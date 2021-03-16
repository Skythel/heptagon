<?php // Personal scores
// Set page title
include 'config.php';
$cfg_title = (isset($_SESSION["username"]) ? $_SESSION["username"]."'s " : "")."Scores - MemoryMaze";
// Load standard header from file
include 'header.php'; ?>

<?php include 'placeholder_myscores.html'; ?>
<!-- Content goes here -->
<div class="wrapper">
   
</div>

<?php // Load footer
include 'footer.php'; ?>