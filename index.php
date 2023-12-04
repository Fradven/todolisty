<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todolisty</title>
</head>

<body>
    <section>
        <div>
            <h2>Login</h2>
            <form action="./includes/login.inc.php" method="post">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <button type="submit">LOGIN</button>
            </form>
        </div>
        <div>
            <h2>Sign up</h2>
            <form action="./includes/signup.inc.php" method="post">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="pwdrepeat" placeholder="Repeat Password">
                <button type="submit">SIGN UP</button>
            </form>
        </div>
    </section>
</body>

</html>