<ul class="navbar">
    <?php if(!isset($_SESSION["userid"])) { 
        // Load navbar for non-logged in users ?>
        <a href="./"><li id="nav-home"><i class="fa fa-home" aria-hidden="true"></i> Home</li></a>
        <a href="./register"><li id="nav-register"><i class="fas fa-user-plus" aria-hidden="true"></i> Register</li></a>
        <a href="./login"><li id="nav-login"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> Login</li></a>
        <a href="./leaderboard"><li id="nav-leaderboard"><i class="fas fa-trophy" aria-hidden="true"></i> Leaderboard</li></a>
    <?php } else { 
    // Load navbar for logged in users ?>
        <li class="nav-static" id="nav-user">Welcome<?php if(isset($_SESSION["username"])) { echo ", ".$_SESSION["username"]; } ?>!</li>
        <a href="./"><li id="nav-home"><i class="fa fa-home" aria-hidden="true"></i> Home</li></a>
        <a href="./profile"><li id="nav-profile"><i class="fas fa-user" aria-hidden="true"></i> Profile</li></a>
        <a href="./friends"><li id="nav-friends"><i class="fas fa-user-friends" aria-hidden="true"></i> Friends</li></a>
        <a href="./my-scores"><li id="nav-scores"><i class="fas fa-award" aria-hidden="true"></i> My Scores</li></a>
        <a href="./leaderboard"><li id="nav-leaderboard"><i class="fas fa-trophy" aria-hidden="true"></i> Leaderboard</li></a>
        <a href="./settings"><li id="nav-settings"><i class="fas fa-cog" aria-hidden="true"></i> Settings</li></a>
        <a href="./logout"><li id="nav-logout"><i class="fas fa-sign-out-alt" aria-hidden="true"></i> Logout</li></a>
    <?php } ?>
</ul>

<div class="mobile_navbar">
    <div id="mobile-menu" onclick="openMobileMenu()"><i class="fas fa-bars fa-2x"></i></div>
    <a href="./"><h1>MemoryMaze</h1></a>
    <a href="./login"><div id="mobile-quicklogin"><i class="fas fa-sign-in-alt fa-2x"></i></div></a>
</div>
