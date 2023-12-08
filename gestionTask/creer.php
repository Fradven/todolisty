<?php
// On commence par démarrer la session
session_start();
include '../classes/dbh.class.php'; 

// Ici, on vérifie si le formulaire a été soumis.
if (isset($_POST['submit'])) {
    $title = $_POST['title']; // On récupère le titre de la tâche du formulaire.
    $body = $_POST['body']; // On prend aussi la description de la tâche.
    $status_id = $_POST['status_id'];// Et on n'oublie pas le statut de la tâche.
    $priority_id = $_POST['priority_id']; 

    // On vérifie si le titre ou le statut sont vides, parce qu'on ne veut pas de tâche sans nom ni statut.
    if (empty($title) || empty($status_id)) {
        // Si c'est le cas, on renvoie l'utilisateur sur le tableau de bord avec un petit message d'erreur.
        header('Location: ../index.php?error=emptyfields');
        exit(); 
    }

    // On se connecte à la base de données.
    $dbh = new Dbh();
    $conn = $dbh->connect();

    // On prépare notre requête pour ajouter la tâche dans la base de données.
    $stmt = $conn->prepare("INSERT INTO tasks (title, body, status_id, priority_id, create_user_id, assign_user_id) VALUES (?, ?, ?, ?, ?, ?)");

    // On exécute la requête avec les infos du formulaire et l'ID de l'utilisateur connecté.
    if (!$stmt->execute([$title, $body, $status_id, (int)$priority_id, $_SESSION['usernameid'], $_SESSION['usernameid']])) {
        // Si ça ne marche pas, on renvoie encore une fois vers le tableau de bord avec un message d'erreur.
        header('Location: ../index.php?error=sqlerror');
        exit(); 
    }

    // Si tout s'est bien passé, on renvoie l'utilisateur vers le tableau de bord avec un message de succès.
    header('Location: ../index.php?success=taskadded');
    exit(); 
} else {
    // Si l'utilisateur arrive ici sans avoir soumis le formulaire, on le renvoie simplement sur le index
    header('Location: ../index.php');
    exit(); 
}
?>
