<?php
include_once('../functions/function.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    includeHead('page');
    ?>
    <link href="../assets/img//logo/logo.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/streamhistory.css">
    <link rel="stylesheet" href="../assets/css/footer.css">

    <title>Geschiedenis</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>

    <div class='container height py-4'>
        <div class="row">
            <div class="col-12 mb-2 text-center">
                <h3>Geschiedenis</h3>
            </div>
        </div>

        <div class="row m-auto eventShowBox">
            <?php
            $query = "SELECT id, name, description, date, stream
                            FROM event 
                            where date < now()
                            ";

            $historyResults = stmtExec($query);



            if (!empty($historyResults["id"])) {
                $ids = $historyResults["id"];

                for ($i = 0; $i < count($ids); $i++) {
                    $name = $historyResults["name"][$i];
                    $id = $historyResults["id"][$i];
                    $description = $historyResults["description"][$i];
                    $date = $historyResults["date"][$i];
                    $date = $historyResults["date"][$i];

                    echo '
                            <div class="col-sm-3 mb-4">
                                <div class="card eventsCard">
                                    <div class="card-body">
                                        <span class="calendarDate d-block text-lowercase">' . formatdate($date) . '</span>
                                        <span class="calendarTitle d-block text-capitalize">
                                            <a class="stretched-link" href="watchback.php?id=' . $id . '">' . $name . '</a>
                                        </span>
                                        <span class="calendarInfo mt-4 d-block">' . $description . '</span>
                                    </div>
                                </div>
                            </div>';
                }
            }
            ?>
        </div>
    </div>

    <footer class="navbar">
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>