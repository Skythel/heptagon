<?php // User profile
// Set page title
include 'config.php';
$cfg_title = "Profile - MemoryMaze";

if(!isset($_GET["u"]) || isset($_SESSION["userid"])) {
    // Load standard header from file
    include 'header.php';
    echo "<div class=\"error message\">You must be logged in to view this page. <a href=\"./login\">Login</a></div>";
}
else {
    if(isset($_GET["u"])) {
        $uid = $_GET["u"];
    }
    elseif(isset($_SESSION["userid"])) {
        $uid = $_SESSION["userid"];
    }
    if(isset($uid)) {
        // Load standard header from file
        include 'header.php';
        $sql = $conn->prepare("SELECT * FROM `users` WHERE `userid`=?");
        if(
            $sql &&
            $sql->bind_param("i",$uid) && 
            $sql->execute() &&
            $sql->store_result()
        ) {
            if($sql->num_rows<1) {
                echo "<div class=\"error message\">Sorry, this user does not exist.</div>";
            }
            else {
                $cfg_title = (isset($uid) ? $uid."'s " : "")."Profile - MemoryMaze"; ?>
            
                <!-- Content goes here -->
                <h1><?php echo (isset($_SESSION["username"]) ? $_SESSION["username"]."'s " : "")."Profile"; ?></h1>

                <div class="profile-main">
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
                </div>
                <?php
            }
        }
    } 
    else {
        echo "<div class=\"error message\">Sorry, this page cannot be displayed.</div>";
    }
}

// Load footer
include 'footer.php'; ?>