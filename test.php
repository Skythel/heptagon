<?php include 'config.php'; 
$sql = $conn->prepare("SELECT `username`,`usertag` FROM `users` WHERE `userid`=?");
$uid = "10";
if(
    $sql &&
    $sql->bind_param("i",$uid) && 
    $sql->execute() &&
    $sql->store_result() &&
    $sql->bind_result($uname,$utag)
) {
    $sql->fetch();
    echo $uname.$utag;
}
?>