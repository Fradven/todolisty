<?php

session_start(); // Start the session at the beginning

class Login extends Dbh
{
    /**
     *  Method to get user information based on the provided username and password 
     * */
    public function getUser($username, $pwd)
    {
        // Prepare SQL statement to select user information by username
        $stmt = $this->connect()->prepare('SELECT id, username, role_id, password FROM users WHERE username = ?;');

        // Execute the prepared statement with the provided username
        if (!$stmt->execute(array($username))) {
            // Redirect to index with an error message if the statement execution fails
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        // Fetch user data as an associative array
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user data was retrieved
        if (!$userData) {
            // Redirect to index with an error message if no user found
            header("location: ../index.php?error=noUserFound");
            exit();
        }

        // Retrieve hashed password from user data
        $hashedPwd = $userData['password'];

        // Verify the provided password with the hashed password
        $pwdCheck = password_verify($pwd, $hashedPwd);

        // If password verification fails
        if (!$pwdCheck) {
            // Redirect to index with an error message for wrong password
            header("location: ../index.php?error=wrongPassword");
            exit();
        }

        // If password verification succeeds, set session variables for the logged-in user
        $_SESSION["usernameid"] = $userData["id"];
        $_SESSION["username"] = $userData["username"];
        $_SESSION["roleid"] = $userData["role_id"];
    }
}
?>
