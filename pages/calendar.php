<?php
include_once('../functions/function.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        include_once('../components/head.html');
    ?>
    <link href="../assets/img//logo/logo.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">

    <title>Calendar</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>
    
    <main id='events'>
        <div class='containter py-4'>
            <div class="row">
                <div class="col-12 mb-2 text-center">
                    <h3>Evenementen</h3>
                </div>
                <div class="text-center alert alert-dark" id="eventTimeDisplay" role="alert">
                    <span hidden id="dateOfEvent"><?= eventTimeDescent(); ?></span>
                </div>
            </div>
            
            <div class="row m-auto eventShowBox">
                <?php showEvents(); ?>
            </div>
        </div>
    </main>

    <footer class="navbar">
        <?php include_once('../components/footer.php') ?>
    </footer>
    <script src="../assets/js/timer.js"></script>
</body>

</html>