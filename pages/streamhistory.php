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

    $query = "SELECT id, name
              FROM streamhistory 
              where id = 1
              ";

    $historyResults = stmtExec($query);

   

    if (!empty($historyResults["id"])) {
        $ids = $historyResults["id"];

        for ($i = 0; $i < count($ids); $i++) {
            $name = $historyResults["name"][$i];
            $id = $historyResults["id"][$i];

            echo '
            <div class="col-sm-3 mb-4 pt-5">
                <div class="card eventsCard">
                    <div class="card-body">
                        <span class="calendarTitle d-block text-capitalize"><a class="stretched-link" href="watchBack.php?id='.$id.'">' . $name . '</a></span>
                    </div>
                </div>
            </div>
            ';
        }
    }

    ?>

    <footer class="navbar">
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>