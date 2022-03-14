<header class="bg-dark">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <a href="<?=($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php';?>">
                    <img class="img-fluid logo" src="<?=($_SESSION['sort'] == 'page')? '..\assets\img\logo\logo(1).svg' : 'assets\img\logo\logo(1).svg'?>" alt="logo">
                </a>
            </div>
            <div class="col-lg-8 my-auto">
                <nav class="navbar">
                    <ul class="nav w-100 nav-fill">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= ($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php'?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= ($_SESSION['sort'] == 'page') ? '../pages/robots.php' : 'pages/robots.php'?>">Robots</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= ($_SESSION['sort'] == 'page') ? '../pages/pointspage.php' : 'pages/pointspage.php'?>">Scores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= ($_SESSION['sort'] == 'page') ? '../pages/calendarpage.php' : 'pages/calendarpage.php'?>">Kalender</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= ($_SESSION['sort'] == 'page') ? '../pages/livestream.php' : 'pages/livestream.php'?>">Livestream</a>
                        </li>
                        <li class="nav-item text-right">
                            <a class="nav-link text-danger" href="<?= ($_SESSION['sort'] == 'page') ? '../pages/register.php' : 'pages/register.php'?>">Login / Registeren</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>