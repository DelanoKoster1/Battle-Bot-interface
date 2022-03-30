<?php
include_once('../functions/function.php');

global $error;

if (isset($_POST['playerInfoChange'])) {
    if (checkIfFile($_FILES['botTeamImage'])) {
        if (checkFileSize($_FILES['botTeamImage'])) {
            if (checkFileType($_FILES['botTeamImage'])) {
                if (makeFolder($botId, "../assets/img/bots/")) {
                    if (!checkFileExist("../assets/img/bots/" . $botId . "/", $_FILES['botTeamImage']['name'])) {
                        $query = "UPDATE `bot` SET imagePath = ? WHERE id = ?";

                        if (uploadFile($_FILES['botTeamImage'], $query, $botId, "/assets/img/bots/{$botId}/")) {
                            $_SESSION['succes'] = 'De robot is succesvol toegevoegd!';
                            header("location:../pages/admin.php?bot");
                            exit();
                        } else {
                            $error[] = "Er is iets fout gegaan bij  het uploaden van het bestand!";
                            $_SESSION['ERROR_MESSAGE'] = $error;
                            header('location: admin.php?bot');
                            exit();
                        }
                    } else {
                        $error[] = "Het geüploade bestand bestaat al!";
                        $_SESSION['ERROR_MESSAGE'] = $error;
                        header('location: admin.php?bot');
                        exit();
                    }
                } else {
                    $error[] = "Er is iets fout gegaan bij  het uploaden van het bestand!";
                    $_SESSION['ERROR_MESSAGE'] = $error;
                    header('location: admin.php?bot');
                    exit();
                }
            } else {
                $error[] = "Dit bestandstype wordt niet geaccepteerd!";
                $_SESSION['ERROR_MESSAGE'] = $error;
                header('location: admin.php?bot');
                exit();
            }
        } else {
            $error[] = "Het geüploade bestand is te groot!";
            $_SESSION['ERROR_MESSAGE'] = $error;
            header('location: admin.php?bot');
            exit();
        }
    } else {
        $_SESSION['succes'] = "De robot is succesvol toegevoegd!";
        $_SESSION['ERROR_MESSAGE'] = $error;
        header('location: admin.php?bot');
        exit();
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
            <h3 class="mt-3">verander team informatie</h3>
            <?php echo changeTeamInfo(); ?>
        </div>
    </div>
    <div>
        <?php include_once("../components/footer.php"); ?>
    </div>
</body>

</html>