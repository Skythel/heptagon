<?php // Login page
// Set page title
$cfg_title = "Login - MemoryMaze"; 
// Load standard header from file
include 'header.php'; ?>

<!-- Content goes here -->
<h1>Login to MemoryMaze</h1>

<div id="form">
    <label for="input-user">Email: </label><input type="email" class="input" id="input-user" /><br/>
    <label for="input-pass">Password: </label><input type="password" class="input" id="input-pass" /><br/>
    <button onclick="login()">Login</button>
</div>
<a href="./forgot_password">Forgot your password?</a><br/><br/>

<a href="./register">Don't have an account? Register now!</a>

<?php // Load footer
include 'footer.php'; ?>