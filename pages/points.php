<?php 
    include_once('../functions/database.php');
    include_once('../functions/function.php');
    $conn = connectDB();

    $maxPoints = 10;
    $sql = "SELECT teamId, points, `name` FROM `team-event` JOIN team ON team.id = `team-event`.teamId";
    $stmt = mysqli_prepare($conn, $sql);

    if(!$stmt) {
        header("location: ../components/error.php");
    }

    if(!mysqli_stmt_execute($stmt)) {
        header("location: ../components/error.php");
    }

    mysqli_stmt_bind_result($stmt, $teamId, $points, $teamName);

    while(mysqli_stmt_fetch($stmt)) {
        $teamNames[] = $teamName; 
        $pointsPerTeam = array($teamName => $points);
        $progressPerTeam = ($pointsPerTeam[$teamName] / $maxPoints) * 100 . "%";
        $progress[] = $progressPerTeam;
    }
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once('../components/head.html');
    include_once('../functions/function.php');
    ?>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="styelsheet" href="../assets/css/points.css">

    <title>Punten Pagina</title>
</head>


<body>
<section id="header">
    <?php includeHeader('page'); ?>
</section>

<div class="container">
    <div class="row">
        <div class="col-12 text-center pt-3">
            <h1>Scores</h1>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="row">
                <div class="col-2 d-flex align-items-center">
                    <img class="w-100" src="../assets/img/battlebotlogo.png" alt="Picture of Robot">
                </div>
                <div class="col-12 col-md-10">
                    <div class="col-10 col-md-12">
                        <p class="mb-2 ps-2"><?= $teamNames[0] ?></p>
                    </div>
                    <div class="col-12 progress h-50 mb-5">
                        <div class="progress-bar" style="width: <?=$progress[0]?>" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="row">
                <div class="col-2 d-flex align-items-center">
                    <img class="w-100" src="../assets/img/battlebotlogo.png" alt="Picture of Robot">
                </div>
                <div class="col-12 col-md-10">
                    <div class="col-12">
                        <p class="mb-2 ps-2"><?= $teamNames[1] ?></p>
                    </div>
                    <div class="col-12 progress h-50 mb-5">
                        <div class="progress-bar" style="width: <?=$progress[1]?>" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="row">
                <div class="col-2 d-flex align-items-center">
                    <img class="w-100" src="../assets/img/battlebotlogo.png" alt="Picture of Robot">
                </div>
                <div class="col-12 col-md-10">
                    <div class="col-12">
                        <p class="mb-2 ps-2"><?= $teamNames[2] ?></p>
                    </div>
                    <div class="col-12 progress h-50 mb-5">
                        <div class="progress-bar" style="width: <?=$progress[2]?>" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="row">
                <div class="col-2 d-flex align-items-center">
                    <img class="w-100" src="../assets/img/battlebotlogo.png" alt="Picture of Robot">
                </div>
                <div class="col-12 col-md-10">
                    <div class="col-12">
                        <p class="mb-2 ps-2"><?= $teamNames[3] ?></p>
                    </div>
                    <div class="col-12 progress h-50 mb-5">
                        <div class="progress-bar" style="width: <?=$progress[3]?>" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8 pb-5">
            <div class="row">
                <div class="col-2 d-flex align-items-center">
                    <img class="w-100" src="../assets/img/battlebotlogo.png" alt="Picture of Robot">
                </div>
                <div class="col-12 col-md-10">
                    <div class="col-12">
                        <p class="mb-2 ps-2"><?= $teamNames[4] ?></p>
                    </div>
                    <div class="col-12 progress h-50 mb-5">
                        <div class="progress-bar" style="width: <?=$progress[4]?>" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<footer>
    <?php include_once('../components/footer.php') ?>
</footer>
</body>

</html>