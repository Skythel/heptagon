<?php include 'config.php';
$gameObj = json_decode($_POST['obj']);
// File for processing scores.
$uid = isset($_SESSION["userid"]) ? $_SESSION["userid"] : 0;
// Save the score
$sql = $conn->prepare("INSERT INTO `game_logs` (`userid`,`timestamp`,`difficulty`,`time_taken`,`obstacles_hit`,`adjusted_score`,`hints_used`,`passcode_attempts`,`raw_data`) VALUES (?,?,?,?,?,?,?,?,?)");
$time = time();
if(
    $sql &&
    $sql->bind_param("iiiiiiiis",$uid,$time,$_POST["diff"],$gameObj->timeTaken,$gameObj->obstaclesHit,$gameObj->score,$gameObj->hintsUsed,$gameObj->passcodeAttempts,$_POST["obj"]) &&
    $sql->execute()
) {
    if(!isset($_SESSION["userid"])) {
        echo 1;
    }
    else {
        echo 0;
    }
}
else {
    // echo $conn->error;
    echo 2;
}
?>