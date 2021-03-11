<ul class="navbar">
    <li id="nav-home"><a href="./"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
    <?php if(!isset($logged_in) || $logged_in==false) { 
        // Load navbar for non-logged in users ?>
        <li id="nav-register"><a href="./register"><i class="fas fa-user-plus" aria-hidden="true"></i> Register</a></li>
        <li id="nav-login"><a href="./login"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> Login</a></li>
    <?php } else { 
    // Load navbar for logged in users ?>
        <li id="nav-user">Welcome, {user}!</li>
        <li id="nav-profile"><a href="./profile"><i class="fas fa-user" aria-hidden="true"></i> Profile</a></li>
        <li id="nav-scores"><a href="./my-scores"><i class="fas fa-award" aria-hidden="true"></i> My Scores<a/></li>   
    <?php } ?>
    <li id="nav-leaderboard"><a href="./leaderboard"><i class="fas fa-trophy" aria-hidden="true"></i> Leaderboard</a></li>
</ul>

<div class="mobile_navbar">
    <div id="mobile-menu"><i class="fas fa-bars"></i></div>
    <h1>MemoryMaze</h1>
    <div id="mobile-quicklogin"><i class="fas fa-sign-in-alt"></i></div>
</div>
