<?php
if (isset($_POST['save'])) {
    if ($id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT)) {
        if ($team_id = filter_input(INPUT_POST, 'team_id', FILTER_SANITIZE_NUMBER_INT)) {
            if ($role_id = filter_input(INPUT_POST, 'role_id', FILTER_SANITIZE_NUMBER_INT)) {
                if ($username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                    if ($password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                        if ($email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)) {
                            $stmt = mysqli_prepare($conn, "
                                    UPDATE account
                                    SET id = ?,
                                        team_id = ?,
                                        role_id = ?,
                                        username = ?,
                                        password = ?,
                                        email = ?
                                    WHERE user_id = ?                                   
                            ") or die(mysqli_error($conn));
                            mysqli_stmt_bind_param($stmt, 'iiisss', $id, $team_id, $role_id, $username, $password, $email);
                            mysqli_stmt_execute($stmt) or die(mysqli_error($conn));
                            mysqli_stmt_close($stmt);
                        }
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include_once('../components/head.html');
        include_once('../functions/function.php');
        ?>
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
                            <h1 class="text-center bg-white w-100 pt-5 pb-5">Welkom, John! <?php //echo $_SESSION['username']?></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">person</span></span>
                                <input type="text" class="form-control bg-light" placeholder="Gebruikersnaam"  value="<?php //echo $_SESSION['username']?>" aria-label="Username" aria-describedby="basic-addon1">                                   
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12  bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">email</span></span>
                                <input type="text" class="form-control bg-light" placeholder="Email"  value="<?php //echo $_SESSION['email']?>" aria-label="Email" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">lock</span></span>
                                <?php 
                                if (isset($_GET['visible'])) { ?>
                                    <input type="text" class="form-control bg-light" placeholder="Wachtwoord"  value="<?php //echo $_SESSION['password']?>" aria-label="Password" aria-describedby="basic-addon1">
                                    <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid"><a name="visible" href="profile.php" class="text-decoration-none text-dark">visibility</a></span></span>
                                    <?php
                                } else { ?>
                                    <input type="password" class="form-control bg-light" placeholder="Wachtwoord"  value="<?php //echo $_SESSION['password']?>" aria-label="Password" aria-describedby="basic-addon1">
                                    <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid"><a name="novisibility" href="profile.php?visible" class="text-decoration-none text-dark">visibility_off</a></span></span>
                                    <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">lock</span></span>
                                <?php 
                                if (isset($_GET['visible_'])) { ?>
                                <input type="text" class="form-control bg-light" placeholder="Herhaal Wachtwoord"  value="<?php //echo $_SESSION['password']?>" aria-label="Password" aria-describedby="basic-addon1">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid"><a name="visible" href="profile.php" class="text-decoration-none text-dark">visibility</a></span></span>
                                <?php
                                } else { ?>
                                    <input type="password" class="form-control bg-light" placeholder="Herhaal Wachtwoord"  value="<?php //echo $_SESSION['password']?>" aria-label="Password" aria-describedby="basic-addon1">
                                    <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid"><a name="novisibility" href="profile.php?visible_" class="text-decoration-none text-dark">visibility_off</a></span></span>
                                    <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group justify-content-center w-lg-50">
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
    </body>
</html>