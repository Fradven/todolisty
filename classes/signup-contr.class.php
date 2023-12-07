<?php

class SignupContr extends Signup
{
    private $pwd;
    private $pwdrepeat;
    private $username;

    public function __construct($username, $pwd, $pwdrepeat)
    {
        $this->username = $username;
        $this->pwd = $pwd;
        $this->pwdrepeat = $pwdrepeat;
    }

    public function signupUser()
    {
        if($this->emptyInput() == false)
        {
            header("location: ../index?error=emptyinput");
            exit();
        }

        if($this->invalidUsername() == false)
        {
            header("location: ../index?error=invalidUsername");
            exit();
        }

        if($this->pwdMatch() == false)
        {
            header("location: ../index?error=pwdMatch");
            exit();
        }

        if($this->checkUsernameTaken() == false)
        {
            header("location: ../index?error=checkUsernameTaken");
            exit();
        }

        $this->setUser($this->username, $this->pwd);
    }

    private function emptyInput()
    {
        if (empty($this->pwd) || empty($this->pwdrepeat) || empty($this->username))
            return false;
        else
            return true;
    }

    private function invalidUsername()
    {
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username))
            return false;
        else
            return true;
    }

    private function pwdMatch()
    {
        if ($this->pwd !== $this->pwdrepeat)
            return false;
        else
            return true;
    }

    private function checkUsernameTaken()
    {
        if (!$this->checkUser($this->username))
            return false;
        else
            return true;
    }
}
