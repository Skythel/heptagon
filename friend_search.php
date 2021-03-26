<?php
include 'config.php';

// lazy-a way to pick all names from database since we won't be expecting a lot of users anyway for demo purposes
$sql = $conn->prepare("SELECT `username`,`userid`,`usertag` FROM `users`");
if( 
    $sql &&
    $sql->execute() &&
    $sql->store_result() &&
    $sql->bind_result($uname,$uid,$utag)
) { 
    while($sql->fetch()) {
        $suggestions[] = [$uname,$uid,$utag];
    }
}
if(isset($_GET["q"])) {
    $q = $_GET["q"];
    $output = "";
    if ($q !== "") {
        $q = strtolower($q);
        $len = strlen($q);
        foreach($suggestions as $user) {
            if (stristr($q, substr($user[0], 0, $len))) {
                $output .= '
                    <div class="friend-sugg micro-profile">
                        <span class="micro-profile-name">'.$user[0].'</span>#<span class="micro-profile-tag">'.$user[2].'</span>
                    </div>
                ';
            }
        }
        echo $output=="" ? "No users found." : $output;
    }
}

?>