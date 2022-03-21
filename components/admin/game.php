<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('../components/head.html');
    include_once('../functions/function.php');
    include_once('../functions/database.php');
    ?>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/gamepage.css">

    <title>gamepage</title>
</head>

<body>
    <?php include_once('../components/header.php'); ?>

    <div class="container">
        <h4 style="text-align: center; margin: 10px; padding: 10px;">Robots</h4>
        <div class="row my-5">
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="box bg-secondary d-flex justify-content-center start-button-all">
                    <div class="row g-0 w-100 text-center">
                        <div class="col-12 pt-1">
                            <img src="../assets/img/playbutton.svg" alt="Logo of a playbutton">
                        </div>
                        <div class="col-12 position-relative">
                            <div class="botName position-absolute w-100 bottom-0">
                                <span class="start">Start!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-4 col-6">
                    <div id="doolhof" class="box bg-secondary d-flex justify-content-center game-card-all">
                        <div class="row g-0 w-100 text-center">
                            <div class="col-12 pt-1">
                                <img src="../assets/img/joystick.svg" alt="Logo of a joystick">
                            </div>
                            <div class="col-12 position-relative">
                                <div class="botName position-absolute w-100 bottom-0">
                                    <span class="fw-bold">Doolhof</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-6">
                    <div id="butler" class="box bg-secondary d-flex justify-content-center game-card-all">
                        <div class="row g-0 w-100 text-center">
                            <div class="col-12 pt-1">
                                <img src="../assets/img/joystick.svg" alt="Logo of a joystick">
                            </div>
                            <div class="col-12 position-relative">
                                <div class="botName position-absolute w-100 bottom-0">
                                    <span class="fw-bold">Butler</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-6">
                    <div id="race" class="box bg-secondary d-flex justify-content-center game-card-all">
                        <div class="row g-0 w-100 text-center">
                            <div class="col-12 pt-1">
                                <img src="../assets/img/joystick.svg" alt="Logo of a joystick">
                            </div>
                            <div class="col-12 position-relative">
                                <div class="botName position-absolute w-100 bottom-0">
                                    <span class="fw-bold">Race</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <?php
        $sql = "SELECT  bot.id,
                        bot.name,
                        bot.imagePath,
                        team.name
                FROM    bot
                INNER JOIN team
                        ON bot.id = team.botId
        ";
        $dbResults = stmtExec($sql);
        $ids = $dbResults["bot.id"];
        foreach ($ids as $botId) {
            $id = $botId;
            $imgPath = $dbResults["bot.imagePath"][$botId - 1];
            if ($imgPath === "image.png") $imgPath = "../assets/img/bot.svg";
            $name = $dbResults["bot.name"][$botId - 1];
            $teamName = $dbResults["team.name"][$botId - 1];
        ?>
            <div class="row my-5">
                <h3 style="padding: 10px; margin: 10px;">Robot : <?=$name?> (<?=$teamName?>).</h3>
                <div class="col-lg-2 col-sm-4 col-6">
                    <div class="box bg-secondary d-flex justify-content-center">
                        <div class="row g-0 w-100 text-center">
                            <div class="col-12 pt-1">
                                <img src="../assets/img/bot.svg" alt="<?=$name?>">
                            </div>
                            <div class="col-12 position-relative">
                                <div class="botName position-absolute w-100 bottom-0">
                                    <span><?=$name?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-6">
                    <div id="doolhof-<?= $id ?>" class="box bg-secondary d-flex justify-content-center game-card-single">
                        <div class="row g-0 w-100 text-center">
                            <div class="col-12 pt-1">
                                <img src="../assets/img/joystick.svg" alt="Logo of a joystick">
                            </div>
                            <div class="col-12 position-relative">
                                <div class="botName position-absolute w-100 bottom-0">
                                    <span class="fw-bold">Doolhof</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-6">
                    <div id="butler-<?= $id ?>" class="box bg-secondary d-flex justify-content-center game-card-single">
                        <div class="row g-0 w-100 text-center">
                            <div class="col-12 pt-1">
                                <img src="../assets/img/joystick.svg" alt="Logo of a joystick">
                            </div>
                            <div class="col-12 position-relative">
                                <div class="botName position-absolute w-100 bottom-0">
                                    <span class="fw-bold">Butler</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-6">
                    <div id="race-<?= $id ?>" class="box bg-secondary d-flex justify-content-center game-card-single">
                        <div class="row g-0 w-100 text-center">
                            <div class="col-12 pt-1">
                                <img src="../assets/img/joystick.svg" alt="Logo of a joystick">
                            </div>
                            <div class="col-12 position-relative">
                                <div class="botName position-absolute w-100 bottom-0">
                                    <span class="fw-bold">Race</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        <?php
        }
        ?>
    </div>

    <footer>
        <?php include_once('../components/footer.php') ?>
    </footer>
    <script src="../assets/js/functions.js"></script>
    <script src="../assets/js/game.js"></script>
</body>

</html>