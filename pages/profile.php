<?php
include_once('../functions/function.php');

global $error;

if (!isset($_SESSION['email'])) {
    header('location: ../components/error.php');
}



if (isset($_POST['save'])) {
    $results = getProfileInfo();
    $success = false;
    $success2 = false;

    $curPassword = filter_input(INPUT_POST, 'curpassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newPassword = filter_input(INPUT_POST, 'newpassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $repeatPassword = filter_input(INPUT_POST, 'newpassword2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
        if ($username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            if ($results["username"][0] != $username || $results["email"][0] != $email) {
                if (!checkUserInDataBase($username, $email, true)) {
                    $query = "UPDATE    account
                              SET       username = ?,
                                        email = ?
                              WHERE     id = ?  
                    ";
                    stmtExec($query, 0, $username, $email, $_SESSION['id']);
                    $success = true;
                }
            }
        } else {
            $error[] = 'Deze gebruikersnaam is ongeldig!';
        }
    } else {
        $error[] = 'Dit e-mailadres is ongeldig!';
    }

    if (!empty($curPassword) || !empty($newPassword) || !empty($repeatPassword)) {
        
        if(empty($curPassword)) {
            $error[] = 'Huidige wachtwoord is niet gegeven!';
        }
        if(empty($newPassword)) {
            $error[] = 'Nieuwe wachtwoord is niet gegeven!';
        }
        if(empty($repeatPassword)) {
            $error[] = 'Nieuwe wachtwoord wordt niet herhaald!';
        }

        if(empty($error)) {
            if (password_verify($curPassword, $results['password'][0])) {
                if (checkProfilePassword($newPassword, $repeatPassword)) {
                    if (!password_verify($newPassword, $results['password'][0]) && !password_verify($repeatPassword, $results['password'][0])) {
                        $hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        $query = "UPDATE  account
                                  SET     `password` = ?
                                  WHERE   id = ?  
                                ";
                        stmtExec($query, 0, $hashPassword, $_SESSION['id']);
                        $success2 = true;
                    } else {
                        $error[] = 'Het nieuwe en herhaal wachtwoord mogen niet overeen komen met het huidige wachtwoord!';
                    }
                } else {
                    $error[] = 'De wachtwoorden komen niet overeen met elkaar!';
                }
            } else {
                $error[] = 'Het huidige wachtwoord is incorrect!';
            }
        } 
    }
}

$results = getProfileInfo();
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
    <title>Profiel - Battlebots</title>
</head>

<body class="bg-light">
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <form class="col-md-8 col-12 bg-white" method="post" action="">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center bg-white w-100 pt-5 mb-3">Welkom, <?= $results['username'][0] ?></h1>
                    </div>
                    <?php
                    if ($_SESSION['role'] == 3) {
                    ?>
                        <div class="col-12 text-center mb-3">
                            <span>
                                <a class="text-body" href="./editTeamInfo.php">
                                    <span class="material-icons align-middle">add</span>
                                    Team informatie bewerken
                                </a>
                            </span>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="col-12">
                        <?php
                        if (isset($_POST['save']) && !empty($error)) {
                            foreach ($error as $errorMsg) { ?>
                                <div class="col-md-12 p-0">
                                    <div class="alert alert-danger text-center text-black fw-bold p-4 mt-3 mb-3 rounded" role="alert">
                                        <?php echo $errorMsg ?>
                                    </div>
                                </div>
                            <?php
                            }
                        }
                        if (isset($_POST['save'])) {
                            if ($success == true) {
                            ?>
                                <div class="col-md-12 p-0">
                                    <div class="alert alert-success text-center text-black fw-bold p-4 mb-3 rounded" role="alert">
                                        <?php echo "De gegevens zijn succesvol geüpdate!" ?>
                                    </div>
                                </div>
                            <?php
                            }
                            if ($success2 == true) {
                            ?>
                                <div class="col-md-12 p-0">
                                    <div class="alert alert-success text-center text-black fw-bold p-4 mb-3 rounded" role="alert">
                                        <?php echo "Het wachtwoord is succesvol geüpdate!" ?>
                                    </div>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 bg-white">
                        <div class="input-group w-lg-50 mb-3 pb-2">
                            <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">person</span></span>
                            <input name="username" type="text" class="form-control bg-light" placeholder="Gebruikersnaam" value="<?= $results['username'][0] ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 bg-white">
                        <div class="input-group w-lg-50 mb-3 pb-2">
                            <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">email</span></span>
                            <input name="email" type="email" class="form-control bg-light" placeholder="E-mailadres" value="<?= $results['email'][0] ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 bg-white">
                        <div class="input-group w-lg-50 mb-3 pb-2">
                            <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">lock</span></span>
                            <input name="curpassword" id="curpassword" type="password" class="form-control bg-light" placeholder="Huidig Wachtwoord">
                            <span class="input-group-text bg-light" id="basic-addon1"><span id="toggleCurPassword" class="pointer material-icons ml-8 mr-8 verticalmid">visibility_off</span></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 bg-white">
                        <div class="input-group w-lg-50 mb-3 pb-2">
                            <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">lock</span></span>
                            <input name="newpassword" id="newpassword" type="password" class="form-control bg-light" placeholder="Nieuw Wachtwoord">
                            <span class="input-group-text bg-light" id="basic-addon1"><span id="toggleNewPassword" class="pointer material-icons ml-8 mr-8 verticalmid">visibility_off</span></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 bg-white">
                        <div class="input-group w-lg-50 mb-3 pb-2">
                            <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">lock</span></span>
                            <input name="newpassword2" id="newpassword2" type="password" class="form-control bg-light" placeholder="Herhaal Wachtwoord">
                            <span class="input-group-text bg-light" id="basic-addon1"><span id="toggleRepeatPassword" class="pointer material-icons ml-8 mr-8 verticalmid">visibility_off</span></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="bg-white">
                        <div class="col-lg-9 col-12 w-lg-50">
                            <input class="bg-danger border-0 rounded text-light p-1 mb-3 float-end" name="save" type="submit" value="Opslaan">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="bottom">
        <?php include_once("../components/footer.php"); ?>
    </div>
    <script src="../assets/js/profile.js"></script>
</body>

</html>