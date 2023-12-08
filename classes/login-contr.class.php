<?php

class LoginContr extends Login
{
    private $pwd;
    private $username;

    // Constructor to initialize the username and password properties
    public function __construct($username, $pwd)
    {
        $this->username = $username;
        $this->pwd = $pwd;
    }

    /**
     * Method to log in a user after checking if the inputs are empty
     */
    public function loginUser()
    {
        // Check for empty input fields
        if ($this->emptyInput() == false) {
            // Redirect to the index page with an error message if input is empty
            header("location: ../index?error=emptyinput");
            exit();
        }

        // Call the getUser method to retrieve user data
        $this->getUser($this->username, $this->pwd);
    }

    /**
     *  Method to check for empty input fields
     */
    private function emptyInput()
    {
        // Check if either password or username is empty
        if (empty($this->pwd) || empty($this->username)) {
            return false; // Return false if either field is empty
        } else {
            return true; // Return true if both fields have input
        }
    }
}
