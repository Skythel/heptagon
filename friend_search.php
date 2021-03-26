<?php
include 'config.php';

// lazy-a way to pick all names from database since we won't be expecting a lot of users anyway for demo purposes
$sql = $conn->prepare("SELECT `username`,`userid`,`usertag` FROM `users` WHERE `userid`!=? LIMIT 10");
if( 
    $sql &&
    $sql->bind_param('i',$_SESSION["userid"]) &&
    $sql->execute() &&
    $sql->store_result() &&
    $sql->bind_result($uname,$uid,$utag)
) { 
    $suggestions = [];
    while($sql->fetch()) {
        $suggestions[] = [$uname,$uid,$utag];
    }
}
$sql->close();

if(isset($_GET["q"])) {
    $q = $_GET["q"];
    $output = "";
    if ($q !== "") {
        $q = strtolower($q);
        $len = strlen($q);
        foreach($suggestions as $user) {
            if (stristr($q, substr($user[0], 0, $len))) {
                $sql = $conn->prepare("SELECT * FROM `friend_requests` WHERE `sender_userid`=? AND `recipient_userid`=?");
                if(
                    $sql &&
                    $sql->bind_param("ii",$_SESSION["userid"],$q) &&
                    $sql->execute() &&
                    $sql->store_result()
                ) {
                    $added = $sql->num_rows>0 ? true : false;
                    $output .= '
                    <div class="friend-sugg micro-profile">
                        <a href="profile?u='.$user[1].'"><span class="micro-profile-name">'.$user[0].'</span>#<span class="micro-profile-tag">'.$user[2].'</span></a><br/>
                        '.($added ? '<button id="addfriend-'.$user[1].'" class="greyed">Add Friend</button>' : '<button onclick="addFriend('.$user[1].')" id="addfriend-'.$user[1].'">Add Friend</button>').'
                    </div>
                    ';
                }
                else {
                    echo $conn->error;
                }
            }
        }
        echo $output=="" ? "No users found." : $output;
    }
}

?>