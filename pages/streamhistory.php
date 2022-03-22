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

    <main id='streamhistory'>
        <div class="container">
            <div class="row mt-4">
                
            <?php
              $query = "SELECT id, name, weburl,
              FROM streamhistory 
              WHERE date > now()
              ORDER BY date ASC
              limit 5";

    $streamhistory = stmtExec($query);

    if (!empty($streamhistory["id"])) {
        $ids = $streamhistory["id"];

        for ($i = 0; $i < count($ids); $i++) {
            $name = $streamhistory["name"][$i];
            $weburl = $streamhistory["weburl"][$i];

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
    }
 ?>
    </main>


    </div>
    </div>

    <footer class="navbar">
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>