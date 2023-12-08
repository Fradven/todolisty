<?php
include '../classes/dbh.class.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbh = new Dbh();
    $memberId = $_POST['member_id'];

    if (isset($_POST['change_role'])) {
        $stmt = $dbh->connect()->prepare("UPDATE users SET role_id = (CASE WHEN role_id = 1 THEN 2 ELSE 1 END) WHERE id = ?");

        if (!$stmt->execute(array($memberId))) {
            $stmt = null;
            header("location: ../members.php?error=failedToChangeRole");
            exit();
        } else {
            $stmt = null;
            header("location: ../members.php?success=roleChanged");
        }
    } elseif (isset($_POST['delete_member'])) {
        $currentTime = date('Y-m-d H:i:s');
        $stmt = $dbh->connect()->prepare("UPDATE users SET deleted_at = ? WHERE id = ?");

        if (!$stmt->execute(array($currentTime, $memberId))) {
            $stmt = null;
            header("location: ../members.php?error=failedToDelete");
            exit();
        } else {
            $stmt = null;
            header("location: ../members.php?success=userDeleted");
        }
    }
}
?>