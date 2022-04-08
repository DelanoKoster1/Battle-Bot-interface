<?php
include_once('../functions/function.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    includeHead('page');
    ?>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/watchback.css">

    <title>Terugkijken - Battlebots</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-12">
                <?php
                $query = "SELECT stream,name FROM event WHERE date < now() AND id = ?";

                $historyResults = stmtExec($query, 0, $_GET['id']);
                ?>
                <h1 class="my-4 px-2"><?= $historyResults['name'][0] ?></h1>
                <div class="ratio ratio-16x9">
                    <video controls id="VideoPlayback" autoplay>
                        <source src="..<?= $historyResults['stream'][0] ?>" type="video/mp4">
                        Jouw browser ondersteunt de videotag niet.
                    </video>
                </div>
            </div>
        </div>
    </div>
    <footer class="navbar">
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>
</html>