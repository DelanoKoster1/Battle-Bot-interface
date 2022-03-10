<footer class="footer pt-4">
    <div class="container text-uppercase">
        <div class="row">
            <div class="col-6">
                <h6>Dit evenement is gesponsord door:</h6>
            </div>
            <div class="col-6 text-center">
                <div class="row">
                    <div class="col-6">
                        <h3>Battlebot</h3>
                            <a class="nav-link text-white" href="<?php if ($_SESSION['sort'] == 'page') {echo '../index.php';} else {echo 'index.php';}?>">Voorpagina</a>
                            <a class="nav-link text-white" href="<?php if ($_SESSION['sort'] == 'page') {echo '../pages/robots.php';} else {echo 'pages/robots.php';}?>">Robots</a>
                            <a class="nav-link text-white" href="<?php if ($_SESSION['sort'] == 'page') {echo '../pages/calendarpage.php';} else {echo 'pages/calendarpage.php';}?>">Kalender</a>
                            <a class="nav-link text-white" href="<?php if ($_SESSION['sort'] == 'page') {echo '../pages/playBack.php';} else {echo 'pages/playBack.php';}?>">Livestream</a>
                    </div>
                    <div class="col-6">
                        <h3>Acount</h3>
                            <a class="nav-link text-white" href="">Profiel</a>
                            <a class="nav-link text-white" href="<?php if ($_SESSION['sort'] == 'page') {echo '../pages/register.php';} else {echo 'pages/register.php';}?>">Login/Registeren</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="https://use.fontawesome.com/ef0ace9f36.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>