<?php
// On commence par lancer la 
session_start();
include '../classes/dbh.class.php'; 

// On vérifie si les infos de la tâche et de la personne à qui assigner sont bien envoyées
if (isset($_POST['task_id']) && isset($_POST['assignee_id'])) {
    $taskId = $_POST['task_id']; // L'identifiant de la tâche, pour savoir laquelle on traite
    $assigneeId = $_POST['assignee_id']; // L'identifiant de la personne à qui on assigne la tâche

    $dbh = new Dbh(); 
    $conn = $dbh->connect(); // Et là, on se connecte 

    // Préparation de la requête SQL pour mettre à jour l'assignation de la tâche
    $sql = "UPDATE tasks SET assign_user_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql); // On prépare la requête

    try {
        // On essaie d'exécuter la requête avec les identifiants donnés
        $stmt->execute([$assigneeId, $taskId]);
        echo "Tâche assignée avec succès."; // Si tout se passe bien, on indique que c'est bon
    } catch (PDOException $e) {
        // Si ça se passe mal, on enregistre l'erreur dans un fichier log
        error_log($e->getMessage());
        echo "Erreur lors de l'assignation de la tâche."; // Et on dit qu'il y a eu un souci
    }
}
?>
