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
                <div class="col-12 mb-2 text-left">
                    <h3>Komende evenementen</h3>
                </div>
                <div class="col-lg-12 d-flex justify-content-left">
                    <div class="card mx-3 event">
                        <div class="d-flex justify-content-left align-items-center">
                            <div>
                                <span class="calendarDate d-block">25 Maart 2022</span>
                                <span class="calendarTitle">Testdag</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-left">
                            <span class="calendarInfo mt-4">De officiële testdag van het evenement</span>
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
            </div>
        </div>
    </main>

    <footer>
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>