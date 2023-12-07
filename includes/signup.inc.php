<?php

if(isset($_POST["submit"]))
{
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];

    include "../classes/dbh.class.php";
    include "../classes/signup.class.php";
    include "../classes/signup-contr.class.php";
    $signup = new SignupContr($username, $pwd, $pwdrepeat);

    $signup->signupUser();

    header("location: ../index.php?error=none");
}