<?php
// Load standard header from file
$cfg_title = "Leaderboard - MemoryMaze";
include 'header.php'; 

$diff = "easy";
$sql2 = $conn->prepare("SELECT `game_logs`.`timestamp`,`game_logs`.`time_taken`,`game_logs`.`obstacles_hit`,`game_logs`.`adjusted_score`,`game_logs`.`hints_used`,`game_logs`.`passcode_attempts`,`users`.`userid`,`users`.`usertag`,`users`.`username` FROM `game_logs` 
LEFT JOIN `users` ON `users`.`userid`=`game_logs`.`userid`
WHERE `difficulty`=? AND `game_logs`.`userid`!=0 GROUP BY `adjusted_score` ORDER BY `adjusted_score` DESC LIMIT 10");
if(
    $sql2 &&
    $sql2->bind_param("s",$diff) &&
    $sql2->execute() &&
    $sql2->store_result() &&
    $sql2->bind_result($easy_latest_timestamp,$easy_latest_timetaken,$easy_latest_obhit,$easy_latest_score,$easy_latest_hints,$easy_latest_passcodes,$easy_uid,$easy_utag,$easy_uname)
) {
    if($sql2->num_rows>0) {
        $easy_latest_output = "
            <tr>   
                <th>User</th>
                <th>Date Played</th>
                <th>Time Taken</th>
                <th>Obstacles Hit</th>
                <th>Hints Used</th>
                <th>Passcode Attempts</th>
                <th>Final Score</th>
            </tr>";
        while($sql2->fetch()) {
            $easy_latest_output .= "
            <tr>
                <td><a href=\"./profile.php?u=".$easy_uid."\">".$easy_uname."#".$easy_utag."</a></td>
                <td>".date("j M Y H:i",$easy_latest_timestamp)."</td>
                <td>".$easy_latest_timetaken." seconds</td>
                <td>".$easy_latest_obhit."</td>
                <td>".$easy_latest_hints."</td>
                <td>".$easy_latest_passcodes."</td>
                <td>".$easy_latest_score."</td>
            </tr>";
        }
    }
    $sql2->close();
}
else {
    echo $conn->error;
}

$diff = "medium";
$sql2 = $conn->prepare("SELECT `game_logs`.`timestamp`,`game_logs`.`time_taken`,`game_logs`.`obstacles_hit`,`game_logs`.`adjusted_score`,`game_logs`.`hints_used`,`game_logs`.`passcode_attempts`,`users`.`userid`,`users`.`usertag`,`users`.`username` FROM `game_logs` 
LEFT JOIN `users` ON `users`.`userid`=`game_logs`.`userid`
WHERE `difficulty`=? AND `game_logs`.`userid`!=0 GROUP BY `adjusted_score` ORDER BY `adjusted_score` DESC LIMIT 10");
if(
    $sql2 &&
    $sql2->bind_param("s",$diff) &&
    $sql2->execute() &&
    $sql2->store_result() &&
    $sql2->bind_result($medium_latest_timestamp,$medium_latest_timetaken,$medium_latest_obhit,$medium_latest_score,$medium_latest_hints,$medium_latest_passcodes,$medium_uid,$medium_utag,$medium_uname)
) {
    if($sql2->num_rows>0) {
        $medium_latest_output = " 
            <tr>
                <th>User</th>
                <th>Date Played</th>
                <th>Time Taken</th>
                <th>Obstacles Hit</th>
                <th>Hints Used</th>
                <th>Passcode Attempts</th>
                <th>Final Score</th>
            </tr>";
        while($sql2->fetch()) {
            $medium_latest_output .= "
            <tr>
                <td><a href=\"./profile.php?u=".$medium_uid."\">".$medium_uname."#".$medium_utag."</a></td>
                <td>".date("j M Y H:i",$medium_latest_timestamp)."</td>
                <td>".$medium_latest_timetaken." seconds</td>
                <td>".$medium_latest_obhit."</td>
                <td>".$medium_latest_hints."</td>
                <td>".$medium_latest_passcodes."</td>
                <td>".$medium_latest_score."</td>
            </tr>";
        }
    }
    $sql2->close();
}
else {
    echo $conn->error;
}

$diff = "hard";
$sql2 = $conn->prepare("SELECT `game_logs`.`timestamp`,`game_logs`.`time_taken`,`game_logs`.`obstacles_hit`,`game_logs`.`adjusted_score`,`game_logs`.`hints_used`,`game_logs`.`passcode_attempts`,`users`.`userid`,`users`.`usertag`,`users`.`username` FROM `game_logs` 
LEFT JOIN `users` ON `users`.`userid`=`game_logs`.`userid`
WHERE `difficulty`=? AND `game_logs`.`userid`!=0 GROUP BY `adjusted_score` ORDER BY `adjusted_score` DESC LIMIT 10");
if(
    $sql2 &&
    $sql2->bind_param("s",$diff) &&
    $sql2->execute() &&
    $sql2->store_result() &&
    $sql2->bind_result($hard_latest_timestamp,$hard_latest_timetaken,$hard_latest_obhit,$hard_latest_score,$hard_latest_hints,$hard_latest_passcodes,$hard_uid,$hard_utag,$hard_uname)
) {
    if($sql2->num_rows>0) {
        $hard_latest_output = "";
        while($sql2->fetch()) {
            $hard_latest_output .= "
            <tr>   
                <td><a href=\"./profile.php?u=".$hard_uid."\">".$hard_uname."#".$hard_utag."</a></td>
                <td>".date("j M Y H:i",$hard_latest_timestamp)."</td>
                <td>".$hard_latest_timetaken." seconds</td>
                <td>".$hard_latest_obhit."</td>
                <td>".$hard_latest_hints."</td>
                <td>".$hard_latest_passcodes."</td>
                <td>".$hard_latest_score."</td>
            </tr>";
        }
    }
    $sql2->close();
}
else {
    echo $conn->error;
}

// Combined
$sql2 = $conn->prepare("SELECT `game_logs`.`difficulty`,`game_logs`.`timestamp`,`game_logs`.`time_taken`,`game_logs`.`obstacles_hit`,`game_logs`.`adjusted_score`,`game_logs`.`hints_used`,`game_logs`.`passcode_attempts`,`users`.`userid`,`users`.`usertag`,`users`.`username` FROM `game_logs` 
LEFT JOIN `users` ON `users`.`userid`=`game_logs`.`userid`
WHERE `game_logs`.`userid`!=0 GROUP BY `adjusted_score` ORDER BY `adjusted_score` DESC LIMIT 10");
if(
    $sql2 &&
    // $sql2->bind_param("s",$diff) &&
    $sql2->execute() &&
    $sql2->store_result() &&
    $sql2->bind_result($overall_diff,$overall_timestamp,$overall_timetaken,$overall_obhit,$overall_score,$overall_hints,$overall_passcodes,$overall_uid,$overall_utag,$overall_uname)
) {
    if($sql2->num_rows>0) {
        $overall_output = "";
        while($sql2->fetch()) {
            $overall_output .= "
            <tr>   
                <td>".$overall_diff."</td>
                <td><a href=\"./profile.php?u=".$overall_uid."\">".$overall_uname."#".$overall_utag."</a></td>
                <td>".date("j M Y H:i",$overall_timestamp)."</td>
                <td>".$overall_timetaken." seconds</td>
                <td>".$overall_obhit."</td>
                <td>".$overall_hints."</td>
                <td>".$overall_passcodes."</td>
                <td>".$overall_score."</td>
            </tr>";
        }
    }
    $sql2->close();
}
else {
    echo $conn->error;
}
?>
<h2>Easy</h2>
<table class="content-table"> 
    <thead>
        <tr>
            <th>User</th>
            <th>Date Played</th>
            <th>Time Taken</th>
            <th>Obstacles Hit</th>
            <th>Hints Used</th>
            <th>Passcode Attempts</th>
            <th>Final Score</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(isset($easy_latest_output)) {
            echo $easy_latest_output;
        } else {
            echo "<td colspan=\"7\">No games have been played in this category yet.</td>";
        } ?>
    </tbody>
</table>

<h2>Medium</h2>
<table class="content-table"> 
    <thead>
        <tr>
            <th>User</th>
            <th>Date Played</th>
            <th>Time Taken</th>
            <th>Obstacles Hit</th>
            <th>Hints Used</th>
            <th>Passcode Attempts</th>
            <th>Final Score</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($medium_latest_output)) {
            echo $medium_latest_output;
        } else {
            echo "<td colspan=\"7\">No games have been played in this category yet.</td>";
        } ?>
    </tbody>
</table>

<h2>Hard</h2>
<table class="content-table"> 
    <thead>
        <tr>
            <th>User</th>
            <th>Date Played</th>
            <th>Time Taken</th>
            <th>Obstacles Hit</th>
            <th>Hints Used</th>
            <th>Passcode Attempts</th>
            <th>Final Score</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($hard_latest_output)) {
            echo $hard_latest_output;
        }
        else {
            echo "<td colspan=\"7\">No games have been played in this category yet.</td>";
        } ?>
    </tbody>
</table>

<h2>Overall</h2>
<table class="content-table"> 
    <thead>
        <tr>
            <th>Difficulty</th>
            <th>User</th>
            <th>Date Played</th>
            <th>Time Taken</th>
            <th>Obstacles Hit</th>
            <th>Hints Used</th>
            <th>Passcode Attempts</th>
            <th>Final Score</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($overall_output)) {
            echo $overall_output;
        }
        else {
            echo "<td colspan=\"8\">No games have been played in this category yet.</td>";
        } ?>
    </tbody>
</table>

<?php
// Load footer
include 'footer.php'; 
?>


