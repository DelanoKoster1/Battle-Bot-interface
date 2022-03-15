<footer class="footer pt-4">
    <div class="container text-uppercase">
        <div class="row text-center">
            <div class="col-md-6 col-12">
                <h6>Dit evenement is gesponsord door:</h6>
                <img class="footerIMG" src="../assets/img/logo-nhl-stenden.png" alt="StendenLogo">
            </div>
            <div class="col-md-3 col-12">
                <h3>Battlebot</h3>
                <ul class="list-unstyled">
                    <li><a class="text-white text-decoration-none" href="<?= ($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php'?>">Voorpagina</a></li>
                    <li><a class="text-white text-decoration-none" href="<?= ($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php'?>">Robots</a></li>
                    <li><a class="text-white text-decoration-none" href="<?= ($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php'?>">Kalender</a></li>
                    <li><a class="text-white text-decoration-none" href="<?= ($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php'?>">Livestream</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-12">
                <h3>Acount</h3>
                <ul class="list-unstyled">
                    <li>Profiel</li>
                    <li>Login/Registeren</li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<script src="https://use.fontawesome.com/ef0ace9f36.js"></script>