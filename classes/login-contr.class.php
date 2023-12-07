<?php

class LoginContr extends Login
{
    private $pwd;
    private $username;

    public function __construct($username, $pwd)
    {
        $this->username = $username;
        $this->pwd = $pwd;
    }

    public function loginUser()
    {
        if($this->emptyInput() == false)
        {
            header("location: ../index?error=emptyinput");
            exit();
        }

        $this->getUser($this->username, $this->pwd);
    }

    private function emptyInput()
    {
        if (empty($this->pwd) || empty($this->username))
            return false;
        else
            return true;
    }
}
