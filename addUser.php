<?php
    session_start();
    $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

    $query = $db->prepare("INSERT INTO ae_User (username, password) VALUES (?, ?)");
    $hash = password_hash($_POST["pass"], PASSWORD_DEFAULT);
    $query->bind_param("ss", $_POST["user"], $hash);
    $query->execute();
    
    $query->close();
    $db->close();
?>