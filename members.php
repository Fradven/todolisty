<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "todolisty";

$title = "Members - Todolisty";
$bodyClass = "members-page";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the list of members from the 'users' table
$sql = "SELECT u.id, u.username, u.created_at, r.label as role_label 
        FROM users u
        INNER JOIN role r ON u.role_id = r.id";
$result = $conn->query($sql);
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
                    <h2>Members</h2>
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
                    <div class="members-toolbar">
                        <form action="">
                            <input class="members-input" type="search" placeholder="Filtrer par nom">
                            <button class="btn" type="submit">Filtrer</button>
                        </form>
                        <form action="./includes/process_add_member.php" method="post">
                            <label class="form-label" for="new_username">Nom d'utilisateur</label>
                            <input class="members-input" type="text" id="new_username" name="new_username" required>

                            <label class="form-label" for="new_role">Assigner le rôle</label>
                            <select class="members-input" id="new_role" name="new_role" required>
                                <!-- Fetch and display roles from the database -->
                                <?php
                                // Assuming $conn is your database connection
                                $sqlRoles = "SELECT id, label FROM role";
                                $resultRoles = $conn->query($sqlRoles);

                                while ($rowRole = $resultRoles->fetch_assoc()) {
                                    echo "<option value='{$rowRole['id']}'>{$rowRole['label']}</option>";
                                }
                                ?>
                            </select>

                            <button class="btn" type="submit" name="add_user">Ajouter Membre</button>
                        </form>
                    </div>
                    <ul class="members-list">
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <li class="member">
                            <div class="member-card">
                                <img class="member-icon" src="./assets/images/account.png" alt="">
                                <div class="details">
                                    <p class="username"><?= $row["username"] ?></p>
                                    <p class="role">role : <?= $row["role_label"] ?></p>
                                </div>
                            </div>
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
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
