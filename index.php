<?php // Set page title
$cfg_title = "Home"; 
// Load standard header from file
include 'header.php'; 
?>
<body>
    <!-- Load standard dashboard module from file -->
    <?php include 'navbar.php'; ?>
    <!-- The wrapper div for all body content. -->
    <div class="wrapper"> 
        <?php // Load game file
        include 'game.php'; ?>
    </div> <!-- End wrapper -->
</body>
<?php // Load footer
include 'footer.php'; 
?>
