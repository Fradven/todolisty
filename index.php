<?php
session_start();
$title = "Todolisty | Empower Your Day";
$bodyClass = "home-page";
$userRole = $_SESSION["roleid"];
$username = $_SESSION['username'];
?>
<?php include './includes/header.php'; ?>
<!-- Créer condition (login success) pour afficher soit login (ci-dessous) sans sidebar soit tout sauf login (garder le header dans les deux cas) -->

<?php
if (!isset($_SESSION["usernameid"])) {
    ?>
    <div class="login-signup-container">
        <div class="top-content">
            <h1 class="page-title">Todolisty.</h1>
            <h3 class="page-subtitle">Empower your day</h3>
        </div>
        <?php
        // Check if a logout message is set
        if (isset($_SESSION['logout_message'])) {
            echo '<div class="logout-message">' . $_SESSION['logout_message'] . '</div>';
            // Unset the logout message to avoid displaying it again on page reload
            unset($_SESSION['logout_message']);
        }
        ?>
        <div id="login-signup-card">
            <div class="tabs">
                <button id="tab1" onclick="toggleTab('tab1','login-form')" class="tab tab-active">Login</button>
                <button id="tab2" onclick="toggleTab('tab2','signup-form')" class="tab">Signup</button>
            </div>
            <div class="login-signup-forms">
                <form id="login-form" class="tab-content tab-active" action="./includes/login.inc.php" method="post">
                    <div class="form-container">
                        <label for="l-uid">username</label>
                        <input type="text" name="username" required>
                        <label for="l-pwd">password</label>
                        <input type="password" name="pwd" required>
                        <div class="form-actions">
                            <button class="btn btn-outline" type="reset">Reset</button>
                            <button class="btn" type="submit" name="submit">Login</button>
                        </div>
                    </div>
                </form>
                <form id="signup-form" class="tab-content" action="./includes/signup.inc.php" method="post">
                    <div class="form-container">
                        <label for="r-uid">username</label>
                        <input type="text" name="username" required>
                        <label for="r-pwd">password</label>
                        <input type="password" name="pwd" required>
                        <label for="r-pwdrepeat">repeat password</label>
                        <input type="password" name="pwdrepeat" required>
                        <div class="form-actions">
                            <button class="btn btn-outline" type="reset">Reset</button>
                            <button class="btn" type="submit" name="submit">Sign up</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="form-links">
                <a class="link" href="#">Help</a>
                <a class="link" href="#">Privacy</a>
                <a class="link" href="#">Terms</a>
            </div>
            <script>
                function toggleTab(tabId, tabContentId) {
                    const tabs = document.querySelectorAll('.tab');
                    const tabContent = document.querySelectorAll('.tab-content');

                    tabContent.forEach(content => {
                        content.classList.remove('tab-active');
                    });

                    tabs.forEach(tab => {
                        tab.classList.remove('tab-active');
                    });

                    const selectedTabContent = document.getElementById(tabContentId);
                    const selectedTab = document.getElementById(tabId);
                    selectedTabContent.classList.add('tab-active');
                    selectedTab.classList.add('tab-active');
                }
            </script>
        </div>
    </div>
    <?php
} else {
?>
<main id="main-content">
    <?php include './includes/sidebar.php'; ?>
    <div id="content">
        <!-- placer todolist ici en dur  -->
        <?php include './todo.php'; ?>
    </div>
</main>
<div id="session-username" style="display: none;"><?= $username ?></div>
<div id="session-role" style="display: none;"><?= $userRole ?></div>
<script type="text/javascript" src="./js/user-icon.js"></script>
<?php } ?>
</body>

</html>