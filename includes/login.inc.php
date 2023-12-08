<?php

if(isset($_POST["submit"]))
{
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];

    include "../classes/dbh.class.php";
    include "../classes/login.class.php";
    include "../classes/login-contr.class.php";
    $login = new loginContr($username, $pwd);

    $login->loginUser();

    header("location: ../index.php?error=none");
}
