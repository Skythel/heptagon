<?php if(!isset($logged_in) || $logged_in==false) { 
    // Load navbar for non-logged in users ?>
    <ul class="navbar">
        <li id="nav-register"><i class="fas fa-user-plus" aria-hidden="true"></i> Register</li>
        <li id="nav-login"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> Login</li>
    </ul>
<?php } else { 
    // Load navbar for logged in users ?>
    <ul class="navbar">
        <li id="nav-user">Welcome, {user}!</li>
        <a href="profile"><li id="nav-profile"><i class="fas fa-user" aria-hidden="true"></i> Profile</li></a>
        <a href="my-scores"><li id="nav-scores"><i class="fas fa-award" aria-hidden="true"></i> My Scores</li><a/>
        <a href="leaderboard"><li id="nav-leaderboard"><i class="fas fa-trophy" aria-hidden="true"></i> Leaderboard</li></a>
    </ul>
<?php } ?>