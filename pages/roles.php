<?php
include_once('../functions/function.php');

global $error;

if (!isset($_SESSION['email'])) {
    header('location: ../components/error.php');
}

if ($_SESSION['role'] == 1 || $_SESSION['role'] == 3) {
    header('location: ../components/error.php');
}

if (isset($_POST['toAdmin'])) {
    $id = filter_input(INPUT_POST, 'toAdmin', FILTER_SANITIZE_NUMBER_INT);
    $query = "UPDATE    account 
              SET       roleId = 2 
              WHERE     id = ?";
    if (stmtExec($query, 0, $id)) {
        $_SESSION['succes'] = "De rol is succesvol aangepast naar Admin!";
    } else {
        $_SESSION['ERROR_MESSAGE'] = "De rol kon niet aangepast worden, probeer het opnieuw!";
    }
}

if (isset($_POST['toUser'])) {
    $id = filter_input(INPUT_POST, 'toUser', FILTER_SANITIZE_NUMBER_INT);
    $query = "UPDATE    account 
              SET       roleId = 1 
              WHERE     id = ?";
    if (stmtExec($query, 0, $id)) {
        $_SESSION['succes'] = "De rol is succesvol aangepast naar Gebruiker!";
    } else {
        $_SESSION['ERROR_MESSAGE'] = "De rol kon niet aangepast worden, probeer het opnieuw!";
    }
}

if (isset($_POST['toTeam'])) {
    $id = filter_input(INPUT_POST, 'toTeam', FILTER_SANITIZE_NUMBER_INT);
    $query = "UPDATE    account
              SET       roleId = 3
              WHERE     id = ?
            ";
    if (stmtExec($query, 0, $id)) {
        $_SESSION['succes'] = "De rol is succesvol aangepast naar Team!";
    } else {
        $_SESSION['ERROR_MESSAGE'] = "De rol kon niet aangepast worden, probeer het opnieuw!";
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
    <title>Rollen - Battlebots</title>
</head>

<body>
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
            <div class="col-md-2"></div>
            <form class="col-md-12 col-12 bg-white" method="post">
                <h1 class="text-center">Rol aanpassen</h1>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="align-middle">ID</td>
                                <td class="align-middle">Username</td>
                                <td class="align-middle">Huidige rol</td>
                                <td class="align-middle">Gebruiker</td>
                                <td class="align-middle">Admin</td>
                                <td class="align-middle">Team</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT    id, 
                                                username, 
                                                roleId 
                                      FROM        account 
                                      WHERE       roleId
                                     ";
                            $results = stmtExec($query);
                            $ids = $results['id'];
                            foreach ($ids as $key => $id) {
                            ?>
                                <tr>
                                    <td class="align-middle"><?= $id ?></td>
                                    <td class="align-middle"><?= $results['username'][$key] ?></td>
                                    <?php
                                    if ($results['roleId'][$key] == 1) {
                                    ?>
                                        <td class="align-middle">Gebruiker</td>
                                    <?php
                                    } elseif ($results['roleId'][$key] == 3) {
                                    ?>
                                        <td class="align-middle">Team</td>
                                    <?php
                                    } else {
                                    ?>
                                        <td class="align-middle">Admin</td>
                                    <?php
                                    }
                                    ?>
                                    <td class="align-middle"><button class="btn btn-success" type="submit" name="toUser" value="<?= $id ?>">Gebruiker</button></td>
                                    <td class="align-middle"><button class="btn btn-primary" type="submit" name="toAdmin" value="<?= $id ?>">Admin</button></td>
                                    <td class="align-middle"><button class="btn btn-danger" type="submit" name="toTeam" value="<?= $id ?>">Team</button></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
    <div>
        <?php include_once("../components/footer.php"); ?>
    </div>
</body>

</html>