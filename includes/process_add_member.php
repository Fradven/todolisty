<?php include './db_connection.inc.php'; ?>

<?php
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
