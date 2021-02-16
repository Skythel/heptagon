<?php if(!$logged_in) { 
    // Load navbar for non-logged in users ?>
    <ul classs="navbar">
        <li id="nav-register">Register</li>
        <li id="nav-login">Login</li>
    </ul>
<?php } else { 
    // Load navbar for logged in users ?>
    <ul class="navbar">
        <li id="nav-user">Welcome, {user}!</li>
        <li id="#">Placeholder</li>
    </ul>
<?php } ?>