<?php // Registration page
// Set page title
$cfg_title = "Register - MemoryMaze"; 
// Load standard header from file
include 'header.php'; ?>

<!-- Content goes here -->
<h1>Register for MemoryMaze</h1>

<div id="form">
    <label for="input-user">Username: </label><input type="text" class="input" id="input-user" /><br/>
    <label for="input-email">Email: </label><input type="email" class="input" id="input-email" /><br/>
    <label for="input-pass">Password: </label><input type="password" class="input" id="input-pass" /><br/>
    <button onclick="register()">Register</button>
</div>

<a href="./login">Already have an account? Login!</a>

<script>
function register() {
    // Validate none of the fields are blank
    var form = document.getElementById("form");
    for(var i=0; i<form.getElementsByClassName("input").length; i++) {
        if(form.getElementsByClassName("input")[i].value == "") {
            throwError("Please fill in all fields.");
            return;
        }
    }
    // Validate password >= 8 chars
    if(document.getElementById("input-pass").value.length < 8) {
        throwError("Your password must be at least 8 characters long.");
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if(this.responseText==2) { // Backend error
                throwError("Sorry, the server experienced an error. Please try again later.");
                return;
            } else if(this.responseText==1) { // Email already exists
                throwError("Sorry, that email address is already registered. Please use a different email and try again.");
                return;
            }
            else {
                var xmlhttp2 = new XMLHttpRequest();
                xmlhttp2.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(this.responseText=="2") { // Backend error
                            throwError("Sorry, the server experienced an error. Please try again later.");
                            return;
                        } else if(this.responseText=="1") {
                            return;
                        }
                        else {
                            successMessage("Successfully registered! You can now <a href=\"./login\">log in</a>. <!--Please check your email to complete the verification process.-->");
                        }
                    }
                }
                var u = form.getElementsByClassName("input")[0].value;
                var p = form.getElementsByClassName("input")[2].value;
                xmlhttp2.open("POST", "login_send.php", true);
                xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp2.send("u="+u+"&p="+p);
            }
        }
    }
    var u = form.getElementsByClassName("input")[0].value;
    var e = form.getElementsByClassName("input")[1].value;
    var p = form.getElementsByClassName("input")[2].value;
    xmlhttp.open("POST", "register_send.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("u="+u+"&e="+e+"&p="+p);
}
</script>

<?php // Load footer
include 'footer.php'; ?>