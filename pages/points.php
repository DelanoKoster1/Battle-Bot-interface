<?php 
    include_once('../functions/function.php');
    $conn = connectDB();

    $pointsPerTeam = array();
    $progress = array();
    $maxPoints = 75;

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
        $pointsPerTeam += [$teamName => $points];
        $progressPerTeam = ($pointsPerTeam[$teamName] / $maxPoints) * 100 . "%";
        $progress += [$teamName => $progressPerTeam];
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
            <?php foreach($pointsPerTeam as $team => $point) { ?>
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
            </div>
            <?php } ?>
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