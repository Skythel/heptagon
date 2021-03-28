<?php // Personal scores
// Set page title
include 'config.php';
$cfg_title = (isset($_SESSION["username"]) ? $_SESSION["username"]."'s " : "")."Scores - MemoryMaze";
// Load standard header from file
include 'header.php'; 
include 'sidebar.php'; ?>

<!-- Content goes here -->
<!--main container start-->
<div class="container-1">
    <div class="card">
        <p><br><?php include 'placeholder_myscores.html'; ?></p>
    </div>
</div>
<!--main container end-->

<?php // Load footer
include 'footer.php'; ?>