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
$sql = $conn->prepare("SELECT DISTINCT `friend_requests`.`timestamp`,`users`.`userid`,`users`.`usertag`,`users`.`username`,`users`.`registration_timestamp`,IFNULL(MAX(`logins`.`timestamp`),0)
FROM `friend_requests`
LEFT JOIN `users` ON `friend_requests`.`recipient_userid` = `users`.`userid`
LEFT JOIN `logins` ON `users`.`userid` = `logins`.`userid`
WHERE (`friend_requests`.`sender_userid`=? OR `friend_requests`.`recipient_userid`=?) AND `friend_requests`.`status`=1 LIMIT 10");
if(
    $sql &&
    $sql->bind_param('ii',$_SESSION["userid"],$_SESSION["userid"]) &&
    $sql->execute() &&
    $sql->store_result() &&
    $sql->bind_result($request_timestamp,$recipient_id,$recipient_tag,$recipient_name,$recipient_regdate,$recipient_lastlogin)
) {
    if($sql->num_rows<1) {
        echo "Oops! It seems you don't have any friends yet. Why not add a user to your friend list?";
    }
    else {
        $none = true;
        while($sql->fetch()) {
            if($recipient_lastlogin>0) {
                $none = false;
?>
<div class="mini-profile">
    <a href="./profile?u=<?php echo $recipient_id; ?>"><span class="mini-profile-name"><?php echo $recipient_name; ?>#<span class="mini-profile-tag"><?php echo $recipient_tag; ?></span></span></a><br/>
    <!-- <img src="./assets/avocado.png" class="mini-profile-img" /><br/> 
    <span class="mini-profile-high-score">High Score: 94</span><br/>-->
    <span class="mini-profile-registered">Registered <?php echo date("j M Y",$recipient_regdate); ?></span><br/>
    <span class="mini-profile-last-login">Last Active <?php echo date("j M Y",$recipient_lastlogin); ?></span><br/>
    <span class="mini-profile-remove-friend" id="remove-friend-<?php echo $recipient_id; ?>" onclick="removeFriend(<?php echo $recipient_id; ?>)"><i class="fas fa-user-minus" aria-hidden="true"></i> Remove Friend</span>
</div> &nbsp;
<?php } } } $sql->close(); }
if(isset($none) && $none) {
    echo "Oops! It seems you don't have any friends yet. Why not add a user to your friend list?";
} ?>

<h2>Incoming Friend Requests</h2>
<?php 
$sql = $conn->prepare("SELECT DISTINCT `friend_requests`.`timestamp`,`users`.`userid`,`users`.`usertag`,`users`.`username`,`users`.`registration_timestamp`,IFNULL(MAX(`logins`.`timestamp`),0)
FROM `friend_requests`
LEFT JOIN `users` ON `friend_requests`.`sender_userid` = `users`.`userid`
LEFT JOIN `logins` ON `users`.`userid` = `logins`.`userid`
WHERE `friend_requests`.`recipient_userid`=? AND `friend_requests`.`status`=0 LIMIT 10");
if( 
    $sql &&
    $sql->bind_param('i',$_SESSION["userid"]) &&
    $sql->execute() &&
    $sql->store_result() &&
    $sql->bind_result($request_timestamp,$recipient_id,$recipient_tag,$recipient_name,$recipient_regdate,$recipient_lastlogin)
) {
    if($sql->num_rows<1) {
        echo "You currently have no incoming friend requests.";
    }
    else {
        $none = true;
        while($sql->fetch()) {
            if($recipient_lastlogin>0) {
                $none = false;
?>
<div class="mini-profile">
    <a href="./profile?u=<?php echo $recipient_id; ?>"><span class="mini-profile-name"><?php echo $recipient_name; ?>#<span class="mini-profile-tag"><?php echo $recipient_tag; ?></span></span></a><br/>
    <!-- <img src="./assets/avocado.png" class="mini-profile-img" /><br/> 
    <span class="mini-profile-high-score">High Score: 94</span><br/>-->
    <span class="mini-profile-registered">Registered <?php echo date("j M Y",$recipient_regdate); ?></span><br/>
    <span class="mini-profile-last-login">Last Active <?php echo date("j M Y",$recipient_lastlogin); ?></span><br/>
    <span class="mini-profile-accept-friend" onclick="acceptFriend(<?php echo $recipient_id; ?>)" id="accept-friend-<?php echo $recipient_id; ?>"><i class="fas fa-check-circle" aria-hidden="true"></i> Accept</span> <span class="mini-profile-decline-friend" onclick="declineFriend(<?php echo $recipient_id; ?>)" id="decline-friend-<?php echo $recipient_id; ?>"><i class="fas fa-times-circle" aria-hidden="true"></i> Decline</span>
</div> &nbsp;
<?php } } } $sql->close(); } else {
    echo $conn->error;
} 
if(isset($none) && $none) {
    echo "You currently have no incoming friend requests.";
} ?>

<h2>Outgoing Friend Requests</h2>
<?php 
$sql = $conn->prepare("SELECT DISTINCT -- `friend_requests`.`timestamp`,
`users`.`userid`,`users`.`usertag`,`users`.`username`,`users`.`registration_timestamp`
-- , IFNULL(MAX(`logins`.`timestamp`),0)
FROM `friend_requests`
LEFT JOIN `users` ON `friend_requests`.`recipient_userid` = `users`.`userid`
-- LEFT JOIN `logins` ON `users`.`userid` = `logins`.`userid`
WHERE `friend_requests`.`sender_userid`=? AND `friend_requests`.`status`=0 LIMIT 10");
if( 
    $sql &&
    $sql->bind_param('i',$_SESSION["userid"]) &&
    $sql->execute() &&
    $sql->store_result() &&
    $sql->bind_result(/*$request_timestamp,*/$recipient_id,$recipient_tag,$recipient_name,$recipient_regdate/*,$recipient_lastlogin*/)
) {
    if($sql->num_rows<1) {
        echo "You currently have no outgoing friend requests.";
    }
    else {
        // $none = true;
        while($sql->fetch()) {
            // if($recipient_lastlogin>0) {
            //     $none = false;
            $sql2 = $conn->prepare("SELECT MAX(`timestamp`) FROM `logins` WHERE `userid`=?");
            if(
                $sql2 &&
                $sql2->bind_param("i",$recipient_id) &&
                $sql2->execute() &&
                $sql2->store_result() &&
                $sql2->bind_result($recipient_lastlogin)
            ) {
                $sql2->fetch();
                ?>
                <div class="mini-profile">
                    <a href="./profile?u=<?php echo $recipient_id; ?>"><span class="mini-profile-name"><?php echo $recipient_name; ?>#<span class="mini-profile-tag"><?php echo $recipient_tag; ?></span></span></a><br/>
                    <!-- <img src="./assets/avocado.png" class="mini-profile-img" /><br/> 
                    <span class="mini-profile-high-score">High Score: 94</span><br/>-->
                    <span class="mini-profile-registered">Registered <?php echo date("j M Y",$recipient_regdate); ?></span><br/>
                    <span class="mini-profile-last-login">Last Active <?php echo date("j M Y",$recipient_lastlogin); ?></span><br/>
                    <span class="mini-profile-cancel-request" onclick="cancelFriend(<?php echo $recipient_id; ?>)" id="cancel-friend-<?php echo $recipient_id; ?>"><i class="fas fa-times-circle" aria-hidden="true"></i> Cancel Request</span>
                </div> &nbsp;
                <?php $sql2->close(); 
            } 
            else {
                echo $conn->error;
            } 
        } 
    } 
    $sql->close(); 
}
else {
    echo $conn->error;
}
// if(isset($none) && $none) {
//     echo "You currently have no outgoing friend requests.";
// } ?>

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

function removeFriend(id) {
    if(parseInt(id) < 1) return;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if(this.responseText == 0) {
                document.getElementById("remove-friend-"+id).innerHTML = "Removed";
                document.getElementById("remove-friend-"+id).classList.add("greyed");
            }
            else {
                console.log(this.responseText);
            }
        }
    };
    xmlhttp.open("GET", "friend_actions.php?do=remove&q=" + id, true);
    xmlhttp.send();
}

function acceptFriend(id) {
    if(parseInt(id) < 1) return;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if(this.responseText == 0) {
                document.getElementById("accept-friend-"+id).innerHTML = "Accepted";
                document.getElementById("accept-friend-"+id).classList.add("greyed");
            }
            else {
                console.log(this.responseText);
            }
        }
    };
    xmlhttp.open("GET", "friend_actions.php?do=accept&q=" + id, true);
    xmlhttp.send();
}

function declineFriend(id) {
    if(parseInt(id) < 1) return;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if(this.responseText == 0) {
                document.getElementById("decline-friend-"+id).innerHTML = "Declined";
                document.getElementById("decline-friend-"+id).classList.add("greyed");
            }
            else {
                console.log(this.responseText);
            }
        }
    };
    xmlhttp.open("GET", "friend_actions.php?do=decline&q=" + id, true);
    xmlhttp.send();
}

function cancelFriend(id) {
    if(parseInt(id) < 1) return;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if(this.responseText == 0) {
                document.getElementById("cancel-friend-"+id).innerHTML = "Cancelled";
                document.getElementById("cancel-friend-"+id).classList.add("greyed");
            }
            else {
                console.log(this.responseText);
            }
        }
    };
    xmlhttp.open("GET", "friend_actions.php?do=cancel&q=" + id, true);
    xmlhttp.send();
}
</script>

<?php }
// Load footer
include 'footer.php'; ?>