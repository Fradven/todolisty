<?php

class Signup extends Dbh
{
    // Method to set a new user in the database
    protected function setUser($username, $pwd)
    {
        // Prepare SQL statement to insert user data into the 'users' table
        $stmt = $this->connect()->prepare('INSERT INTO users (username, password, role_id) VALUES (?, ?, ?);');

        // Hash the provided password using PHP's password_hash function
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        // Execute the prepared statement to insert user data
        if (!$stmt->execute(array($username, $hashedPwd, 2))) {
            // If execution fails, redirect to index with a statement failed error message
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        // Close the statement
        $stmt = null;
    }

    // Method to check if a username already exists in the database
    protected function checkUser($username)
    {
        // Prepare SQL statement to select user ID based on the username
        $stmt = $this->connect()->prepare('SELECT id FROM users WHERE username = ?');

        // Execute the prepared statement to check if the username exists
        if (!$stmt->execute(array($username))) {
            // If execution fails, redirect to index with a statement failed error message
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        // Check the number of rows returned
        if ($stmt->rowCount() > 0) {
            // If the username exists, return false
            return false;
        } else {
            // If the username doesn't exist, return true
            return true;
        }
    }
}
?>
