<ul class="navbar">
    <a href="./"><li id="nav-home"><i class="fa fa-home" aria-hidden="true"></i> Home</li></a>
    <?php if(!isset($logged_in) || $logged_in==false) { 
        // Load navbar for non-logged in users ?>
        <a href="./register"><li id="nav-register"><i class="fas fa-user-plus" aria-hidden="true"></i> Register</li></a>
        <a href="./login"><li id="nav-login"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> Login</li></a>
    <?php } else { 
    // Load navbar for logged in users ?>
        <li id="nav-user">Welcome, {user}!</li>
        <a href="./profile"><li id="nav-profile"><i class="fas fa-user" aria-hidden="true"></i> Profile</li></a>
        <a href="./my-scores"><li id="nav-scores"><i class="fas fa-award" aria-hidden="true"></i> My Scores</li></a>   
    <?php } ?>
    <a href="./leaderboard"><li id="nav-leaderboard"><i class="fas fa-trophy" aria-hidden="true"></i> Leaderboard</li></a>
</ul>

<div class="mobile_navbar">
    <div id="mobile-menu" onclick="openMobileMenu()"><i class="fas fa-bars fa-2x"></i></div>
    <a href="./"><h1>MemoryMaze</h1></a>
    <a href="./login"><div id="mobile-quicklogin"><i class="fas fa-sign-in-alt fa-2x"></i></div></a>
</div>
