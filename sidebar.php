<!--sidebar start-->
<?php 
if(isset($_SESSION["userid"])) {
    if(!isset($userprofile_id)) {
        $userprofile_id = $_SESSION["userid"];
    }
    $result = false;
    $sql = $conn->prepare("SELECT `users`.`userid`,`users`.`usertag`,`users`.`username`,`users`.`registration_timestamp`,`logins`.`timestamp`
    FROM `users`
    LEFT JOIN `logins` ON `users`.`userid` = `logins`.`userid`
    LEFT JOIN `game_logs` ON `logins`.`userid` = `game_logs`.`userid`
    WHERE `users`.`userid` = ?");
    if(
        $sql &&
        $sql->bind_param('i',$userprofile_id) &&
        $sql->execute() &&
        $sql->store_result() &&
        $sql->bind_result($uid,$utag,$uname,$uregdate,$ulastlog)
    ) {
        $sql2 = $conn->prepare("SELECT `timestamp`,`adjusted_score` 
        FROM `game_logs` WHERE `userid`=? AND `difficulty`=? GROUP BY `adjusted_score` ORDER BY `adjusted_score` DESC LIMIT 1");
        $diff = "easy";
        if(
            $sql2 &&
            $sql2->bind_param('is',$userprofile_id,$diff) &&
            $sql2->execute() &&
            $sql2->store_result() &&
            $sql2->bind_result($easy_time,$easy_score)
        ) {
            if($sql2->num_rows<1) {
                $easy_time = 0;
                $easy_score = 0;
            }
            $sql2->close();
        }
        else {
            echo $conn->error;
        }
        $sql2 = $conn->prepare("SELECT `timestamp`,`adjusted_score` 
        FROM `game_logs` WHERE `userid`=? AND `difficulty`=? GROUP BY `adjusted_score` ORDER BY `adjusted_score` DESC LIMIT 1");
        $diff = "medium";
        if(
            $sql2 &&
            $sql2->bind_param('is',$userprofile_id,$diff) &&
            $sql2->execute() &&
            $sql2->store_result() &&
            $sql2->bind_result($medium_time,$medium_score)
        ) {
            if($sql2->num_rows<1) {
                $medium_time = 0;
                $medium_score = 0;
            }
            $sql2->close();
        }
        else {
            echo $conn->error;
        }
        $sql2 = $conn->prepare("SELECT `timestamp`,`adjusted_score` 
        FROM `game_logs` WHERE `userid`=? AND `difficulty`=? GROUP BY `adjusted_score` ORDER BY `adjusted_score` DESC LIMIT 1");
        $diff = "hard";
        if(
            $sql2 &&
            $sql2->bind_param('is',$userprofile_id,$diff) &&
            $sql2->execute() &&
            $sql2->store_result() &&
            $sql2->bind_result($hard_time,$hard_score)
        ) {
            if($sql2->num_rows<1) {
                $hard_time = 0;
                $hard_time = 0;
            }
            $sql2->close();
        }
        else {
            echo $conn->error;
        }
        $sql->close();
    }
    else {
        echo $conn->error;
    }
?>
<div class="sidebar">
    <div class="sidebar-menu">
        <center class="profile">
            <!-- <img src="./assets/citrus.png" class="profile-img"/> -->
            <p><?php echo $uname; ?></p>
        </center>
        <li class="item">
            <a href="./profile?u=<?php echo $uid; ?>" class="menu-btn">
                <i class="fas fa-user"></i><span>Profile</span>
            </a>
        </li>
        <li class="item">
            <a href="./my-scores" class="menu-btn">
                <i class="fas fa-trophy"></i><span>Highscore (Easy): <?php echo $easy_score; ?></span>
            </a>
        </li>
        <li class="item">
            <a href="./my-scores" class="menu-btn">
                <i class="fas fa-trophy"></i><span>Highscore (Medium): <?php echo $medium_score; ?></span>
            </a>
        </li>
        <li class="item">
            <a href="./my-scores" class="menu-btn">
                <i class="fas fa-trophy"></i><span>Highscore (Hard): <?php echo $hard_score; ?></span>
            </a>
        </li>
        <?php 
        // if($userprofile_id!==$_SESSION["userid"]) { 
        //     $sql = $conn->prepare("SELECT `status` FROM `friend_requests` WHERE (`sender_userid`=? AND `recipient_userid`=?) OR (`sender_userid`=? AND `recipient_userid`=?)");
        //     if(
        //         $sql &&
        //         $sql->bind_param('iiii',$userprofile_id,$_SESSION["userid"],$_SESSION["userid"],$userprofile_id) &&
        //         $sql->execute() &&
        //         $sql->store_result() && 
        //         $sql->bind_result($status)
        //     ) {
        //         if($sql->num_rows<1) {
        //         }
        //         else {
        //         <li class="item">
        //             <a href="./friends" class="menu-btn">
        //                 <i class="fas fa-handshake"></i><span>Add Friend</span>
        //             </a>
        //         </li>
        //     }
        ?>
    </div>
</div>
<?php } ?>
<!--sidebar end-->