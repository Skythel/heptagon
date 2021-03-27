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
                if(isset($_GET["do"])) {
                    if($_GET["do"]=="remove") {
                        $sql2 = $conn->prepare("UPDATE `friend_requests` SET `status`=2 WHERE (`sender_userid`=? AND `recipient_userid`=?) OR (`sender_userid`=? AND `recipient_userid`=?)");
                        if(
                            $sql2 &&
                            $sql2->bind_param('iiii',$_SESSION["userid"],$q,$q,$_SESSION["userid"]) &&
                            $sql2->execute() 
                        ) {
                            echo 0;
                        }
                        else {
                            echo $conn->error;
                        }
                        $sql2->close();
                    }
                    elseif($_GET["do"]=="accept") {
                        $sql2 = $conn->prepare("UPDATE `friend_requests` SET `status`=1 WHERE `sender_userid`=? AND `recipient_userid`=?");
                        if(
                            $sql2 &&
                            $sql2->bind_param('ii',$q,$_SESSION["userid"]) &&
                            $sql2->execute() 
                        ) {
                            echo 0;
                        }
                        else {
                            echo $conn->error;
                        }
                        $sql2->close();
                    }
                    elseif($_GET["do"]=="decline") {
                        $sql2 = $conn->prepare("UPDATE `friend_requests` SET `status`=-1 WHERE `sender_userid`=? AND `recipient_userid`=?");
                        if(
                            $sql2 &&
                            $sql2->bind_param('ii',$q,$_SESSION["userid"]) &&
                            $sql2->execute() 
                        ) {
                            echo 0;
                        }
                        else {
                            echo $conn->error;
                        }
                        $sql2->close();
                    }
                    elseif($_GET["do"]=="cancel") {
                        $sql2 = $conn->prepare("DELETE FROM `friend_requests` WHERE `sender_userid`=? AND `recipient_userid`=?");
                        if(
                            $sql2 &&
                            $sql2->bind_param('ii',$_SESSION["userid"],$q) &&
                            $sql2->execute() 
                        ) {
                            echo 0;
                        }
                        else {
                            echo $conn->error;
                        }
                        $sql2->close();
                    }
                    else {
                        echo "invalid operation.";
                    }
                }
            }
            else {
                echo $conn->error;
            }
        }
        else {
            echo "user cannot be found";
        }
    }
    $sql->close();
}
?>