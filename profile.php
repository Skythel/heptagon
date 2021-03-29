<?php // User profile
// Set page title
include 'config.php';
$cfg_title = "Profile - MemoryMaze";

if(!isset($_SESSION["userid"])) {
    // Load standard header from file
    include 'header.php';
    echo "<h1>Profile</h1><div class=\"error message\">You must be logged in to view this page. <a href=\"./login\">Login</a></div>";
}
else {
    if(isset($_GET["u"])) {
        $uid = (int)$_GET["u"];
    }
    else {
        $uid = $_SESSION["userid"];
    }
    if(isset($uid)) {
        // Load standard header from file
        include 'header.php';
        $sql = $conn->prepare("SELECT `username`,`usertag` FROM `users` WHERE `userid`=?");
        if(
            $sql &&
            $sql->bind_param("i",$uid) && 
            $sql->execute() &&
            $sql->store_result() &&
            $sql->bind_result($uname,$utag)
        ) {
            if($sql->num_rows<1) {
                echo "<h1>Profile</h1><div class=\"error message\">Sorry, this user does not exist.</div>";
            }
            else {
                while($sql->fetch()) {
                    $cfg_title = (isset($uname) ? $uname."'s " : "")."Profile - MemoryMaze"; 

                    $diff = "easy";
                    $sql2 = $conn->prepare("SELECT `timestamp`,`time_taken`,`obstacles_hit`,`adjusted_score`,`hints_used`,`passcode_attempts` FROM `game_logs` WHERE `userid`=? AND `difficulty`=? GROUP BY `timestamp` ORDER BY `timestamp` DESC LIMIT 5");
                    if(
                        $sql2 &&
                        $sql2->bind_param("is",$uid,$diff) &&
                        $sql2->execute() &&
                        $sql2->store_result() &&
                        $sql2->bind_result($easy_latest_timestamp,$easy_latest_timetaken,$easy_latest_obhit,$easy_latest_score,$easy_latest_hints,$easy_latest_passcodes)
                    ) {
                        if($sql2->num_rows>0) {
                            $easy_latest_output = "<table> 
                                <tr>
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
                                    <td>".date("j M Y H:i",$easy_latest_timestamp)."</td>
                                    <td>".$easy_latest_timetaken." seconds</td>
                                    <td>".$easy_latest_obhit."</td>
                                    <td>".$easy_latest_hints."</td>
                                    <td>".$easy_latest_passcodes."</td>
                                    <td>".$easy_latest_score."</td>
                                </tr>";
                            }
                            $easy_latest_output .= "</table>";
                        }
                        $sql2->close();
                    }
                    else {
                        echo $conn->error;
                    }
                    
                    $diff = "medium";
                    $sql2 = $conn->prepare("SELECT `timestamp`,`time_taken`,`obstacles_hit`,`adjusted_score`,`hints_used`,`passcode_attempts` FROM `game_logs` WHERE `userid`=? AND `difficulty`=? GROUP BY `timestamp` ORDER BY `timestamp` DESC LIMIT 5");
                    if(
                        $sql2 &&
                        $sql2->bind_param("is",$uid,$diff) &&
                        $sql2->execute() &&
                        $sql2->store_result() &&
                        $sql2->bind_result($medium_latest_timestamp,$medium_latest_timetaken,$medium_latest_obhit,$medium_latest_score,$medium_latest_hints,$medium_latest_passcodes)
                    ) {
                        if($sql2->num_rows>0) {
                            $medium_latest_output = " 
                                <tr>
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
                    $sql2 = $conn->prepare("SELECT `timestamp`,`time_taken`,`obstacles_hit`,`adjusted_score`,`hints_used`,`passcode_attempts` FROM `game_logs` WHERE `userid`=? AND `difficulty`=? GROUP BY `timestamp` ORDER BY `timestamp` DESC LIMIT 5");
                    if(
                        $sql2 &&
                        $sql2->bind_param("is",$uid,$diff) &&
                        $sql2->execute() &&
                        $sql2->store_result() &&
                        $sql2->bind_result($hard_latest_timestamp,$hard_latest_timetaken,$hard_latest_obhit,$hard_latest_score,$hard_latest_hints,$hard_latest_passcodes)
                    ) {
                        if($sql2->num_rows>0) {
                            $hard_latest_output = "";
                            while($sql2->fetch()) {
                                $hard_latest_output .= "
                                <tr>
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
                    ?>
                    <!-- Content goes here -->
                    <div class="profile-main">
                        <?php include 'sidebar.php'; ?>
                        
                        <!--main container start-->
                        <div class="container-2">
                            <h1><?php echo (isset($uname) ? $uname."'s " : "")."Profile"; ?></h1>
                            
                            <h2>Easy</h2>
                            <table class="content-table"> 
                                <thead>
                                    <tr>
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
                                        echo "<td colspan=\"6\">This user has not played any games in this category yet.</td>";
                                    } ?>
                                </tbody>
                            </table>

                            <h2>Medium</h2>
                            <table class="content-table"> 
                                <thead>
                                    <tr>
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
                                        echo "<td colspan=\"6\">This user has not played any games in this category yet.</td>";
                                    } ?>
                                </tbody>
                            </table>

                            <h2>Hard</h2>
                            <table class="content-table"> 
                                <thead>
                                    <tr>
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
                                        echo "<td colspan=\"6\">This user has not played any games in this category yet.</td>";
                                    } ?>
                                </tbody>
                            </table>

                        </div>
                        <!--main container end-->
                    </div>
                    <?php
                }
            }
        }
        else {
            echo $conn->error;
        } 
    } 
    else {
        echo "<h1>Profile</h1><div class=\"error message\">Sorry, this page cannot be displayed.</div>";
    }
}

// Load footer
include 'footer.php'; ?>