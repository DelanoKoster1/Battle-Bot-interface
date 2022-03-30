<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('../functions/function.php');
    includeHead('page');
    ?>
    <link href="../assets/img//logo/logo.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/robots.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <title>Robot pagina - Battlebots</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>
    <h1 class="text-center py-4">Robots</h1>
    <div class="container-fluid">
        <div class="row my-5 nav nav-tabs justify-content-evenly" role="tablist">
            <?php
            $query = "SELECT bot.id, bot.name, bot.imagePath FROM bot INNER JOIN team ON team.botId = bot.id INNER JOIN specs ON specs.id = bot.specsId INNER JOIN stats ON stats.id = bot.statsId";

            $results = stmtExec($query);

            if (empty($results)) {
                header('location ../components/error.php');
            }

            for ($i = 0; $i < count($results["bot.id"]); $i++) {

                $botName = $results["bot.name"][$i];
                $botimagePath = $results["bot.imagePath"][$i];

                if ($botimagePath == NULL) $botimagePath = "/assets/img/bot.svg";

                echo ' 
                    <div class="col-lg-2 col-sm-4 col-6" data-bs-toggle="tab" data-bs-target="#' . $botName . '" type="button" role="tab" aria-controls="' . $botName . '" aria-selected="false">
                        <div class="box bg-secondary d-flex justify-content-center">
                            <div class="row g-0 w-100 text-center">
                                <div class="col-12 my-auto pt-1">
                                    <img class="img-fluid" src="..' . $botimagePath . '" alt="' . $botName . '">
                                </div>
                                <div class="col-12 position-relative">
                                    <div class="botName position-absolute w-100 bottom-0">
                                        <span>' . $botName . '</span>
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
                $sql = "SELECT  team.id, team.name, bot.name, bot.id, bot.specsId, specs.board, specs.interface, stats.wins, stats.playedMatches FROM team INNER JOIN bot ON team.botId = bot.id INNER JOIN specs ON specs.id = bot.specsId INNER JOIN stats ON stats.id = bot.statsId         ";
                
                $dbResults = stmtExec($sql);
                
                $ids = $dbResults["team.id"];
                foreach ($ids as $key => $teamId) {
                    $id = $teamId;
                    $botId = $dbResults["bot.id"][$key];
                    $botName = $dbResults["bot.name"][$key];
                    $teamName = $dbResults["team.name"][$key];
                    $specsBoard = $dbResults["specs.board"][$key];
                    $specsInterface = $dbResults["specs.interface"][$key];
                    $gamesWon = $dbResults["stats.wins"][$key];
                    $gamesPlayed = $dbResults["stats.playedMatches"][$key];
                    echo ' 
                        <div class="tab-pane" id="' . $botName . '" role="tabpanel" aria-labelledby="' . $botName . '">
                            <div class="row">
                                <div class="col-lg-2 col-sm-4 col-6 my-3">
                                    <div class="box bg-secondary d-flex justify-content-center">
                                        <div class="row g-0 w-100 text-center">
                                            <div class="col-12 my-auto">
                                                <img class="img-fluid mb-4" src="../assets/img/person.svg" alt="' . $teamName . '">
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
                                <div class="col-md-6">
                                    <h3 class="my-3">Stats</h3>
                                    <div class="table-responsive">
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
                                </div>
                                <div class="col-md-6">
                                    <h3 class="my-3">Specs</h3>
                                    <div class="table-responsive">
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