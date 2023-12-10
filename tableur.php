<?php
session_start();
include './classes/dbh.class.php';

$title = "Tableur - Todolisty";
$bodyClass = "tableur-page";
$userRole = $_SESSION["roleid"];
$username = $_SESSION['username'];

$dbh = new Dbh();
$pdo = $dbh->connect();

// Définir un ordre de tri et une direction par défaut
$orderBy = 'title';
$orderDirection = 'ASC';

// Vérifiez si un critère de tri a été spécifié et est valide
if (isset($_GET['sort']) && in_array($_GET['sort'], ['title', 'status', 'priority_id', 'created_at'])) {
    $orderBy = $_GET['sort'];
}

// Vérifiez si une direction de tri a été spécifiée et est valide
if (isset($_GET['direction']) && in_array($_GET['direction'], ['ASC', 'DESC'])) {
    $orderDirection = $_GET['direction'];
}

$sql = "SELECT t.title, s.label AS status, p.label AS priority, t.created_at, u.username as username
        FROM tasks t
        LEFT JOIN status s ON t.status_id = s.id
        LEFT JOIN priority p ON t.priority_id = p.id
        LEFT JOIN users u ON t.assign_user_id = u.id
        ORDER BY " . ($orderBy === 'priority' ? 'p.label' : $orderBy) . " $orderDirection";


try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<?php include './includes/header.php'; ?>
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
                            <td>
                                <?= htmlspecialchars($task['title']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($task['status']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($task['priority']) ?>
                            </td>
                            <td>
                                <?= date('d/m/Y H:i', strtotime($task['created_at'])) ?>
                            </td>
                            <td class="assigned-to">
                                <?php
                                // Déterminez le texte à afficher dans le cercle.
                                $circleText = 'N/A'; // Texte par défaut si aucun utilisateur n'est assigné
                                if (!empty($task['username'])) {
                                    // Si un utilisateur est assigné, utilisez la première lettre en majuscule et la deuxième en minuscule.
                                    $circleText = strtoupper(substr($task['username'], 0, 1));
                                }

                                // Définir un tableau associatif de correspondance entre caractères et couleurs aléatoires
                                $colorMapping = [];

                                // Générer des couleurs aléatoires pour chaque lettre de A à Z
                                for ($i = 65; $i <= 90; $i++) {
                                    $randomColor = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6); // Générer une couleur hexadécimale aléatoire
                                    $character = chr($i); // Convertir le code ASCII en caractère
                                    $colorMapping[$character] = $randomColor; // Associer la couleur au caractère
                                }

                                // Récupérer la couleur associée au caractère ou utiliser une couleur par défaut
                                
                                if (!function_exists('getUsernameColor')) {
                                    // Define the getUsernameColor function
                                    function getUsernameColor($username) {
                                        // Use a hash function to generate a unique color based on the username
                                        $hash = md5($username);
                                        
                                        // Take the first 6 characters of the hash to get a valid hex color code
                                        $colorCode = '#' . substr($hash, 0, 6);
                                
                                        return $colorCode;
                                    }
                                }
                                $backgroundColor = getUsernameColor($task['username']);
                                ?>
                                <div class="member-icon" style="background-color: <?= $backgroundColor ?>;">
                                    <?= htmlspecialchars($circleText) ?>
                                </div>
                                <p><?= htmlspecialchars($task['username']) ?></p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</main>
<div id="session-username" style="display: none;"><?= $username ?></div>
<div id="session-role" style="display: none;"><?= $userRole ?></div>
<script type="text/javascript" src="./js/user-icon.js"></script>
</body>
</html>