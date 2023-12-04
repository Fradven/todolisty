<?php

class SignupContr extends Signup
{
    private $uid;
    private $pwd;
    private $pwdrepeat;
    private $username;

    public function __construct($uid, $pwd, $pwdrepeat, $username)
    {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->pwdrepeat = $pwdrepeat;
        $this->username = $username;
    }

    public function signupUser()
    {
        if($this->emptyInput() == false)
        {
            header("location: ../index?error=emptyinput");
            exit();
        }

        if($this->invalidUid() == false)
        {
            header("location: ../index?error=invalidUid");
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
        if (empty($this->uid) || empty($this->pwd) || empty($this->pwdrepeat) || empty($this->username))
            return false;
        else
            return true;
    }

    private function invalidUid()
    {
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->uid))
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
        if (!$this->checkUser($this->uid, $this->username))
            return false;
        else
            return true;
    }
}
