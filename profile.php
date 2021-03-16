<?php // User profile
// Set page title
// include 'config.php';
// $cfg_title = (isset($_SESSION["username"]) ? $_SESSION["username"]."'s " : "")."Profile - MemoryMaze";
// Load standard header from file
include 'header.php'; ?>

<!-- Content goes here -->
<h1><?php echo (isset($_SESSION["username"]) ? $_SESSION["username"]."'s " : "")."Profile"; ?></h1>
<img src="./assets/citrus.png" class="profile-img" /><br/>
<span class="profile-high-score">High Score: 86</span>

<?php // Load footer
include 'footer.php'; ?>