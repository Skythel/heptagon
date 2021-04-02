<?php // Personal scores
include 'config.php';
$cfg_title = "Settings - MemoryMaze"; 
include 'header.php';
?>
<h1>Profile Settings</h1>
<?php
if(!isset($_SESSION["userid"])) {
    echo "<div class=\"error message\">You must be logged in to view this page.</div>";
}
else { 
    $sql = $conn->prepare("SELECT `email`,`age`,`bio`,`history`,`fav_food`,`preferred_diff` FROM `users` WHERE `userid`=?");
    if(
        $sql &&
        $sql->bind_param("i",$_SESSION["userid"]) &&
        $sql->execute() &&
        $sql->store_result() &&
        $sql->bind_result($email,$age,$bio,$history,$favfood,$prefdiff)
    ) {
        $sql->fetch();
        ?>
        <table class="profile-settings" id="form">
            <tr>
                <td>Username</td>
                <td><input class="input required" type="text" value="<?php echo $_SESSION["username"]; ?>" id="settings-username" /></td>
            </tr>
            <tr>
                <td>Password<br/>(leave blank if not changing password)</td>
                <td><input class="input pass" type="password" placeholder="********" id="settings-password" /></td>
            </tr>
            <tr>
                <td>Confirm Password<br/>(leave blank if not changing password)</td>
                <td><input class="input pass" type="password" id="settings-password" /></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input class="input required" type="email" value="<?php echo $email; ?>" id="settings-email" /></td>
            </tr>
            <tr>
                <td>Age</td>
                <td><input class="input" type="number" value="<?php echo $age; ?>" id="settings-age" /></td>
            </tr>
            <tr>
                <td>Dementia History</td>
                <td><input class="input" type="text" value="<?php echo $history; ?>" id="settings-history" /></td>
            </tr>
            <tr>
                <td>Favourite Food</td>
                <td><input class="input" type="text" value="<?php echo $favfood; ?>" id="settings-favfood" /></td>
            </tr>
            <tr>
                <td>Biography</td>
                <td><textarea class="input-box" cols="60" rows="10"><?php echo $bio; ?></textarea></td>
            </tr>
            <tr>
                <td>Preferred Difficulty</td>
                <td><select id="prefdiff" class="input">
                    <option value="0">Ask me every time</option>
                    <option value="easy" <?php if($prefdiff=="easy") { ?>selected="selected"<?php } ?>>Easy</option>
                    <option value="medium" <?php if($prefdiff=="medium") { ?>selected="selected"<?php } ?>>Medium</option>
                    <option value="hard" <?php if($prefdiff=="hard") { ?>selected="selected"<?php } ?>>Hard</option>
                </select></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button onclick="saveProfile()">Save Profile</button>
                </td> 
            </tr>
        </table>
        <?php
        $sql->close();
    }
    else {
        echo $conn->error;
    }
} ?>
<!--main container start-->
<!-- <div class="container-2">
    <div class="card">
        <h1>Change Password:</h1>
        <h1>Change Email:</h1>
        <h1>Change Profile Picture:</h1>
    </div>
</div> -->
<!--main container end-->
<script>
function saveProfile() {
    // Validate username, email are not blank 
    var form = document.getElementById("form");
    for(var i=0; i<form.getElementsByClassName("required").length; i++) {
        if(form.getElementsByClassName("required")[i].value == "") {
            throwError("Please fill in all required fields.");
            return;
        }
    }
    // Validate password fields are either both filled or both not filled (NOT_XOR)
    if(
        (form.getElementsByClassName("pass")[0].value == "" && 
        form.getElementsByClassName("pass")[1].value !== "") || 
        (form.getElementsByClassName("pass")[0].value !== "" && 
        form.getElementsByClassName("pass")[1].value == "")
    ) {
        throwError("Please fill in both password fields if you are changing your password. If not, you can leave them blank.");
        return;
    }
    else if(form.getElementsByClassName("pass")[0].value === form.getElementsByClassName("pass")[1].value) {
        // TODO: Validate password
    }
    else {
        throwError("Passswords do not match.");
        return;
    }
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if(this.responseText==2) { // Backend error
                throwError("Sorry, the server experienced an error. Please try again later.");
                return;
            }
            else if(this.responseText==1) {
                throwError("An error occurred. Please try again later.");
                return;
            }
            else {
                successMessage("Your profile settings have successfully been updated.");
            }
        }
    }
    var u = form.getElementsByClassName("input")[0].value;
    var p = form.getElementsByClassName("input")[1].value;
    var pconf = form.getElementsByClassName("input")[2].value;
    var e = form.getElementsByClassName("input")[3].value;
    var age = form.getElementsByClassName("input")[4].value;
    var hist = form.getElementsByClassName("input")[5].value;
    var fav = form.getElementsByClassName("input")[6].value;
    var pref = form.getElementsByClassName("input")[7].value;
    var bio = form.getElementsByTagName("textarea")[0].innerHTML;
    xmlhttp.open("POST", "settings_send.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("u="+u+"&e="+e+"&p="+p+"&pconf="+pconf+"&age="+age+"&hist="+hist+"&fav="+fav+"&bio="+bio+"&pref="+pref);
}
</script>

<?php // Load footer
include 'footer.php'; ?>