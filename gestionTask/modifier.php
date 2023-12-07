<?php
// On commence par démarrer la session
session_start();
include '../classes/dbh.class.php'; 

// On vérifie si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // On récupère les données envoyées par le formulaire
    $taskId = $_POST['task_id']; // L'identifiant de la tâche qu'on va modifier
    $title = $_POST['title']; // Le nouveau titre de la tâche
    $body = $_POST['body']; // La nouvelle description de la tâche

    // On se connecte à la base de données
    $dbh = new Dbh();
    $conn = $dbh->connect();

    // On prépare notre requête SQL pour mettre à jour la tâche
    $sql = "UPDATE tasks SET title = ?, body = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // On exécute la requête avec les nouvelles infos
    if ($stmt->execute([$title, $body, $taskId])) {
        // Si la mise à jour réussit, on redirige l'utilisateur vers dashboard avec un message de succès
        header("Location: ../dashboard.php?success=taskupdated");
        exit(); 
    } else {
        // Si quelque chose ne va pas, on redirige vers le dashboard avec un message d'erreur
        header("Location: ../dashboard.php?error=updatefailed");
        exit(); // On termine aussi le script ici.
    }
} else {
    // Si l'utilisateur arrive sur ce script sans passer par le formulaire, on le renvoie vers le dashboard
    header("Location: ../dashboard.php");
    exit(); 
}
?>
