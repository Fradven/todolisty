<?php

session_start(); // Start the session at the beginning

class Login extends Dbh {

    public function getUser($username, $pwd) {
        $stmt = $this->connect()->prepare('SELECT id, username, role_id, password FROM users WHERE username = ?;');
        
        if (!$stmt->execute(array($username))) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$userData) {
            header("location: ../index.php?error=noUserFound");
            exit();
        }

        $hashedPwd = $userData['password'];
        $pwdCheck = password_verify($pwd, $hashedPwd);

        if (!$pwdCheck) {
            header("location: ../index.php?error=wrongPassword");
            exit();
        }

        $_SESSION["usernameid"] = $userData["id"];
        $_SESSION["username"] = $userData["username"];
        $_SESSION["roleid"] = $userData["role_id"];
    }
}
?>
