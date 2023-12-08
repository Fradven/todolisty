<?php
include './includes/header.php';
include './classes/dbh.class.php';

$dbh = new Dbh();
$pdo = $dbh->connect();

// Définir un ordre de tri et une direction par défaut
$orderBy = 'title';
$orderDirection = 'ASC';

// Vérifiez si un critère de tri a été spécifié et est valide
if (isset($_GET['sort']) && in_array($_GET['sort'], ['title', 'status', 'created_at'])) {
    $orderBy = $_GET['sort'];
}

// Vérifiez si une direction de tri a été spécifiée et est valide
if (isset($_GET['direction']) && in_array($_GET['direction'], ['ASC', 'DESC'])) {
    $orderDirection = $_GET['direction'];
}

$sql = "SELECT t.title, s.label AS status, p.label AS priority, t.created_at, u.username
        FROM tasks t
        LEFT JOIN status s ON t.status_id = s.id
        LEFT JOIN priority p ON t.priority_id = p.id
        LEFT JOIN users u ON t.assign_user_id = u.id
        ORDER BY $orderBy $orderDirection";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<link rel="stylesheet" href="./styles/tableau.css">
<main id="main-content">
    <?php include './includes/sidebar.php'; ?>
    <div id="content">
    <section>
        <div class="filter-form">
            <form action="" method="get">
                <div class="filter-group">
                    <label for="sort">Trier par :</label>
                    <select name="sort" id="sort">
                        <option value="title">Titre</option>
                        <option value="status">Statut</option>
                        <option value="priority_id">Priorité</option>
                        <option value="created_at">Date de création</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="direction">Ordre :</label>
                    <select name="direction" id="direction">
                        <option value="ASC">Croissant</option>
                        <option value="DESC">Décroissant</option>
                    </select>
                </div>
                <div class="filter-group">
                    <button type="submit" class="filter-button">Confirmer</button>
                </div>
            </form>
        </div>




            <!-- Fin de la section de filtrage -->
            <table class="tableau-tasks">
                <thead>
                    <tr>
                        <th>Tâche</th>
                        <th>Status</th>
                        <th>Priorité</th>
                        <th>Date de création</th>
                        <th>Assignée à</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td><?= htmlspecialchars($task['status']) ?></td>
            <td><?= htmlspecialchars($task['priority']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($task['created_at'])) ?></td>
            <td>
                <?php
                // Déterminez le texte à afficher dans le cercle.
                $circleText = 'N/A'; // Texte par défaut si aucun utilisateur n'est assigné
                if (!empty($task['username'])) {
                    // Si un utilisateur est assigné, utilisez la première lettre en majuscule et la deuxième en minuscule.
                    $circleText = strtoupper(substr($task['username'], 0, 1)) . strtolower(substr($task['username'], 1, 1));
                } else {
                    // Si aucun utilisateur n'est assigné, utilisez les deux premières lettres du titre de la tâche (première en majuscule, deuxième en minuscule).
                    $circleText = strtoupper(substr($task['title'], 0, 1)) . strtolower(substr($task['title'], 1, 1));
                }
                ?>
                <div class="user-circle">
                    <?= htmlspecialchars($circleText) ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
</main>
</body>

</html>