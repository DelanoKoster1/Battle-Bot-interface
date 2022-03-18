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

    mysqli_stmt_store_result($stmt);
    $rows  = mysqli_stmt_num_rows($stmt);
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
    <link rel="styelsheet" href="../assets/css/pointspage.css">

    <title>Punten Pagina</title>
</head>


<body>
<section id="header">
    <?php includeHeader('page'); ?>
</section>

<div class="container">
    <?php if($_SESSION['role'] == 1) { ?>
    <div class="row">
        <div class="col-12 text-center pt-3">
            <h1>Scores</h1>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-2"></div>
        <div class="col-8">
            <?php for($count = 0; $count < $rows; $count++) { ?>
            <div class="row">
                <div class="col-2 d-flex align-items-center mt-4">
                    <img class="w-100" src="../assets/img/battlebotlogo.png" alt="Picture of Robot">
                    <span class="d-md-none"><?= $teamNames[$count] ?></span>
                </div>
                <div class="col-12 col-md-10">
                    <div class="col-10 col-md-12 d-none d-md-block">
                        <p class="mb-2 ps-2"><?= $teamNames[$count] ?></p>
                    </div>
                    <div class="col-12 progress h-50 mb-5">
                        <div class="progress-bar" style="width: <?=$progress[$count]?>" role="progressbar"> </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="col-2"></div>
    </div>
    <?php } ?>

    <?php if($_SESSION['role'] == 2) { ?>
    <div class="row">
        <div class="col-12 text-center pt-3">
            <h1>Scores</h1>
        </div>
    </div>
    <div class="row pt-3">
        
        <div class="col-6">
            <?php for($count = 0; $count < $rows; $count++) { ?>
            <div class="row">
                <div class="col-2 d-flex align-items-center mt-4">
                    <img class="w-100" src="../assets/img/battlebotlogo.png" alt="Picture of Robot">
                    <span class="d-md-none"><?= $teamNames[$count] ?></span>
                </div>
                <div class="col-12 col-md-10">
                    <div class="col-10 col-md-12 d-none d-md-block">
                        <p class="mb-2 ps-2"><?= $teamNames[$count] ?></p>
                    </div>
                    <div class="col-12 progress h-50 mb-5">
                        <div class="progress-bar" style="width: <?=$progress[$count]?>" role="progressbar"> </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="col-6">
            <div class="">
                
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<footer class="mt-5">
    <?php include_once('../components/footer.php') ?>
</footer>
</body>

</html>