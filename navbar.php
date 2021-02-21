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
        <li id="#">Placeholder</li>
    </ul>
<?php } ?>