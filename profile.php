<?php // User profile
// Set page title
include 'config.php';
$cfg_title = (isset($_SESSION["username"]) ? $_SESSION["username"]."'s " : "")."Profile - MemoryMaze";
// Load standard header from file
include 'header.php'; ?>

<!-- Content goes here -->
<!-- <h1><?php echo (isset($_SESSION["username"]) ? $_SESSION["username"]."'s " : "")."Profile"; ?></h1> -->
<?php include 'sidebar.php'; ?>


<!--main container start-->
<div class="container-2">
    <div class="card">
        <h1>Username:</h1>
        <p>Username</p><br>

        <h2>Email:</h2>
        <p>Username@gmail.com</p><br>

        <h2>Highest Score:</h2>
        <p>73</p><br>

        
    </div>
</div>
<!--main container end-->

<?php // Load footer
include 'footer.php'; ?>