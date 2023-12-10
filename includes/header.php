<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon//apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="./assets/favicon/site.webmanifest">
</head>

<body class="<?= $bodyClass; ?>">
<?php if (isset($_SESSION["usernameid"])) {
 ?>   
    <header id="header">
        <a class="logo-link" href="./index.php">
            <img class="logo-img" src="./assets/images/logo-trello-anim.gif" alt="logo" />
        </a>
        <nav class="navbar">
            <ul>
                <li>
                    <a class="nav-link" href="">Espaces de travail</a>
                </li>
                <li>
                    <a class="nav-link" href="">Récent</a>
                </li>
                <li>
                    <a class="nav-link" href="">Favoris</a>
                </li>
                <li>
                    <a class="nav-link" href="">Modèles</a>
                </li>
                <li>
                    <a class="nav-link btn" href="">Créer</a>
                </li>
            </ul>
        </nav>
        <div class="menu-tools">
            <div class="menu-searchbar">
                <img class="search-icon" src="./assets/images/search.png" alt="search">
                <input class="menu-searchbar-input" type="search" placeholder="Rechercher" maxlength="500">
            </div>
            <ul class="menu-tools-icons">
                <li>
                    <button class="btn notif-btn">
                        <img class="notif-icon" src="./assets/images/notification.png" alt="">
                    </button>
                </li>
                <li>
                    <button class="infos-btn">
                        <img class="infos-icon" src="./assets/images/infos.png" alt="">
                    </button>
                </li>
                <li>
                    <button class="account-btn">
                        <div id="header-member-icon" class="member-icon"></div>
                    </button>
                </li>
                <li>
                    <form action="./includes/logout.inc.php" method="post">
                        <button type="submit" class="btn logout-btn">
                            <img class="logout-icon" src="./assets/images/logout.png" alt="">
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </header>
<?php } ?>