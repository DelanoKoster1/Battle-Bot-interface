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
                </div>
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="card mx-3 event">
                        <div class="d-flex justify-content-left align-items-center">
                            <div>
                                <span class="calendarDate d-block">25 Maart 2022</span>
                                <span hidden id="dateOfEvent"><?= eventTimeDescent(); ?></span>
                                <span class="calendarTitle">Test dag</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-left">
                            <span class="calendarInfo mt-4">De officiële race dag van het evenement</span>
                        </div>
                    </div>
                    <div class="card mx-3 event">
                        <div class="d-flex justify-content-left align-items-center">
                            <div>
                                <span class="calendarDate d-block">14 April 2022</span>
                                <span class="calendarTitle">Race dag</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-left">
                            <span class="calendarInfo mt-4">De officiële race dag van het evenement</span>
                        </div>
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