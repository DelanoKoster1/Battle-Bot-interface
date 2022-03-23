<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('../components/head.html');
    include_once('../functions/function.php');
    ?>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/robots.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <title>Bot Page</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>
    <div class="container-fluid">
        <div class="row my-5 nav nav-tabs justify-content-evenly" role="tablist">
            <?php
            $sql = "SELECT id, name, imagePath FROM bot";
            $dbResults = stmtExec($sql);
            $ids = $dbResults["id"];
            foreach ($ids as $botId) {
                $id = $botId;
                $imgPath = $dbResults["imagePath"][$botId - 1];
                if ($imgPath === "image.png") $imgPath = "../assets/img/bot.svg";
                $name = $dbResults["name"][$botId - 1];
                echo ' 
                    <div class="col-lg-2 col-sm-4 col-6" data-bs-toggle="tab" data-bs-target="#' . $name . '" type="button" role="tab" aria-controls="' . $name . '" aria-selected="false">
                        <div class="box bg-secondary d-flex justify-content-center">
                            <div class="row g-0 w-100 text-center">
                                <div class="col-12 pt-1">
                                    <img class="img-fluid" src="' . $imgPath . '" alt="' . $name . '">
                                </div>
                                <div class="col-12 position-relative">
                                    <div class="botName position-absolute w-100 bottom-0">
                                        <span>' . $name . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
            ?>
        </div>

        <div class="row ms-4">
            <div class="col-12">
                <h1>Team</h1>
            </div>
            <div class="tab-content">
                <?php
                $sql = "SELECT  team.id,
                                team.name,
                                bot.name,
                                bot.id,
                                bot.specsId,
                                specs.board,
                                specs.interface,
                                stats.wins,
                                stats.playedMatches
                        FROM    team
                        INNER JOIN bot 
                        ON team.botId = bot.id 
                        INNER JOIN specs 
                        ON specs.id = bot.specsId  
                        INNER JOIN stats
                        ON stats.id = bot.statsId         
                ";
                $dbResults = stmtExec($sql);
                // debug($dbResults);
                $ids = $dbResults["team.id"];
                foreach ($ids as $teamId) {
                    $id = $teamId;
                    $botId = $dbResults["bot.id"][$teamId - 1];
                    $botName = $dbResults["bot.name"][$teamId - 1];
                    $teamName = $dbResults["team.name"][$teamId - 1]; 
                    $specsBoard = $dbResults["specs.board"][$botId - 1];
                    $specsInterface = $dbResults["specs.interface"][$botId - 1];;
                    $gamesWon = $dbResults["stats.wins"][$botId - 1];;
                    $gamesPlayed = $dbResults["stats.playedMatches"][$botId - 1];; 
                    echo ' 
                        <div class="tab-pane" id="' . $botName . '" role="tabpanel" aria-labelledby="' . $botName . '">
                            <div class="row">
                                <div class="col-lg-2 col-sm-4 col-6 my-3">
                                    <div class="box bg-secondary d-flex justify-content-center">
                                        <div class="row g-0 w-100 text-center">
                                            <div class="col-12 my-auto">
                                                <img class="img-fluid" src="../assets/img/person.svg" alt="' . $teamName . '">
                                            </div>
                                            <div class="col-12 position-relative">
                                                <div class="botName position-absolute w-100 bottom-0">
                                                    <span>' . $teamName . '</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="my-3">Stats</h3>
                                    <table class="table mb-5">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Aantal Spellen Gespeeld</th>
                                                <th scope="col">Aantal Spellen Gewonnen</th>
                                                <th scope="col">Aantal Spellen Verloren</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row"></th>
                                                <td>' . $gamesPlayed . '</td>
                                                <td>' . $gamesWon . '</td>
                                                <td>' . $gamesPlayed - $gamesWon . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-6">
                                    <h3 class="my-3">Specs</h3>
                                    <table class="table mb-5">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Board</th>
                                                <th scope="col">Interface</th>                                           
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row"></th>
                                                <td>' . $specsBoard . '</td>
                                                <td>' . $specsInterface . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        ';
                }
                ?>
            </div>
        </div>
    </div>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const botname = urlParams.get('botName');

        var trigger = document.getElementById(botname)
        if (trigger != null) {
            trigger.classList.add('active');
        }
    </script>
    <footer>
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>