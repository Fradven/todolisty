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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memberId = $_POST['member_id'];

    if (isset($_POST['change_role'])) {
        // Handle changing the role logic
        echo "Changing role for member with ID $memberId";
    } elseif (isset($_POST['delete_member'])) {
        // Handle deleting the member logic
        echo "Deleting member with ID $memberId";
    }
}
?>
