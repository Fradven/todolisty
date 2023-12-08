<?php session_start(); ?>

<?php include './includes/header.php'; ?>
<main id="main-content">
    <?php include './includes/sidebar.php'; ?>
    <div id="content">
        <?php
        if(!isset($_SESSION["usernameid"])) {
            ?>
            <section>
                <div>
                    <h2>Login</h2>
                    <form action="./includes/login.inc.php" method="post">
                        <input type="text" name="username" placeholder="Username">
                        <input type="password" name="pwd" placeholder="Password">
                        <button type="submit" name="submit">LOGIN</button>
                    </form>
                </div>
                <div>
                    <h2>Sign up</h2>
                    <form action="./includes/signup.inc.php" method="post">
                        <input type="text" name="username" placeholder="Username">
                        <input type="password" name="pwd" placeholder="Password">
                        <input type="password" name="pwdrepeat" placeholder="Repeat Password">
                        <button type="submit" name="submit">SIGN UP</button>
                    </form>
                </div>
            </section>
            <?php
        } else {
            ?>
            <form action="./includes/logout.inc.php" method="post">
                <button type="submit" name="submit">LOGOUT</button>
            </form>
        <?php } ?>

    </div>
</main>
</body>

</html>