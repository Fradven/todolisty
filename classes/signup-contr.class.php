<?php

class SignupContr extends Signup
{
    private $pwd;
    private $pwdrepeat;
    private $username;

    // Constructor to initialize username, password, and password repeat
    public function __construct($username, $pwd, $pwdrepeat)
    {
        $this->username = $username;
        $this->pwd = $pwd;
        $this->pwdrepeat = $pwdrepeat;
    }

    // Function to sign up a user
    public function signupUser()
    {
        // Check for empty input fields
        if ($this->emptyInput() == false) {
            header("location: ../index?error=emptyinput");
            exit();
        }

        // Check for invalid username
        if ($this->invalidUsername() == false) {
            header("location: ../index?error=invalidUsername");
            exit();
        }

        // Check if passwords match
        if ($this->pwdMatch() == false) {
            header("location: ../index?error=pwdMatch");
            exit();
        }

        // Check if username is already taken
        if ($this->checkUsernameTaken() == false) {
            header("location: ../index?error=checkUsernameTaken");
            exit();
        }

        // Set the user (presumably create a new user) using provided username and password
        $this->setUser($this->username, $this->pwd);
    }

    /*
     * Function to check for empty input fields
     * Returns false if any field (password, password repeat, username) is empty
     */
    private function emptyInput()
    {
        if (empty($this->pwd) || empty($this->pwdrepeat) || empty($this->username))
            return false;
        else
            return true;
    }

    /*
     * Function to check username format is valid using regular expression
     * Returns false if the username contains invalid characters
     */
    private function invalidUsername()
    {
        if (!preg_match("/^[a-zA-Z0-9-_\.]*$/", $this->username))
            return false;
        else
            return true;
    }

    /*
     * Function to check if passwords match
     * Returns false if passwords do not match
     */
    private function pwdMatch()
    {
        if ($this->pwd !== $this->pwdrepeat)
            return false;
        else
            return true;
    }

    /*
     * Function to check if the username is already taken
     * Returns false if the username already exists
     */
    private function checkUsernameTaken()
    {
        if (!$this->checkUser($this->username))
            return false;
        else
            return true;
    }
}
