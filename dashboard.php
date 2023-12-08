<?php
// Démarrage de la session 
include './classes/dbh.class.php';

$dbh = new Dbh(); // Création d'un nouvel objet pour la connexion à la base de données
$conn = $dbh->connect(); // Connexion à la base de données

$userId = $_SESSION['usernameid']; // Récupération de l'ID de l'utilisateur connecté

// Préparation et exécution de la requête SQL pour récupérer les tâches visibles par l'utilisateur
$stmt = $conn->prepare("SELECT t.*, s.label as status_label FROM tasks t JOIN status s ON t.status_id = s.id WHERE assign_user_id = ?");
$stmt->execute([$userId]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC); // Stockage des tâches dans une variable

// Organisation des tâches par statut pour faciliter leur affichage
$tasksByStatus = ['à faire' => [], 'en cours' => [], 'terminé' => []];
foreach ($tasks as $task) {
    $tasksByStatus[strtolower($task['status_label'])][] = $task;
}

// Récupération de la liste des autres utilisateurs (pour l'assignation des tâches)
$userListStmt = $conn->prepare("SELECT id, username FROM users WHERE id != ?");
$userListStmt->execute([$userId]);
$userList = $userListStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
</head>

<body>
    <script src="./js/script.js"></script>
    <main id="main-content">
        <link rel="stylesheet" href="./styles/dashboard.css">

        <div id='content'>
            <h1>Votre Dashboard</h1>
            <div class="dashboard-container">

                <div class="task-columns">
                    <!-- Différentes colonnes pour les statuts des tâches : "À Faire", "En Cours", "Terminé" -->
                    <!-- Colonne "À Faire" -->
                    <div class="column" id="todo">
                        <h3>À Faire</h3>
                        <!-- Boucle pour afficher chaque tâche dans la colonne "À Faire" -->
                        <?php foreach ($tasksByStatus['à faire'] as $task): ?>
                            <div class='task' id="task-<?= $task['id'] ?>">
                                <span class="task-title">
                                    <?= htmlspecialchars($task['title']) ?>
                                </span>
                                <p class="task-body" style="display:none;">
                                    <?= htmlspecialchars($task['body']) ?>
                                </p>
                                <button onclick="openDetailsPopup(<?= $task['id'] ?>)">Détails</button>
                            </div>
                        <?php endforeach; ?>
                        <!-- Bouton pour ajouter une nouvelle tâche -->
                        <button onclick="openPopup(1)">Ajouter Tâche</button> <!-- Pour "À Faire" -->
                        <form id="form-todo" action="./gestionTask/creer.php" method="post" style="display:none;">
                            <input type="text" name="title" placeholder="Titre" required>
                            <textarea name="body" placeholder="Description"></textarea>
                            <input type="hidden" name="status_id" value="1">
                        </form>
                    </div>
                </div>

                <!-- Colonne "En Cours" -->
                <div class="column" id="in-progress">
                    <h3>En Cours</h3>
                    <!-- Boucle pour afficher chaque tâche dans la colonne "En Cours" -->
                    <?php foreach ($tasksByStatus['en cours'] as $task): ?>
                        <div class='task' id="task-<?= $task['id'] ?>">
                            <span class="task-title">
                                <?= htmlspecialchars($task['title']) ?>
                            </span>
                            <p class="task-body" style="display:none;">
                                <?= htmlspecialchars($task['body']) ?>
                            </p>
                            <button onclick="openDetailsPopup(<?= $task['id'] ?>)">Détails</button>
                        </div>
                    <?php endforeach; ?>
                    <!-- Bouton pour ajouter une nouvelle tâche -->
                    <button onclick="openPopup(2)">Ajouter Tâche</button> <!-- Pour "En Cours" -->
                    <form id="form-in-progress" action="./gestionTask/creer.php" method="post" style="display:none;">
                        <input type="text" name="title" placeholder="Titre" required>
                        <textarea name="body" placeholder="Description"></textarea>
                        <input type="hidden" name="status_id" value="2">
                    </form>
                </div>

                <!-- Colonne "Terminé" -->
                <div class="column" id="done">
                    <h3>Terminé</h3>
                    <!-- Boucle pour afficher chaque tâche dans la colonne "Terminé" -->
                    <?php foreach ($tasksByStatus['terminé'] as $task): ?>
                        <div class='task' id="task-<?= $task['id'] ?>">
                            <span class="task-title">
                                <?= htmlspecialchars($task['title']) ?>
                            </span>
                            <p class="task-body" style="display:none;">
                                <?= htmlspecialchars($task['body']) ?>
                            </p>
                            <button onclick="openDetailsPopup(<?= $task['id'] ?>)">Détails</button>
                        </div>
                    <?php endforeach; ?>
                    <!-- Bouton pour ajouter une nouvelle tâche -->
                    <button onclick="openPopup(3)">Ajouter Tâche</button> <!-- Pour "Terminé" -->
                    <form id="form-done" action="./gestionTask/creer.php" method="post" style="display:none;">
                        <input type="text" name="title" placeholder="Titre" required>
                        <textarea name="body" placeholder="Description"></textarea>
                        <input type="hidden" name="status_id" value="3">
                    </form>
                </div>
            </div>
        </div>
        </div>
    </main>
    <!-- Divers popups pour la gestion des tâches (ajout, modification, détails) -->
    <!-- Popup pour Ajouter une Tâche -->
    <div id="task-popup" class="task-popup">
        <div class="task-popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <form action="./gestionTask/creer.php" method="post">
                <h2>Ajouter une Nouvelle Tâche</h2>
                <input type="text" name="title" placeholder="Titre" required>
                <textarea name="body" placeholder="Description"></textarea>
                <input type="hidden" name="status_id" id="popup-status-id">
                <button type="submit" name="submit">Créer</button>
            </form>
        </div>
    </div>

    <!-- Popup pour modifier -->
    <div id="edit-task-popup" class="task-popup" style="display:none;">
        <div class="task-popup-content">
            <span class="close-btn" onclick="closeEditPopup()">&times;</span>
            <h2>Modifier la Tâche</h2>
            <form id="edit-task-form" action="./gestionTask/modifier.php" method="post">
                <input type="hidden" name="task_id" id="edit-task-id">
                <div class="form-group">
                    <label for="edit-task-title">Titre de la Tâche</label>
                    <input type="text" name="title" id="edit-task-title" placeholder="Titre" required>
                </div>
                <div class="form-group">
                    <label for="edit-task-body">Description</label>
                    <textarea name="body" id="edit-task-body" placeholder="Description"></textarea>
                </div>
                <button type="submit" name="submit">Enregistrer les modifications</button>
            </form>
        </div>
    </div>

    <!-- Popup pour détails -->
    <div id="details-popup" class="task-popup" style="display:none;">
        <div class="task-popup-content">
            <span class="close-btn" onclick="closeDetailsPopup()">&times;</span>
            <h2 id="popup-title"></h2>
            <p id="popup-body"></p>
            <button onclick="prepareEditTask(window.currentTaskId)">Modifier</button>
            <button onclick="deleteTask()">Supprimer</button>
            <button onclick="moveTask(window.currentTaskId, 'left')">←</button>
            <button onclick="moveTask(window.currentTaskId, 'right')">→</button>
            <div class="assign-task">
                <label for="assign-user">Assigner à :</label>
                <select id="assign-user">
                    <?php foreach ($userList as $user): ?>
                        <option value="<?= $user['id'] ?>">
                            <?= htmlspecialchars($user['username']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button onclick="assignTaskToUser(window.currentTaskId)">Assigner</button>
            </div>
        </div>
    </div>
</body>

</html>