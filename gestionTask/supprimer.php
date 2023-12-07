<?php
// On démarre la session 
session_start();
include '../classes/dbh.class.php'; 

// On vérifie si l'identifiant de la tâche à supprimer est bien passé dans l'ulr
if (isset($_GET['task_id'])) {
    $taskId = $_GET['task_id']; // L'identifiant de la tâche qu'on veut supprimer

    $dbh = new Dbh(); // On crée un objet pour se connecter à la base de données
    $conn = $dbh->connect(); // Connexion à la base de données

    // Préparation de la requête SQL pour supprimer la tâche
    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql); 

    // On essaie d'exécuter la requête
    if ($stmt->execute([$taskId])) {
        // Si ça marche, on redirige l'utilisateur vers le dashboard avec un message de succès
        header("Location: ../dashboard.php?success=taskdeleted");
        exit(); 
    } else {
        // Si ça ne marche pas, on redirige vers le dashboard avec un message d'erreur
        header("Location: ../dashboard.php?error=deletionfailed");
        exit(); 
    }
} else {
    // Si on n'a pas l'identifiant de la tâche, on redirige simplement vers le tableau de bord
    header("Location: ../dashboard.php");
    exit(); 
}
?>
