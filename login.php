<?php // Login page
// Set page title
$cfg_title = "Login - MemoryMaze"; 
// Load standard header from file
include 'header.php'; ?>

<!-- Content goes here -->
<div class="wrapper">
    <h1>Login to MemoryMaze</h1>
    
    <form id="form">
        <label for="input-user">Email: </label><input type="email" class="input" id="input-user" /><br/>
        <label for="input-pass">Password: </label><input type="password" class="input" id="input-pass" /><br/>
        <button onclick="login()">Login</button>
    </form>
    <a href="./forgot_password">Forgot your password?</a><br/><br/>

    <a href="./register">Don't have an account? Register now!</a>
</div>

<script>
function login() {
    // Validate none of the fields are blank
    var form = document.getElementById("form");
    for(var i=0; i<form.getElementsByClassName("input").length; i++) {
        if(form.getElementsByClassName("input")[i].value == "") {
            throwError("Please fill in all fields.");
            return;
        }
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText==2) { // Backend error
                throwError("Sorry, the server experienced an error. Please try again later.");
                return;
            } else if(this.responseText==1) { // Wrong username or password
                throwError("Sorry, that wasn't right. Please check your information and try again.");
                return;
            }
            else {
                window.location.replace("./?login");
            }
        }
    }
    var u = form.getElementsByClassName("input")[0].value;
    var p = form.getElementsByClassName("input")[1].value;
    xmlhttp.open("POST", "login_send.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("u="+u+"&p="+p);
}
</script>

<?php // Load footer
include 'footer.php'; ?>