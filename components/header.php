<header class="bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <img class="img-fluid logo" src="<?php if ($_SESSION['sort'] == 'page') {echo '../assets/img/logo/logo.png';} else {echo 'assets/img/logo/logo.png';}?>" alt="logo">
            </div>
            <div class="col-lg-8 my-auto">
                <nav class="navbar">
                    <ul class="nav w-100 nav-fill">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php if ($_SESSION['sort'] == 'page') {echo '../index.php';} else {echo 'index.php';}?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php if ($_SESSION['sort'] == 'page') {echo '../pages/robots.php';} else {echo 'pages/robots.php';}?>">Robots</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php if ($_SESSION['sort'] == 'page') {echo '../pages/calendarpage.php';} else {echo 'pages/calendarpage.php';}?>">Kalender</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php if ($_SESSION['sort'] == 'page') {echo '../pages/playBack.php';} else {echo 'pages/playBack.php';}?>">Livestream</a>
                        </li>
                        <li class="nav-item text-right">
                            <a class="nav-link text-danger" href="<?php if ($_SESSION['sort'] == 'page') {echo '../pages/register.php';} else {echo 'pages/register.php';}?>">Login / Registeren</a>
                        </li>
                        <li class="nav-item text-right">
                              <a class="nav-link text-danger" href="#">/ Registeren</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>