<?php
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    include "../classes/dbh.class.php";

    $dbh = new Dbh();
    $conn = $dbh->connect();

    // Vérification de l'utilisateur
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($pwd, $user['password'])) {
            // Démarrage de la session et enregistrement des données utilisateur
            session_start();
            $_SESSION['userId'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            // Redirection vers dashboard.php
            header("location: ../components/dashboard.php");
            exit();
        } else {
            // Gestion d'erreur
            header("location: ../index.php?error=wrongpassword");
            exit();
        }
    } else {
        header("location: ../index.php?error=nouser");
        exit();
    }
}
