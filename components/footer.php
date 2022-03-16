<footer class="footer">
    <div class="container text-uppercase">
        <div class="row text-center">
            <div class="col-md-6 col-12 column">
                <h6>Dit evenement is gesponsord door:</h6>
                <div class="rounded-circle">
                    <img class="footerIMG" src="<?=($_SESSION['sort'] == 'page') ? '../assets/img/nhlstenden-logo.svg' : 'assets/img/nhlstenden-logo.svg'?>" alt="StendenLogo">
                </div>
            </div>
            <div class="col-md-3 col-12 column">
                <h6>Battlebot</h6>
                <ul class="list-unstyled">
                    <li><a class="text-decoration-none nav-link" href="<?= ($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php'?>">Voorpagina</a></li>
                    <li><a class="text-decoration-none nav-link" href="<?= ($_SESSION['sort'] == 'page') ? 'robots.php' : 'pages/robots.php'?>">Robots</a></li>
                    <li><a class="text-decoration-none nav-link" href="<?= ($_SESSION['sort'] == 'page') ? 'calendarpage.php' : 'pages/calendarpage.php'?>">Kalender</a></li>
                    <li><a class="text-decoration-none nav-link" href="<?= ($_SESSION['sort'] == 'page') ? 'livestream.php' : 'pages/livestream.php'?>">Livestream</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-12 column">
                <h6>Account</h6>
                <ul class="list-unstyled">
                    <?php if(isset($_SESSION['username'])) { ?>
                        <li><a class="text-decoration-none nav-link" href="<?= ($_SESSION['sort'] == 'page') ? 'profile.php' : 'pages/profile.php'?>">Profiel</a></li>
                    <?php } else { ?>
                        <li><a class="text-decoration-none nav-link" href="<?= ($_SESSION['sort'] == 'page') ? 'login.php' : 'pages/login.php'?>">Login/Registeren</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
<script src="https://use.fontawesome.com/ef0ace9f36.js"></script>