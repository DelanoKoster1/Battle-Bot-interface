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

    <title>Terugkijken</title>
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

    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    $query = "SELECT name, stream, date
              FROM event 
              where id = ?
              ";

    $historyResults = stmtExec($query, 0, $id);

    $name = $historyResults["name"][0];
    $date = $historyResults["date"][0];
    $stream = $historyResults["stream"][0];
    ?>
    <div>
        <h1><?=$name?> - <?=formatdate($date)?></h1>
        <video width="250"  autoplay muted controls id="VideoPlayback">
            <source src="../assets/video/<?=$stream?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <footer class="navbar">
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>