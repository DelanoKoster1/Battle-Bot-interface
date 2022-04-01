<?php
include_once('../functions/function.php');

global $error;

if (isset($_POST['playerInfoChange'])) {
    $teamname = filter_input(INPUT_POST, "teamName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $botname = filter_input(INPUT_POST, "botName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, "botDescription", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $board = filter_input(INPUT_POST, "specsBoard", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $interface = filter_input(INPUT_POST, "specsInterface", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $botId = filter_input(INPUT_POST, 'botId' , FILTER_SANITIZE_NUMBER_INT);
    
    $query ="  UPDATE  `bot`
                JOIN    `specs`     ON specs.id = bot.specsId
                JOIN    `team`      ON team.botId = bot.id  
                JOIN    `account`   ON account.teamId = team.id
                SET     bot.name = ?, 
                        bot.description = ?,
                        specs.board = ?, 
                        specs.interface = ?, 
                        team.name = ?
                WHERE   account.username = ?
            ";

    if (stmtExec($query, 0, $botname, $description, $board, $interface, $teamname, $_SESSION['username'])) {
        $_SESSION['succes'] = 'De gegevens zijn succesvol aangepast!';
    } else {
        $error[] = "Er ging iets mis bij het aanpassen van de gegevens, probeer het opnieuw!";
        $_SESSION['ERROR_MESSAGE'] = $error;
    }
    
    if (checkIfFile($_FILES['botTeamImage'])) {
        if (checkFileSize($_FILES['botTeamImage'])) {
            if (checkFileType($_FILES['botTeamImage'])) {
                if (makeFolder($botId, "../assets/img/bots/")) {         
                    if (!checkFileExist("../assets/img/bots/" . $botId . "/", $_FILES['botTeamImage']['name'])) {
                        $query = "  UPDATE  `bot`
                                        SET     imagePath = ?
                                        WHERE   id = ?
                                    ";

                        deleteFile("../assets/img/bots/{$botId}/");

                        if (!uploadFile($_FILES['botTeamImage'], $query, $botId, "/assets/img/bots/{$botId}/")) {
                            $error[] = "Er is iets fout gegaan bij  het uploaden van het bestand!";
                            $_SESSION['ERROR_MESSAGE'] = $error;
                            header('location: admin.php?info');
                            exit();
                        } 
                    } else {
                        $error[] = "Het geüploade bestand bestaat al!";
                        $_SESSION['ERROR_MESSAGE'] = $error;
                    }
                } else {
                    $error[] = "Er is iets fout gegaan bij het uploaden van het bestand!";
                    $_SESSION['ERROR_MESSAGE'] = $error;
                }
            } else {
                $error[] = "Dit bestandstype wordt niet geaccepteerd!";
                $_SESSION['ERROR_MESSAGE'] = $error;
            }
        } else {
            $error[] = "Het geüploade bestand is te groot!";
            $_SESSION['ERROR_MESSAGE'] = $error;
        }
    } else {
        $_SESSION['succes'] = "De robot is succesvol toegevoegd!";
        $_SESSION['ERROR_MESSAGE'] = $error;
    }
}
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
                <?php
                }
                ?>
            <h3 class="mt-3 text-center">Team informatie</h3>
            <?php echo changeTeamInfo(); ?>
        </div>
    </div>
    <div>
        <?php include_once("../components/footer.php"); ?>
    </div>
</body>

</html>