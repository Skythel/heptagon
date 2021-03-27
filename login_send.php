<?php
// Login validation file
// Inputs: username and password
// Outputs: int 1 if wrong credentials. int 2 if server error. int 0 if login successful. 

include 'config.php';

if(isset($_POST["u"]) && isset($_POST["p"])) {
    $u = $conn->real_escape_string($_POST["u"]);
    $p = $conn->real_escape_string($_POST["p"]);
    $continue = false;
    // Query if username exists
    $sql = $conn->prepare("SELECT * FROM `users` WHERE `email`=?");
    if( 
        $sql &&
        $sql->bind_param('s',$u) &&
        $sql->execute() &&
        $sql->store_result() 
    ) {
        if($sql->num_rows>0) {
            $continue = true;
        }
        else {
            echo 1;
        }
    }
    else {
        echo 2;
    }
    $sql->close();

    if($continue) {
        // Verify password
        $sql = $conn->prepare("SELECT `password` FROM `users` WHERE `email`=?");
        if( 
            $sql &&
            $sql->bind_param('s',$u) &&
            $sql->execute() &&
            $sql->store_result() &&
            $sql->bind_result($hash)
        ) {
            if($sql->fetch()) {
                if(password_verify($p,$hash)) {
                    // Get userid
                    $sql2 = $conn->prepare("SELECT `username`,`userid`,`usertag` FROM `users` WHERE `email`=?");
                    if( 
                        $sql2 &&
                        $sql2->bind_param('s',$u) &&
                        $sql2->execute() &&
                        $sql2->store_result() &&
                        $sql2->bind_result($uname,$uid,$utag)
                    ) {
                        if($sql2->fetch()) {
                            // Log the user in
                            $_SESSION["userid"] = $uid;
                            $_SESSION["username"] = $uname;
                            $_SESSION["usertag"] = $utag;
                            // Update last login time in database
                            $sql2 = $conn->prepare("INSERT INTO `logins` (`userid`,`timestamp`,`ip`) VALUES (?,?,?)");
                            $time = time();
                            if( 
                                $sql2 &&
                                $sql2->bind_param('iis',$uid,$time,$_SERVER['REMOTE_ADDR']) &&
                                $sql2->execute()
                            ) {
                                echo 0;
                            }
                            else {
                                // echo $conn->error;
                                echo 2;
                            }
                        }
                        else {
                            // echo $conn->error;
                            echo 2;
                        }
                    }
                    $sql2->close();
                }
                else {
                    echo 1;
                }
            }
            
        }
        else {
            // echo $conn->error;
            echo 2;
            $sql->close();
        }
    }

}

?>