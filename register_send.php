<?php
// Registration validation file
// Inputs: username, email and password
// Outputs: int 1 if email exists. int 2 if server error. int 0 if registration successful. 

// Function for generating verification code
function getRandomString($n) {
    $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $randomString = '';
    for ($i=0; $i<$n; $i++) {
        $index = mt_rand(0, strlen($characters)-1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}

if(isset($_POST["u"]) && isset($_POST["e"]) && isset($_POST["p"])) {
    $u = $conn->real_escape_string($_POST["u"]);
    $e = $conn->real_escape_string($_POST["e"]);
    $p = $conn->real_escape_string(password_hash($_POST["p"],PASSWORD_DEFAULT));
    $continue = false;
    // Query if email exists
    $sql = $conn->prepare("SELECT * FROM `users` WHERE `email`=?");
    if( 
        $sql &&
        $sql->bind_param('s',$e) &&
        $sql->execute() &&
        $sql->store_result() 
    ) {
        if($sql->num_rows<1) {
            $continue = true;
        }
        else {
            return 1;
        }
    }
    else {
        echo $conn->error;
        return 2;
    }
    $sql->close();

    if($continue) {
        // Generate random usertag (4 digits)
        $tag = sprintf("%04d",mt_rand(0,9999));
        // Generate random email verification code
        $hash = getRandomString(5);
        // Store into users db
        $query = "INSERT INTO `users` (`usertag`,`username`,`email`,`password`,`registration_timestamp`,`registration_ip`,`verification_code`) VALUES (?,?,?,?,?,?,?)";
        $sql = $conn->prepare($query);
        if(
            $sql &&
            $sql->bind_param('isssiss',$tag,$u,$e,$p,time(),$_SERVER["REMOTE_ADDR"],$hash) &&
            $sql->execute()
        ) {
            // On hold, low priority
            // Email the verification code to user
            // $subject = "Welcome to MemoryMaze!";
            // $txt = "Please click on this link to activate your account:";
            // $headers = "From: webmaster@example.com";
            // mail($e,$subject,$txt,$headers);
            return $query;
        }
        else {
            echo $conn->error;
            return 2;
        }
        $sql->close();
    }

}

?>