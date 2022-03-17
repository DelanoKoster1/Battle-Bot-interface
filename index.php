<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('components/head.html');
    include_once('functions/function.php');
    include_once('functions/database.php');
    include_once('functions/formattedtime.php');
    ?>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <title>Voorpagina</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('index'); ?>
    </section>
    <section id="content">
        <div class="container">
            <div class="row py-5">
                <div class="col-lg-6 col-12">
                    <h1>Welkom bij Battlebots</h1>
                    <p>Battle Bots is een evenement georganiseerd door de eerste jaar studenten van het NHL Stenden Hogeschool te Emmen. Er doen 5 robots mee aan het event. Elke robot moet 5 spellen kunnen spelen. De robot die de meeste spellen wint, wint het evenement.</p>
                    <p>Het evenement vind plaats op donderdag 14 April.</p>
                </div>
                <div class="col-lg-6 col-12 text-center livestream">
                    <a class="livestream" href="./pages/livestream.php">
                        <img class="img-fluid frontpageIMG" src="assets/img/photo1.png" alt="Battlebots">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="bots">
        <div class="botBanner py-2">
            <div class="container">
                <div class="row my-4">
                    <div class="col-12 text-center mb-4">
                        <h3 class="text-white">Ontmoet de Bots</h3>
                    </div>
                    <div class="col-12 d-flex justify-content-between">
                        <?php
                        $sql = "SELECT id, name, imagePath FROM bot";
                        $dbResults = stmtExec($sql);
                        $ids = $dbResults["id"];
                        foreach ($ids as $botId) {
                            $id = $botId;
                            $imgPath = $dbResults["imagePath"][$botId - 1];
                            if ($imgPath === "image.png") $imgPath = "assets/img/bots/BB_sawblaze-beauty.jpg";
                            $name = $dbResults["name"][$botId - 1];
                            echo "<div class='card'>
                                        <img src='$imgPath' class='img-fluid card-img-top' alt='$name'>
                                        <div class='card-body'>
                                            <h5 class='card-title text-center'><a href='pages/robots.php?botName=$name' class='stretched-link'>$name</a></h5>
                                        </div>
                                    </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="events">
        <div class="container py-4">
            <div class="row">
                <div class="col-12 mb-2 text-center">
                    <h3>Evenementen</h3>
                </div>
                <div class="col-lg-12 d-flex justify-content-center">
                    <?php
                    $sql = "SELECT id, name, date, description FROM event";
                    $eventResults = stmtExec($sql);
                    $ids = $eventResults["id"];

                    foreach ($ids as $eventId) {
                        $name = $eventResults["name"][$eventId - 1];
                        $eventDate = $eventResults["date"][$eventId - 1];
                        // $date = $eventDate[0];

                        $description = $eventResults["description"][$eventId - 1];
                        echo "<div class='card mx-3 event'>
                                    <div class='d-flex justify-content-left align-items-center'>
                                        <div>
                                            <span class='calendarDate d-block'>" . formatdate($eventDate) . "</span>
                                            <span class='calendarTitle'>$name</span>
                                        </div>
                                    </div>
                                    <div class='d-flex justify-content-left'>
                                        <span class='calendarInfo mt-4'>$description</span>
                                    </div>
                                </div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php include_once('components/footer.php') ?>
</body>

</html>