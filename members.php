<?php
session_start();
include './classes/dbh.class.php';

function getBackgroundColor($role)
{
    if ($role === 'Admin') {
        return '#FF991F';
    } elseif ($role === 'User') {
        return '#4bce97';
    } else {
        return '#4bce97';
    }
}

$dbh = new Dbh();
$pdo = $dbh->connect();  // Use the PDO instance returned by the connect method

$title = "Members - Todolisty";
$bodyClass = "members-page";
$isUserAdmin = $_SESSION["roleid"] == 1;

// Filter the member list with search or else fetch everything
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT u.id, u.username, u.created_at, r.label as role_label 
            FROM users u
            INNER JOIN role r ON u.role_id = r.id
            WHERE u.username LIKE :search AND deleted_at IS NULL";
} else {
    $sql = "SELECT u.id, u.username, u.created_at, r.label as role_label 
            FROM users u
            INNER JOIN role r ON u.role_id = r.id
            WHERE deleted_at IS NULL";
}

try {
    $stmt = $pdo->prepare($sql);

    if (isset($search)) {
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch roles
    $sqlRoles = "SELECT id, label FROM role";
    $stmtRoles = $pdo->query($sqlRoles);
    $roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

?>

<?php include './includes/header.php'; ?>
<main id="main-content">
    <?php include './includes/sidebar.php'; ?>
    <div id="content">
        <div class="workspace private">
            <a class="workspace-logo private link" href="#">T</a>
            <div class="workspace-title private">
                <a class="link" href="#">Todolisty</a>
                <div class="workspace-private">
                    <img class="workspace-private-icon" src="./assets/images/lock.png" alt="">
                    <p>Privé</p>
                </div>
            </div>
        </div>
        <div class="members-container">
            <div class="left">
                <h2>Membres</h2>
                <p>Membres de tableaux d'espace de travail</p>
                <ul class="members-sidebar">
                    <li class="members-sidelink">
                        <a class="link active" href="#">
                            <span>Membres de l'espace de travail</span>
                        </a>
                    </li>
                    <li class="members-sidelink">
                        <a class="link" href="#">
                            <span>Invités</span>
                        </a>
                    </li>
                    <li class="members-sidelink">
                        <a class="link" href="#">
                            <span>En attente</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="right">
                <div class="members-workspace">
                    <h2>Membres de l'espace de travail</h2>
                    <p>Les membres d'espaces de travail peuvent consulter
                        et rejoindre tous les tableaux visibles par les
                        membres d'un espace de travail et peuvent créer
                        de nouveaux tableaux au sein de l'espace de
                        travail.
                    </p>
                </div>
                <!-- Ci-dessous, la toolbar contenant le filtre et le form de création d'utilisateur uniquement visible par l'admin  -->
                <?php if ($isUserAdmin): ?>
                <div class="members-toolbar" style="margin-bottom: 1rem;">
                    <form action="./includes/signup.inc.php" method="post">
                        <input class="members-input" type="text" id="new_username" name="username" placeholder="Nouveau membre" required>
                        <input class="members-input" type="password" name="pwd" placeholder="Mot de passe" required>
                        <input class="members-input" type="password" name="pwdrepeat" placeholder="Confirmer mdp" required>
                        <label class="form-label" for="new_role">Rôle</label>
                        <select class="members-input" id="new_role" name="new_role" required>
                            <?php
                            // Fetch and display roles using PDO
                            foreach ($roles as $rowRole):?>
                            <option value='<?= $rowRole['id'] ?>'><?= $rowRole['label'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn" type="submit" name="submit">Ajouter Membre</button>
                    </form>
                </div>
                <?php endif; ?>
                <div class="members-toolbar">
                    <form action="" method="GET">
                        <input class="members-input" type="search" name="search" placeholder="Filtrer par nom"
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button class="btn" type="submit">Filtrer</button>
                    </form>

                    <!-- If the user has a roleid of 1, the user can access to admin view -->
                </div>
                <ul class="members-list">
                    <?php foreach ($result as $row): ?>
                    <li class="member">
                        <div class="member-card">
                            <?php
                            $username = $row["username"];
                            $firstLetter = strtoupper(substr($username, 0, 1));
                            $role = $row["role_label"];
                            ?>
                            <div class="member-icon" style="background-color: <?= getBackgroundColor($role) ?>;">
                                <?= $firstLetter ?>
                            </div>
                            <div class="details">
                                <p class="username">
                                    <?= $row["username"] ?>
                                </p>
                                <p class="role">role:
                                    <?= $row["role_label"] ?>
                                </p>
                            </div>
                        </div>

                        <?php if ($isUserAdmin): ?>
                            <div class="member-actions">
                                <!-- Form to change the role -->
                                <form action="./includes/process_member.php" method="post">
                                    <input type="hidden" name="member_id" value="<?= $row['id'] ?>">
                                    <button class="btn" type="submit" name="change_role">Changer Rôle</button>
                                </form>

                                <!-- Form to delete the member -->
                                <form action="./includes/process_member.php" method="post">
                                    <input type="hidden" name="member_id" value="<?= $row['id'] ?>">
                                    <button class="btn" type="submit" name="delete_member">Retirer Membre</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</main>
</body>

</html>