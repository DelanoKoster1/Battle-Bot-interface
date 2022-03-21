<header class="bg-dark">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 col-lg-2 col-9">
                <a href="<?=($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php';?>">
                    <img class="img-fluid logo" src="<?=($_SESSION['sort'] == 'page')? '..\assets\img\logo\logo(1).svg' : 'assets\img\logo\logo(1).svg'?>" alt="logo">
                </a>
            </div>
            <div class="col-xl-8 col-lg-10 my-auto d-none d-lg-block">
                <nav class="navbar">
                    <ul class="nav w-100 nav-fill">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= ($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php'?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= ($_SESSION['sort'] == 'page') ? '../pages/robots.php' : 'pages/robots.php'?>">Robots</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= ($_SESSION['sort'] == 'page') ? '../pages/points.php' : 'pages/points.php'?>">Scores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= ($_SESSION['sort'] == 'page') ? '../pages/calendar.php' : 'pages/calendar.php'?>">Kalender</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= ($_SESSION['sort'] == 'page') ? '../pages/livestream.php' : 'pages/livestream.php'?>">Livestream</a>
                        </li>
                        <?php if (!isset($_SESSION['email'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="<?= ($_SESSION['sort'] == 'page') ? '../pages/login.php' : 'pages/login.php'?>">Login / Registeren</a>
                        </li>
                        <?php } ?>
                        <?php if (isset($_SESSION['email']) && $_SESSION['role'] == 2) { ?>
                            <li class="nav-item text-right">
                                <a class="nav-link text-danger" href="<?= ($_SESSION['sort'] == 'page') ? '../pages/admin.php' : 'pages/admin.php'?>">Adminpaneel</a>
                            </li>
                        <?php } ?>
                        <?php if (isset($_SESSION['email'])) { ?>
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="<?= ($_SESSION['sort'] == 'page') ? '../pages/logout.php' : 'pages/logout.php'?>">Uitloggen</a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
            <div class="col-3 d-lg-none my-auto text-center">
                <span id="open-btn" class="menu-btn align-middle pointer text-white material-icons">menu</span>
            </div>
        </div>
   
    <div id="mobilemenu" class="menu" style="display: none;">
  <div class="header-menu bg-dark">
    <div class="row">
      <div class="col-10 header-title">
        <a href="<?=($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php';?>"><img class="Mobilelogo" src="<?=($_SESSION['sort'] == 'page')? '..\assets\img\logo\logo(1).svg' : 'assets\img\logo\logo(1).svg'?>"" alt="Jumper Emmen"></a>
      </div>
      <div class="col-2 text-right">
        <span id="close-btn" class="close-btn"><i class="material-icons">clear</i></span>
      </div>
    </div>
  </div>
  <div class="menu-content">
    <nav role="navigation">
      <ul class="list-unstyled item-list mb-0">
        <li class="menu-item">
          <a href="<?= ($_SESSION['sort'] == 'page') ? '../index.php' : 'index.php'?>">
            <span>Home</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= ($_SESSION['sort'] == 'page') ? '../pages/robots.php' : 'pages/robots.php'?>">
            <span >Robots</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= ($_SESSION['sort'] == 'page') ? '../pages/points.php' : 'pages/points.php'?>">
            <span >Scores</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= ($_SESSION['sort'] == 'page') ? '../pages/calendar.php' : 'pages/calendar.php'?>">
            <span >Kalender</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= ($_SESSION['sort'] == 'page') ? '../pages/livestream.php' : 'pages/livestream.php'?>">
            <span>Livestream</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= ($_SESSION['sort'] == 'page') ? '../pages/login.php' : 'pages/login.php'?>">
            <span >Login / Registeren</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= ($_SESSION['sort'] == 'page') ? '../pages/logout.php' : 'pages/logout.php'?>">
            <span >Uitloggen</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</div>
</div>
</header>
<script>

    document.getElementById("open-btn").addEventListener("click", function() {
        document.getElementById('mobilemenu').classList.add("d-block");
    });
    document.getElementById("close-btn").addEventListener("click", function() {
        document.getElementById('mobilemenu').classList.remove("d-block");
    });
</script>