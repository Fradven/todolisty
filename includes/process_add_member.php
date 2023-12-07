<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "todolisty";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    // Assuming $conn is your database connection
    $newUsername = $_POST['new_username'];
    $newRoleId = $_POST['new_role'];

    // Insert the new user into the 'users' table
    $sqlInsertUser = "INSERT INTO users (username, role_id) VALUES ('$newUsername', $newRoleId)";
    $resultInsertUser = $conn->query($sqlInsertUser);

    if ($resultInsertUser) {
        echo "User added successfully!";
    } else {
        echo "Error adding user: " . $conn->error;
    }
}
?>
