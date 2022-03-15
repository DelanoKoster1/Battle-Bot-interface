<footer class="footer pt-4">
    <div class="container text-uppercase">
        <div class="row text-center">
            <div class="col-md-6 col-12">
                <h6>Dit evenement is gesponsord door:</h6>
                <div class="rounded-circle">
                    <img class="footerIMG" src="<?=($_SESSION['sort'] == 'page') ? '../assets/img/logo-nhl-stenden.png' : 'assets/img/logo-nhl-stenden.png'?>" alt="StendenLogo">
                </div>
            </div>
            <div class="col-md-3 col-12">
                <h4>Battlebot</h4>
                <ul class="list-unstyled">
                    <li><a class="text-white text-decoration-none" href="<?= ($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php'?>">Voorpagina</a></li>
                    <li><a class="text-white text-decoration-none" href="<?= ($_SESSION['sort'] == 'page') ? 'robots.php' : 'pages/robots.php'?>">Robots</a></li>
                    <li><a class="text-white text-decoration-none" href="<?= ($_SESSION['sort'] == 'page') ? 'calendarpage.php' : 'pages/calendarpage.php'?>">Kalender</a></li>
                    <li><a class="text-white text-decoration-none" href="<?= ($_SESSION['sort'] == 'page') ? 'livestream.php' : 'pages/livestream.php'?>">Livestream</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-12">
                <h4>Account</h4>
                <ul class="list-unstyled">
                    <li><a class="text-white text-decoration-none" href="<?= ($_SESSION['sort'] == 'page') ? 'profile.php' : 'pages/profile.php'?>">Profiel</a></li>
                    <li><a class="text-white text-decoration-none" href="<?= ($_SESSION['sort'] == 'page') ? 'login.php' : 'pages/login.php'?>">Login/Registeren</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<script src="https://use.fontawesome.com/ef0ace9f36.js"></script>