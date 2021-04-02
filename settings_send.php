<?php include 'config.php';
// File for saving profile settings.
if(isset($_POST["u"]) && isset($_POST["e"]) && $_POST["u"]!=="" && $_POST["e"]!=="") {
    $u = $conn->real_escape_string($_POST["u"]);
    $e = $conn->real_escape_string($_POST["e"]);
    if($_POST["p"]!=="" && $_POST["pconf"]!=="" && $_POST["p"]==$_POST["pconf"]) {
        $p = $conn->real_escape_string(password_hash($_POST["p"],PASSWORD_DEFAULT));
    }
    $age = $conn->real_escape_string($_POST["age"]);
    $hist = $conn->real_escape_string($_POST["hist"]);
    $fav = $conn->real_escape_string($_POST["fav"]);
    $bio = $conn->real_escape_string($_POST["bio"]);
    $pref = $conn->real_escape_string($_POST["pref"]);

    if(isset($p)) {
        $sql = $conn->prepare("UPDATE `users` SET `username`=?, `email`=?, `age`=?, `history`=?, `fav_food`=?, `bio`=?, `preferred_diff`=?, `password`=? WHERE `userid`=?");
        if(
            $sql &&
            $sql->bind_param($u,$e,$age,$hist,$fav,$bio,$pref,$p) &&
            $sql->execute()
        ) {
            echo 0;
        }
        else {
            echo $conn->error;
        }
    }
    else {
        $sql = $conn->prepare("UPDATE `users` SET `username`=?, `email`=?, `age`=?, `history`=?, `fav_food`=?, `bio`=?, `preferred_diff`=? WHERE `userid`=?");
        if(
            $sql &&
            $sql->bind_param($u,$e,$age,$hist,$fav,$bio,$pref) &&
            $sql->execute()
        ) {
            echo 0;
        }
        else {
            echo $conn->error;
        }
    }
    $sql->close();
}
else {
    echo 1;
}