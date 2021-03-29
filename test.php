<?php include 'config.php'; 
$sql = $conn->prepare("SELECT DISTINCT `friend_requests`.`timestamp`,`users`.`userid`,`users`.`usertag`,`users`.`username`,`users`.`registration_timestamp`,MAX(`logins`.`timestamp`)
FROM `friend_requests`
LEFT JOIN `users` ON `friend_requests`.`recipient_userid` = `users`.`userid`
LEFT JOIN `logins` ON `users`.`userid` = `logins`.`userid`
WHERE (`friend_requests`.`sender_userid`=? OR `friend_requests`.`recipient_userid`=?) AND `friend_requests`.`status`=1 LIMIT 10");
$i = 100;
if(
    $sql &&
    $sql->bind_param('ii',$i,$i) &&
    $sql->execute() &&
    $sql->store_result() &&
    $sql->bind_result($request_timestamp,$recipient_id,$recipient_tag,$recipient_name,$recipient_regdate,$recipient_lastlogin)
) {
    echo $sql->num_rows;
}
?>