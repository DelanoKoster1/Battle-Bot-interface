<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once('../components/head.html') ?>
    <title>Calendar</title>
</head>

<body>
    <header>
        <?php include_once('../components/header.php') ?>
    </header>

    <main id='events'>
        <div class='containter py-4'>
            <div class="row">
                <div class="col-12 mb-2 text-center">
                    <h3>Komende evenementen</h3>
                </div>
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="card mx-3 event">
                        <div class="calendarbox d-flex justify-content-center align-items-center">
                            <div>
                                <span class="calendarDay d-block">25</span>
                                <span class="calendarMonth">Maart</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-center">Test dag</h6>
                            <div class="text-center">
                                <span>The testing date for the official event</span>
                            </div>
                            <div class="time text-center">
                                <span>08:30 - 12:15</span>
                            </div>
                        </div>
                    </div>
                    <div class="card mx-3 event">
                        <div class="calendarbox d-flex justify-content-center align-items-center">
                            <div>
                                <span class="calendarDay d-block">14</span>
                                <span class="calendarMonth">April</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-center">Race dag</h6>
                            <div class="text-center">
                                <span>Official BattleBots event date</span>
                            </div>
                            <div class="time text-center text-bottom">
                                <span>08:30 - 12:15</span>
                            </div>
                        </div>
                    </div>
                </div>                 
            </div>
        </div>
    </main>
    <footer>
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>