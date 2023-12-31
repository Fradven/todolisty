<?php
// Get the current page URL
$current_page = basename($_SERVER['REQUEST_URI']);

// Define the URLs and labels for the two links
$link1_url = 'index.php';
$link2_url = 'members.php';
$link3_url = 'tableur.php';

// Determine the active class for each link
$class1 = ($link1_url == $current_page) ? 'active' : '';
$class2 = ($link2_url == $current_page) ? 'active' : '';
$class3 = ($link3_url == $current_page) ? 'active' : '';
?>


<div id="sidebar" class="">
    <div class="workspace">
        <a class="workspace-logo link" href="#">T</a>
        <div class="workspace-title">
            <a class="link" href="#">Todolisty</a>
            <p>Premium</p>
        </div>
        <div class="workspace-icon">
            <img class="carret-left" src="./assets/images/carret-left.svg" alt="">
        </div>
    </div>
    <ul class="sidebar-nav">
        <li>
            <div class="sidebar-link sidebar-subsection">
                <p>Vos tableaux</p>
                <img class="icon-plus" src="./assets/images/plus.png" alt="">
            </div>
            <div class="sidebar-link">
                <a class="link <?= $class1 ?>" href="<?= $link1_url ?>">
                    <img class="sidebar-nav-icon" src="./assets/images/bg-min.jpg" alt="">
                    <span>Tâches</span>
                </a>
            </div>
            <div class="sidebar-closed-link">
                <a class="link sidebar-closed-btn <?= $class1 ?>" href="<?= $link1_url ?>">
                    <img class="sidebar-closed-icon" src="./assets/images/bg-min.jpg" alt="">
                </a>
            </div>
        </li>
        <li class="sidebar-link">
            <a class="link <?= $class2 ?>" href="<?= $link2_url ?>">
                <img class="sidebar-nav-icon" src="./assets/images/user.png" alt="">
                <span class="link">Membres</span>
                <img class="icon-plus" src="./assets/images/plus.png" alt="">
            </a>
        </li>
        <li class="sidebar-closed-link">
            <a class="link sidebar-closed-btn <?= $class2 ?>" href="<?= $link2_url ?>">
                <img class="sidebar-closed-icon" src="./assets/images/user.png" alt="">
            </a>
        </li>
        <li class="sidebar-link">
            <a class="link" href="#">
                <img class="sidebar-nav-icon" src="./assets/images/settings.png" alt="">
                <span>Paramètres d'espace de travail</span>
                <img class="icon-carret-down" src="./assets/images/carret-down.png" alt="">
            </a>
        </li>
        <li class="sidebar-closed-link">
            <a class="link sidebar-closed-btn" href="#">
                <img class="sidebar-closed-icon" src="./assets/images/settings.png" alt="">
            </a>
        </li>
        <li>
            <div class="sidebar-link sidebar-subsection">
                <p>Vues de l'espace de travail</p>
                <img class="icon-plus" src="./assets/images/plus.png" alt="">
            </div>
            <div class="sidebar-link">
                <a class="link <?= $class3 ?>" href="<?= $link3_url ?>">
                    <img class="sidebar-nav-icon" src="./assets/images/tableur.png" alt="">
                    <span>Tableur</span>
                </a>
            </div>
            <div class="sidebar-closed-link">
                <a class="link sidebar-closed-btn <?= $class3 ?>" href="<?= $link3_url ?>">
                    <img class="sidebar-closed-icon" src="./assets/images/tableur.png" alt="">
                </a>
            </div>
            <div class="sidebar-link">
                <a class="link" href="#">
                    <img class="sidebar-nav-icon" src="./assets/images/calendar.png" alt="">
                    <span>Calendrier</span>
                </a>
            </div>
            <div class="sidebar-closed-link">
                <a class="link sidebar-closed-btn" href="#">
                    <img class="sidebar-closed-icon" src="./assets/images/calendar.png" alt="">
                </a>
            </div>
        </li>
    </ul>
    <div class="trial-infos">
        <img class="sidebar-nav-icon" src="./assets/images/entreprise.png" alt="">
        <p>7 jours restants pour votre essai gratuit de Premium.
            <a class="link" href="">Accéder à la page de facturation</a>
        </p> 
        
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const workspaceIcon = document.querySelector('.workspace-icon');
        const content = document.getElementById('content');

        workspaceIcon.addEventListener('click', function () {
            sidebar.classList.toggle('sidebar-closed');
            // let elements = document.querySelectorAll('#sidebar .sidebar-nav, #sidebar .trial-infos, #sidebar .workspace-logo, #sidebar .workspace-title');
            // elements.forEach(function(element, index) {
            //      let delay = index * 0.1 + 's';
            //      setTimeout(function() {
            //          element.style.opacity = element.style.opacity === '0' ? '1' : '0';
            //      }, parseFloat(delay) * 1000);
            // });
        });
        
        function updateSidebarClass() {
            const screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            const isMobile = screenWidth < 740;
            
            sidebar.classList.toggle('sidebar-closed', isMobile);
            
            if (isMobile) {
                content.addEventListener('click', function () {
                    sidebar.classList.add('sidebar-closed');
                });  
            }  
        }
        
        updateSidebarClass();
        window.addEventListener('resize', updateSidebarClass);

    });
</script>