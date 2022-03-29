<footer class="footer">
    <div class="container text-uppercase">
        <div class="row text-center">
            <div class="col-lg-6 col-12 mb-3">
                <h6>Dit evenement is gesponsord door:</h6>
                <div class="rounded-circle mx-auto mt-4">
                    <img class="footerIMG" src="<?=($_SESSION['sort'] == 'page') ? '../assets/img/nhlstenden-logo.svg' : 'assets/img/nhlstenden-logo.svg'?>" alt="StendenLogo">
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 mb-3">
                <h6>Battlebots</h6>
                <ul class="list-unstyled mt-4">
                    <li><a class="text-decoration-none nav-link" href="<?= ($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php'?>">Voorpagina</a></li>
                    <li><a class="text-decoration-none nav-link" href="<?= ($_SESSION['sort'] == 'page') ? 'robots.php' : 'pages/robots.php'?>">Robots</a></li>
                    <li><a class="text-decoration-none nav-link" href="<?= ($_SESSION['sort'] == 'page') ? 'calendar.php' : 'pages/calendar.php'?>">Kalender</a></li>
                    <li><a class="text-decoration-none nav-link" href="<?= ($_SESSION['sort'] == 'page') ? 'livestream.php' : 'pages/livestream.php'?>">Livestream</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-12 mb-3">
                <h6>Account</h6>
                <ul class="list-unstyled mt-4">
                    <?php if(isset($_SESSION['username'])) { ?>
                        <li><a class="text-decoration-none nav-link" href="<?= ($_SESSION['sort'] == 'page') ? 'profile.php' : 'pages/profile.php'?>">Profiel</a></li>
                    <?php } else { ?>
                        <li><a class="text-decoration-none nav-link" href="<?= ($_SESSION['sort'] == 'page') ? 'login.php' : 'pages/login.php'?>">Inloggen / Registeren</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
<script src="https://use.fontawesome.com/ef0ace9f36.js"></script>