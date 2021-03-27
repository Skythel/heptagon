<?php
include 'config.php';

if(isset($_GET["q"]) && isset($_SESSION["userid"])) {
    $q = $_GET["q"];
    $sql = $conn->prepare("SELECT * FROM `users` WHERE `userid`=?");
    if( 
        $sql &&
        $sql->bind_param('i',$q) &&
        $sql->execute() &&
        $sql->store_result() 
    ) { 
        if($sql->num_rows>0) { 
            if($sql->fetch()) {
                $sql2 = $conn->prepare("INSERT INTO `friend_requests` (`sender_userid`,`recipient_userid`,`timestamp`,`status`) VALUES (?,?,?,?)");
                $time = time();
                $status = 0;
                if(
                    $sql2 &&
                    $sql2->bind_param('iiii',$_SESSION["userid"],$q,$time,$status) &&
                    $sql2->execute() 
                ) {
                    echo 0;
                }
                else {
                    echo $conn->error;
                }
            }
            else {
                echo $conn->error;
            }
        }
        else {
            echo "user cannot be found";
        }
        $sql2->close();
    }
    $sql->close();
}

?>