<?php include './db_connection.inc.php'; ?>

<?php
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
