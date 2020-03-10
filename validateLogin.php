<?php
    session_start();
    $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

    $query = $db->prepare("SELECT * FROM ae_User WHERE username = ? AND password = ?");
    $query->bind_param("ss", $_POST["user"], $_POST["pass"]);
    $query->execute();
    $query->bind_result($userId, $user, $pass);

    if($query->fetch()){
        $_SESSION["userId"] = $userId;
        $query->close();
        $db->close();
        header("Location: http://judah.cedarville.edu/~miller/TermProject/project4.php");
        echo true;
    }
    else{
        $query->close();
        $db->close();
        echo false;
    }
?>