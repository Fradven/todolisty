<?php
// On démarre la session 
session_start();
include '../classes/dbh.class.php'; 

// On vérifie si les informations nécessaires sont envoyées par le formulaire
if (isset($_POST['task_id']) && isset($_POST['direction'])) {
    $taskId = $_POST['task_id']; // L'identifiant de la tâche à déplacer
    $direction = $_POST['direction']; // La direction du déplacement : gauche ou droite

    $dbh = new Dbh(); 
    $conn = $dbh->connect(); 

    // On appelle la fonction pour calculer le nouveau statut de la tâche
    $newStatusId = calculateNewStatusId($taskId, $direction, $conn);

    // Préparation de la requête SQL pour mettre à jour le statut de la tâche
    $stmt = $conn->prepare("UPDATE tasks SET status_id = ? WHERE id = ?");
    $stmt->execute([$newStatusId, $taskId]); // Exécution de la requête avec les nouveaux paramètres

    echo "Tâche déplacée avec succès."; // Affichage d'un message de succès
} else {
    echo "Erreur lors du déplacement de la tâche."; // Message d'erreur si les données ne sont pas reçues
}

//fonction pour calculer le nouveau statut de la tâche
function calculateNewStatusId($taskId, $direction, $conn) {
    // On récupère d'abord le statut actuel de la tâche.
    $stmt = $conn->prepare("SELECT status_id FROM tasks WHERE id = ?");
    $stmt->execute([$taskId]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentStatusId = $task['status_id']; // L'ID du statut actuel de la tâche

    // Définition des ID des différents statuts
    $statusToDo = 1; // ID pour "À Faire"
    $statusInProgress = 2; // ID pour "En Cours"
    $statusDone = 3; // ID pour "Terminé"

    // Calcul du nouveau statut en fonction de la direction indiquée
    if ($direction == 'right' && $currentStatusId < $statusDone) {
        $newStatusId = $currentStatusId + 1; // Déplacer vers la droite
    } elseif ($direction == 'left' && $currentStatusId > $statusToDo) {
        $newStatusId = $currentStatusId - 1; // Déplacer vers la gauche
    } else {
        $newStatusId = $currentStatusId; // Garder le même statut si le déplacement n'est pas possible
    }

    return $newStatusId; // On renvoie le nouvel ID de statut calculé
}

?>
