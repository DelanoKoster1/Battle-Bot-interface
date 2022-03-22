<?php
include_once('../components/head.html');
include_once('../functions/function.php');
include_once('../functions/database.php');

$acceptedFileTypes = ["image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf"];

if (isset($_POST['submitBot'])) {
    if (isset($_POST['botName']) && $botName = filter_input(INPUT_POST, 'botName', FILTER_SANITIZE_SPECIAL_CHARS)) {
        if (isset($_POST['botDiscription']) && $botDiscription = filter_input(INPUT_POST, 'botDiscription', FILTER_SANITIZE_SPECIAL_CHARS)) {
            if (isset($_POST['macAddress']) && $macAdress = filter_input(INPUT_POST, 'macAddress', FILTER_SANITIZE_SPECIAL_CHARS)) {
                
                $sql = "INSERT INTO bot (name, description, macAddress) VALUES (?,?,?)";

                if (!stmtExec($sql, 0, $botName, $botDiscription, $macAdress)) {
                    $_SESSION['error'] = "Voer alle velden in";
                    header("location: ../components/error.php");
                }

                if (checkIfFile("botPic")) {
                    if (checkFileSize("botPic")) {
                        if (checkFileType("botPic", $acceptedFileTypes)) {
                            if (makeFolder()) {
                                if (!checkFileExist()) {
                                    if (uploadFile()) {
                                        echo "<div class='alert alert-success'>Bot aangemaakt</div>";
                                    }
                                }
                            }
                        }
                    }
                }

            } else {
                echo "<div class= ' alert alert-danger'>Voer het Mac adress van de bot in</div>";
            }
        } else {
            echo "<div class= ' alert alert-danger'>Voer een beschijving van de bot in</div>";
        }
    } else {
        echo "<div class= ' alert alert-danger'>Voer de naam van de bot in</div>";
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bot Toevoegen</title>
</head>

<body>
    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="col-4">
            <input class="form-control mt-3" placeholder="Bot Naam" name="botName" id="botName" type="text">
            <input class="form-control mt-3" placeholder="Omschrijving" name="botDiscription" id="botDiscription" type="text">
            <input class="form-control mt-3" placeholder="Mac address" name="macAddress" id="macAddress" type="text">
            <label class="mt-3" for="botPic">Foto Bijvoegen</label>
            <input id="botPic" name="botPic" class="form-control mt-3" type="file">
            <input class="btn btn-danger mt-3" type="submit" id="submitBot" name="submitBot" value="Bot toevoegen">
        </div>
    </form>
</body>

</html>