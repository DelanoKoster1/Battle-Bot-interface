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

    <title>Geschiedenis</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>

    <?php

    /**
     * Function to show events as HTML
     * 
     */

    $query = "SELECT id, name, weburl
              FROM streamhistory 
              WHERE date > now()
              ORDER BY date ASC
              limit 5";

    $historyResults = stmtExec($query);
    debug($historyResults);

    if (!empty($historyResults["id"])) {
        $ids = $historyResults["id"];

        for ($i = 0; $i < count($ids); $i++) {
            $name = $historyResults["name"][$i];
            $weburl = $historyResults["url"][$i];

            echo '
            <div class="col-sm-3 mb-4">
                <div class="card eventsCard">
                    <div class="card-body">
                        <span class="calendarTitle d-block text-capitalize">' . $name . '</span>
                        <span class="calendarInfo mt-4 d-block">' . $weburl . '</span>
                    </div>
                </div>
            </div>
            ';
        }
    } else { echo "test"; }

    ?>

    <footer class="navbar">
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>