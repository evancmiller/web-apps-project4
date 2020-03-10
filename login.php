<!DOCTYPE HTML>
<?php
    session_start();
    session_unset();
?>
<html lang="en">
    <head>
        <title>CS3220 - Alec Mathisen & Evan Miller Project 4 Login</title>
        <link rel="stylesheet" type="text/css" href="css/project4.css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script lang="javascript" src="js/login.js" defer></script>
    </head>
    <body>
        <div class="row">
            <div class="col-11">
                <h1>Login</h1>
            </div>
            <div class="col-1">
                <img src="img/cedarvilleLogo.png" alt="Cedarville University Logo" height="48" width="48" class="align-right"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12 section">
                        <label for="username">Username</label><br>
                        <input type="text" class="login" name="username" id="username" value="" onchange="this.classList.remove('error');"><br>
                        <label for="password">Password</label><br>
                        <input type="password" class="login" name="password" id="password" value="" onchange="this.classList.remove('error');">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 centered">
                        <input type="button" value="Submit" onclick="validateLogin();">
                    </div>
                    <div class="col-6 centered">
                        <input type="button" value="Add User" onclick="addUser();">
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </body>
</html>