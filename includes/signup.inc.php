<?php

// Check if the form submit button named "submit" was clicked
if(isset($_POST["submit"]))
{
    // Retrieve data from the form
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];

    // Include necessary class files
    include "../classes/dbh.class.php";
    include "../classes/signup.class.php";
    include "../classes/signup-contr.class.php";

    // Create an instance of the SignupContr class and pass username, password, and password repeat
    $signup = new SignupContr($username, $pwd, $pwdrepeat);

    // Call the signupUser method from SignupContr to process user signup
    $signup->signupUser();

    // Redirect to index page with a success message (assuming no errors occurred)
    header("location: ../index.php?error=none");
}
?>
