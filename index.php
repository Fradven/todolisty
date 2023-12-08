<?php 
$title = "Todolisty | Empower Your Day"; 
$bodyClass = "home-page";
?>
<?php include './includes/header.php'; ?>
    <!-- Créer condition (login success) pour afficher soit login (ci-dessous) sans sidebar soit tout sauf login (garder le header dans les deux cas) -->

    <!-- <div class="login-signup-container">
        <div class="top-content">
            <h1 class="page-title">Todolisty.</h1>
            <h3 class="page-subtitle">Empower your day</h3>
        </div>
        <div id="login-signup-card">
            <div class="tabs">
                <button id="tab1" onclick="toggleTab('tab1','login-form')" class="tab tab-active">Login</button>
                <button id="tab2" onclick="toggleTab('tab2','signup-form')" class="tab">Signup</button>
            </div>
            <div class="login-signup-forms">
                <form id="login-form" class="tab-content tab-active" action="./includes/login.inc.php" method="post">
                    <div class="form-container">
                        <label for="l-uid">username</label>
                        <input type="text" name="l-uid" required>
                        <label for="l-pwd">password</label>
                        <input type="password" name="l-pwd" required>
                        <div class="form-actions">
                            <button class="btn btn-outline" type="reset">Reset</button>
                            <button class="btn" type="submit">Login</button>
                        </div>
                    </div>
                </form>
                <form id="signup-form" class="tab-content" action="./includes/signup.inc.php" method="post">
                    <div class="form-container">
                        <label for="r-email">email</label>
                        <input type="email" name="r-email"required>
                        <label for="r-uid">username</label>
                        <input type="text" name="r-uid" required>
                        <label for="r-pwd">password</label>
                        <input type="password" name="r-pwd" required>
                        <label for="r-pwdrepeat">repeat password</label>
                        <input type="password" name="r-pwdrepeat" required>
                        <div class="form-actions">
                            <button class="btn btn-outline" type="reset">Reset</button>
                            <button class="btn" type="submit">Sign up</button>
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
    </div> -->
    <main id="main-content">
        <?php include './includes/sidebar.php'; ?>
        <div id="content">
            <!-- placer todolist ici en dur  -->
        </div>    
    </main>
</body>
</html>