<?php

class Signup extends Dbh {

    protected function setUser($username, $pwd)
    {
        $stmt = $this->connect()->prepare('INSERT INTO users (username, password, role_id) VALUES (?, ?, ?);');

        $hashdPwd = password_hash($pwd, PASSWORD_DEFAULT);

        if(!$stmt->execute(array($username, $hashdPwd, 2)))
        {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    protected function checkUser($username) {
        $stmt = $this->connect()->prepare('SELECT id FROM users where username = ?');

        if(!$stmt->execute(array($username))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() > 0) {
            return false;
        }
        else
            return true;
    }
}