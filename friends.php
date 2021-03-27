<?php // User profile
// Set page title
$cfg_title = "Friend List - MemoryMaze";
// Load standard header from file
include 'header.php'; ?>

<!-- Content goes here -->
<h1>Friend List</h1>

<?php if(!isset($_SESSION["userid"])) {
    ?>
    <div class="error message">You must be logged in to do that. <a href="./login">Login</a></div>
<?php } else { ?>
<div class="searchbox">
    Search for a friend: <br/>
    <input class="friend-searchbox" id="friendsearch" onkeyup="friendSearch(this.value)" placeholder="Enter a username" />
    
    <div id="friend-suggestions"></div>
</div>
<br/>

<h2>Your Friends</h2>
<?php 
$sql = $conn->prepare("SELECT `friend_requests`.`timestamp`,`users`.`userid`,`users`.`usertag`,`users`.`username`,`users`.`registration_timestamp`,`logins`.`timestamp`
LEFT JOIN `users` ON `friend_requests`.`recipient_userid` = `users`.`userid`
LEFT JOIN `logins` ON `users`.`userid` = `logins`.`userid`
WHERE `friend_requests`.`sender_userid`=? AND `friend_requests`.`status`=1
LIMIT 1");
if( 
    $sql &&
    $sql->bind_param('i',$_SESSION["userid"]) &&
    $sql->execute() &&
    $sql->store_result() &&
    $sql->bind_result($request_timestamp,$recipient_id,$recipient_tag,$recipient_name,$recipient_regdate,$recipient_lastlogin)
) {
    while($sql->fetch()) {
?>
<div class="mini-profile">
    <a href="./profile?u=<?php echo $recipient_id; ?>"><span class="mini-profile-name"><?php echo $recipient_name; ?></span>#<span class="mini-profile-tag"><?php echo $recipient_tag; ?></span></a><br/>
    <!-- <img src="./assets/avocado.png" class="mini-profile-img" /><br/> 
    <span class="mini-profile-high-score">High Score: 94</span><br/>-->
    <span class="mini-profile-registered">Registered <?php echo date_format($recipient_regdate,"j M Y"); ?></span>
    <span class="mini-profile-last-login">Last Active <?php echo date_format($recipient_lastlogin,"j M Y"); ?></span>
</div> &nbsp;
<?php } } ?>
<script>
function friendSearch(v) {
    if (v.length == 0) {
        document.getElementById("friend-suggestions").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("friend-suggestions").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "friend_search.php?q=" + v, true);
        xmlhttp.send();
    }   
}
function addFriend(id) {
    if(parseInt(id) < 1) return;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if(this.responseText == 0) {
                document.getElementById("addfriend-"+id).innerHTML = "Added";
                document.getElementById("addfriend-"+id).classList.add("greyed");
            }
            else {
                console.log(this.responseText);
            }
        }
    };
    xmlhttp.open("GET", "add_friend.php?q=" + id, true);
    xmlhttp.send();
}
</script>

<?php }
// Load footer
include 'footer.php'; ?>