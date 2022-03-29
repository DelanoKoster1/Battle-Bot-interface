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

    <?php

    /**
     * Function to show events as HTML
     * 
     */

    $query = "SELECT stream
              FROM event 
              WHERE date < now()
              AND id = ?
    ";

    $historyResults = stmtExec($query,0, $_GET['id']);
    ?>

    <video width="250"  autoplay muted controls id="VideoPlayback">
        <source src="..<?=$historyResults['stream'][0]?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <footer class="navbar">
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>