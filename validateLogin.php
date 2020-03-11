<?php
    session_start();
    $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

    $query = $db->prepare("SELECT * FROM ae_User WHERE username = ?");
    $query->bind_param("s", $_POST["user"]);
    $query->execute();
    $query->bind_result($userId, $user, $pass);

    if($query->fetch() && password_verify($_POST["pass"], $pass)){
        $_SESSION["userId"] = $userId;
        $_SESSION["user"] = $user;
        $query->close();
        $db->close();
        echo true;
    }
    else{
        $query->close();
        $db->close();
        echo false;
    }
?>