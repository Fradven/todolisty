<?php
// Démarrage de la session 
include './classes/dbh.class.php';

$dbh = new Dbh(); // Création d'un nouvel objet pour la connexion à la base de données
$conn = $dbh->connect(); // Connexion à la base de données

$userId = $_SESSION['usernameid']; // Récupération de l'ID de l'utilisateur connecté

// Préparation et exécution de la requête SQL pour récupérer les tâches visibles par l'utilisateur
$stmt = $conn->prepare("SELECT t.*, s.label as status_label, p.label as priority_label, u.username as username FROM tasks t 
LEFT OUTER JOIN status s ON t.status_id = s.id 
LEFT OUTER JOIN priority p ON t.priority_id = p.id 
LEFT OUTER JOIN users u ON t.assign_user_id = u.id
WHERE assign_user_id = ?");
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

// Compte le nombre total de tâches dans la base de données
$countTasksStmt = $conn->prepare("SELECT COUNT(*) FROM tasks");
$countTasksStmt->execute();
$totalTasks = $countTasksStmt->fetchColumn();

// Déterminez le texte à afficher dans le cercle.
$circleText = 'A'; // Texte par défaut si aucun utilisateur n'est assigné
foreach ($tasks as $task) {
    if (!empty($task['username'])) {
        // Si un utilisateur est assigné, utilisez seulement la première lettre en majuscule.
        $circleText = strtoupper(substr($task['username'], 0, 1));
        break; // Exit the loop once an assigned user is found
    }
}
?>

<script src="./js/script.js"></script>
    <div class="stats-container">
        <h3><?= $totalTasks ?> Tâches</h3>
    </div>
    <div class="todo-container">
        <div class="todo-card" id="todo">
            <div>
                <p>À Faire (<?= count($tasksByStatus['à faire']) ?>)</p>
                <?php foreach ($tasksByStatus['à faire'] as $task): ?>
                    <button class="todo task" onclick="openDetailsPopup(<?= $task['id'] ?>)" id="task-<?= $task['id'] ?>">
                        <span class="task-title todo-title">
                            <?= htmlspecialchars($task['title']) ?>
                        </span>
                        <p class="task-body todo-body" style="display:none;">
                            <?= htmlspecialchars($task['body']) ?>
                        </p>
                        <span class="task-priority">
                            <?= htmlspecialchars($task['priority_label']) ?>
                        </span>
                        <div class="member-icon"><?= htmlspecialchars($circleText) ?></div>
                    </button>
                <?php endforeach; ?>
            </div>
            <div>
                <!-- Bouton pour ajouter une nouvelle tâche -->
                <button class="todo-add-btn" onclick="openPopup(1)">
                    <img class="todo-add-icon" src="./assets/images/plus.png" alt="Add Task">Ajouter une tâche
                </button>
                <form id="form-todo" action="./gestionTask/creer.php" method="post" style="display:none;">
                    <input type="text" name="title" placeholder="Titre" required>
                    <textarea name="body" placeholder="Description"></textarea>
                    <input type="hidden" name="status_id" value="1">
                </form>
            </div>
        </div>

        <!-- Colonne "En Cours" -->
        <div class="todo-card" id="in-progress">
            <div>
                <p>En Cours (<?= count($tasksByStatus['en cours']) ?>)</p>
                <!-- Boucle pour afficher chaque tâche dans la colonne "En Cours" -->
                <?php foreach ($tasksByStatus['en cours'] as $task): ?>
                    <button onclick="openDetailsPopup(<?= $task['id'] ?>)" class='task todo' id="task-<?= $task['id'] ?>">
                        <span class="task-title todo-title">
                            <?= htmlspecialchars($task['title']) ?>
                        </span>
                        <p class="task-body todo-body" style="display:none;">
                            <?= htmlspecialchars($task['body']) ?>
                        </p>
                        <span class="task-priority">
                            <?= htmlspecialchars($task['priority_label']) ?>
                        </span>
                        <div class="member-icon"><?= htmlspecialchars($circleText) ?></div>
                    </button>
                <?php endforeach; ?>
            </div>
            <div>
                <!-- Bouton pour ajouter une nouvelle tâche -->
                <button class="todo-add-btn" onclick="openPopup(2)">
                    <img class="todo-add-icon" src="./assets/images/plus.png" alt="Add Task">
                    Ajouter une tâche
                </button> <!-- Pour "En Cours" -->
                <form id="form-in-progress" action="./gestionTask/creer.php" method="post" style="display:none;">
                    <input type="text" name="title" placeholder="Titre" required>
                    <textarea name="body" placeholder="Description"></textarea>
                    <input type="hidden" name="status_id" value="2">
                </form>
            </div>
        </div>

        <!-- Colonne "Terminé" -->
        <div class="todo-card" id="done">
            <div>
                <p>Terminé (<?= count($tasksByStatus['terminé']) ?>)</p>
                <!-- Boucle pour afficher chaque tâche dans la colonne "Terminé" -->
                <?php foreach ($tasksByStatus['terminé'] as $task): ?>
                    <button onclick="openDetailsPopup(<?= $task['id'] ?>)" class='task todo' id="task-<?= $task['id'] ?>">
                        <span class="task-title todo-title">
                            <?= htmlspecialchars($task['title']) ?>
                        </span>
                        <p class="task-body todo-body" style="display:none;">
                            <?= htmlspecialchars($task['body']) ?>
                        </p>
                        <span class="task-priority">
                            <?= htmlspecialchars($task['priority_label']) ?>
                        </span>
                        <div class="member-icon"><?= htmlspecialchars($circleText) ?></div>
                    </button>
                <?php endforeach; ?>
            </div>
            <div>
                <!-- Bouton pour ajouter une nouvelle tâche -->
                <button class="todo-add-btn" onclick="openPopup(3)">
                <img class="todo-add-icon" src="./assets/images/plus.png" alt="Add Task">
                    Ajouter une tâche
                </button> <!-- Pour "Terminé" -->
                <form id="form-done" action="./gestionTask/creer.php" method="post" style="display:none;">
                    <input type="text" name="title" placeholder="Titre" required>
                    <textarea name="body" placeholder="Description"></textarea>
                    <input type="hidden" name="status_id" value="3">
                </form>
            </div>
        </div>
    </div>
    <!-- Divers popups pour la gestion des tâches (ajout, modification, détails) -->
    <!-- Popup pour Ajouter une Tâche -->
    <div id="task-popup" class="task-popup">
        <div class="task-popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <form action="./gestionTask/creer.php" method="post">
                <h2>Ajouter une Nouvelle Tâche</h2>
                <input class="edit-input" type="text" name="title" placeholder="Titre" required>
                <textarea class="edit-input" name="body" placeholder="Description"></textarea>
                <select class="edit-input task-priority" name="priority_id" required>
                    <option value="0">Choisir une priorité</option>
                    <option value="1">Bas</option>
                    <option value="2">Moyen</option>
                    <option value="3">Élevé</option>
                </select>
                <input type="hidden" name="status_id" id="popup-status-id">
                <button class="todo-icon" type="submit" name="submit">
                    <img class="todo-icon check-icon" src="./assets/images/check.png" alt="">
                </button>
            </form>
        </div>
    </div>

    <!-- Popup pour modifier -->
    <div id="edit-task-popup" class="task-popup" style="display:none;">
        <div class="task-popup-content">
            <span class="close-btn" onclick="closeEditPopup()">&times;</span>
            <h3>Modifier la tâche</h3>
            <form id="edit-task-form" action="./gestionTask/modifier.php" method="post">
                <input type="hidden" name="task_id" id="edit-task-id">
                <div class="form-group">
                    <label for="edit-task-title">Titre</label>
                    <input class="edit-input" type="text" name="title" id="edit-task-title" placeholder="Titre" required>
                </div>
                <div class="form-group">
                    <label for="edit-task-body">Description</label>
                    <textarea class="edit-input" name="body" id="edit-task-body" placeholder="Description"></textarea>
                </div>
                <select class="edit-input task-priority" name="priority_id" required>
                    <option value="0">Choisir une priorité</option>
                    <option value="1">Bas</option>
                    <option value="2">Moyen</option>
                    <option value="3">Élevé</option>
                </select>
                <button class="todo-btn" type="submit" name="submit">
                    <img class="todo-icon check-icon" src="./assets/images/check.png" alt="">
                </button>
            </form>
        </div>
    </div>

    <!-- Popup pour détails -->
    <div id="details-popup" class="task-popup" style="display:none;">
        <div class="task-popup-content">
            <span class="close-btn" onclick="closeDetailsPopup()">&times;</span>
            <h2 id="popup-title"></h2>
            <div id="popup-body"></div>
            <p>Priorité : <span id="priority-value"></span></p>
            <div class="todo-actions">
                <button class="todo-btn" onclick="moveTask(window.currentTaskId, 'left')">
                    <img class="todo-icon carret carret-left" src="./assets/images/carret-right.png" alt="">
                </button>
                <button class="todo-btn" onclick="moveTask(window.currentTaskId, 'right')">
                    <img class="todo-icon carret" src="./assets/images/carret-right.png" alt="">
                </button>
                <button class="todo-btn" onclick="prepareEditTask(window.currentTaskId)">
                    <img class="todo-icon" src="./assets/images/edit.png" alt="Modifier">
                </button>
                <button class="todo-btn" onclick="deleteTask()">
                    <img class="todo-icon" src="./assets/images/delete.png" alt="Supprimer">
                </button>
            </div>
            <div class="assign-task">
                <label for="assign-user">Assigner à :</label>
                <select class="assign-input" id="assign-user">
                    <?php foreach ($userList as $user): ?>
                        <option value="<?= $user['id'] ?>">
                            <?= htmlspecialchars($user['username']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="todo-btn" onclick="assignTaskToUser(window.currentTaskId)">
                    <img class="todo-icon check-icon" src="./assets/images/check.png" alt="Assigner">
                </button>
            </div>
        </div>
    </div>