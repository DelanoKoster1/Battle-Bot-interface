<?php 
    include_once('../functions/function.php');

    $pointsPerTeam = array();
    $progress = array();
    $maxPoints = 75;

    $sql = "SELECT teamId, points, name FROM `team-event` JOIN team ON team.id = `team-event`.teamId";
    $results = stmtExec($sql);

    if(empty($results)) {
        header("location: ../components/error.php");
    }

    $teamIds = $results["teamId"]; 
    $points = $results["points"];  
    $teamNames = $results["name"]; 

    for($i = 0; $i < count($teamIds); $i++) {
        $pointsPerTeam += [$teamNames[$i] => $points[$i]];
        $progressPerTeam = ($pointsPerTeam[$teamNames[$i]] / $maxPoints) * 100 . "%";
        $progress += [$teamNames[$i] => $progressPerTeam];
    }
    

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('../components/head.html');
    include_once('../functions/function.php');
    ?>
    <link href="../assets/img//logo/logo.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">

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
            <?php foreach ($pointsPerTeam as $team => $point) { ?>
            <div class="row">
                <div class="col-md-2 col-12 d-flex align-items-end mt-4">
                    <img class="img-fluid scoreImg" src="../assets/img/battlebotlogo.png" alt="<?= $team ?>">
                    <span class="d-md-none my-auto"><?= $team ?></span>
                </div>
                <div class="col-12 col-md-10">
                    <div class="col-10 col-md-12 d-none d-md-block">
                        <p class="mb-2 ps-2"><?= $team ?></p>
                    </div>
                    <div class="col-12 progress h-50 mb-5">
                        <div class="progress-bar" style="width: <?=$progress[$team]?>" role="progressbar" data-bs-toggle="tooltip" title="<?= $pointsPerTeam[$team]?>"></div>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<footer class="mt-5">
    <?php include_once('../components/footer.php') ?>
</footer>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
</body>

</html>