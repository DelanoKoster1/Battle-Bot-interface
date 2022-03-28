<?php
include_once('../functions/function.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('../components/head.html');
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

    $query = "SELECT id, name
              FROM streamhistory 
              where id = 1
              ";

    $historyResults = stmtExec($query);
    ?>

    <video width="250"  autoplay muted controls id="VideoPlayback">
        <source src="/Project Battle Bot/Battle-Bot-interface/assets/video/Purple_Disco_Machine,_Sophie_and_the_Giants_-_In_The_Dark.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <footer class="navbar">
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>