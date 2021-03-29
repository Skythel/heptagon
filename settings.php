<?php // Personal scores
include 'config.php';
include 'header.php';
$cfg_title = "Settings - MemoryMaze"; 

if(isset($_SESSION["userid"])) {
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
        <table>
            <tr>
                <td>Username</td>
                <td><input type="text" value="<?php echo $_SESSION["username"]; ?>" id="settings-username" /></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" value="********" id="settings-password" /></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="email" value="<?php echo $email; ?>" id="settings-email" /></td>
            </tr>
            <tr>
                <td>Age</td>
                <td><input type="number" value="<?php echo $age; ?>" id="settings-age" /></td>
            </tr>
            <tr>
                <td>Dementia History</td>
                <td><input type="text" value="<?php echo $history; ?>" id="settings-history" /></td>
            </tr>
            <tr>
                <td>Favourite Food</td>
                <td><input type="text" value="<?php echo $favfood; ?>" id="settings-favfood" /></td>
            </tr>
            <tr>
                <td>Biography</td>
                <td><textarea cols="30" rows="10"><?php echo $bio; ?></textarea></td>
            </tr>
            <tr>
                <td>Preferred Difficulty</td>
                <td><select id="prefdiff">
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
    
}
</script>