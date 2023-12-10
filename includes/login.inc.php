<?php

// Check if the form submit button named "submit" was clicked
if (isset($_POST["submit"])) {

    // Retrieve data from the form
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    // $pwdrepeat = $_POST["pwdrepeat"];

    include "../classes/dbh.class.php";
    include "../classes/login.class.php";
    include "../classes/login-contr.class.php";

    // Create an instance of the LoginContr class and pass username and password
    $login = new loginContr($username, $pwd);

    // Call the loginUser method from LoginContr to process user login
    $login->loginUser();

    if (ob_get_length()) {
        ob_end_clean();
    }

    // Redirect to index page with a success message (assuming no errors occurred)
    header("location: ../index.php?error=none");
    exit();
}
