<?php
    session_start();
    $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

    $query = $db->prepare("INSERT INTO ae_User (username, password) VALUES (?, ?)");
    $query->bind_param("ss", $_POST["user"], $_POST["pass"]);
    $query->execute();
    
    $query->close();
    $db->close();
?>