<?php
include_once('../functions/function.php');

global $error;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    includeHead('page');
    ?>
    <link href="../assets/img//logo/logo.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>Team bewerken - Battlebots</title>
</head>

<body class="bg-light">
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>
    <div class="container bg-white w-50 height py-4">
        <div class="row">
            <?php
            if (!empty($_SESSION['succes'])) {
            ?>
                <div class="col-md-12">
                    <div class="alert alert-success text-black fw-bold p-4 rounded-0" role="alert">
                        <ul class="mb-0">
                            <?php
                            echo '<li>' . $_SESSION['succes'] . '</li>';
                            $_SESSION['succes'] = '';
                            ?>
                        </ul>
                    </div>
                </div>
            <?php
            }
            if (!empty($_SESSION['ERROR_MESSAGE'])) {
            ?>
                <div class="row" id="errorBar">
                    <div class="col-md-12">
                        <div class="alert alert-danger text-black fw-bold p-4 rounded mb-3 alertBox" role="alert">
                            <ul class="mb-0">
                                <?php
                                foreach ($_SESSION['ERROR_MESSAGE'] as $errorMsg) {
                                    echo '<li>' . $errorMsg . '</li>';
                                }

                                unset($_SESSION['ERROR_MESSAGE']);
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <form class="col-md-12 col-12 bg-white" method="post">
                <h1 class="text-center">Team bewerken</h1>
                <table class="table table-responisve">
                    <thead>
                        <tr>
                            <td class="align-middle">Team Naam</td>
                            <td class="align-middle">Robot Naam</td>
                            <td class="align-middle">Robot Beschrijving</td>
                            <td class="align-middle">Robot Board</td>
                            <td class="align-middle">Robot Interface</td>
                            <td class="align-middle">Robot Foto</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT team.name, bot.name, bot.description, specs.board, specs.interface, bot.imagePath FROM team JOIN bot ON bot.id = team.botId JOIN specs ON bot.specsId = specs.id";
                        $results = stmtExec($query, 0);
                        foreach ($results as $key => $id) {
                        ?>
                            <tr>
                                <td class="align-middle"></td>
                                <td class="align-middle"></td>
                                <td class="align-middle"></td>
                                <td class="align-middle"></td>
                                <td class="align-middle"></td>
                                <td class="align-middle"></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <div>
        <?php include_once("../components/footer.php"); ?>
    </div>
</body>

</html>