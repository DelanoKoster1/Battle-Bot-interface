<?php
//Includes
include_once('../functions/function.php');

//Check if user is logged
if (isset($_SESSION['email'])) {
    header('location: ../components/error.php');
}

//Define global variable(s)
$error = array();

//Check if submitted login
if (isset($_POST['login'])) {
    //Submitted form data validation
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    //Check form data fields
    if (!checkLoginFields($username, $password)) {
        //SQL query to select all from user where the username is ...
        $sql = "SELECT  id, 
                        roleId, 
                        username, 
                        password, 
                        email 
                FROM    account 
                WHERE   username = ?";

        //Get results from the database
        $results = stmtExec($sql, 0, $username);

        //Check if no result has been found
        if (is_array($results) && count($results) > 0) {
            //Set password value
            $dbPassword = $results['password'][0];

            //Check password
            if (password_verify($password, $dbPassword)) {
                //Set other values
                $email = $results['email'][0];
                $role = $results['roleId'][0];
                $id = $results['id'][0];

                //Put value's in session
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;
                $_SESSION['id'] = $id;

                header('location: ../index.php');
                exit();
            } else {
                $error[] = 'Deze inloggegevens zijn incorrect!';
            }
        } else {
            $error[] = 'Er is geen gebruiker gevonden met deze gebruikersnaam!';
        }
    }

    if (!empty($error)) {
        $_SESSION['ERROR_MESSAGE'] = $error;
    }
}

//Check if submitted
if (isset($_POST['register'])) {
    //Submitted form data validation
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_SPECIAL_CHARS);
    $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_SPECIAL_CHARS);

    //Check form data fields
    if (!checkRegisterFields($username, $email, $password, $password2)) {
        if (!checkUserInDataBase($username, $email)) {
            //Hash the password before putting in database
            $password = password_hash($password, PASSWORD_DEFAULT);

            //Define standard role, user
            $role = 1;
            $teamid = 0;

            //SQL Query for inserting into user table
            $sql = "INSERT INTO account (
                                teamId, 
                                roleId, 
                                username, 
                                password, 
                                email) 
                    VALUES      (?,?,?,?,?)";

            if (!stmtExec($sql, 0, $teamid, $role, $username, $password, $email)) {
                $_SESSION['error'] = "Er is iets misgegaan bij het aanmaken van het account, probeer het opnieuw!";
                header("location: ../components/error.php");
            }

            $sql = "SELECT  id 
                    FROM    account 
                    WHERE   username = ?";
            $result = stmtExec($sql, 0, $username);
            $lastInsertedID = $result["id"][0];

            // log user in
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            $_SESSION['id'] = $lastInsertedID;

            //Send user to index.php
            header('location: ../index.php');
            exit();
        }
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
    <link rel="stylesheet" href="../assets/css/loginregister.css">
    <title>Inloggen - Battlebots</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>

    <section id="content" class="container mb-3">
        <div class="height">
            <div class="row">
                <div class="col-md-12 text-center mt-2">
                    <h1>Inloggen / Registreren</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 text-center mt-2">
                    <?php
                    if (isset($_POST['login']) && !empty($_SESSION['ERROR_MESSAGE'])) {
                    ?>
                        <div class="row">
                            <div class="col-md-12 p-0">
                                <div class="alert alert-danger text-black fw-bold p-4 rounded mb-3" role="alert">
                                    <ul>
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

                    <div class="box row rounded">
                        <div class="col-md-12">
                            <h2 class="form-heading mt-3">Inloggen</h2>
                            <form class="mb-3" action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                                <div class="form-group">
                                    <input class="form-control mt-2" placeholder="Gebruikersnaam" type="text" name="username" value="<?php if (isset($_POST['login'])) {echo htmlentities($_POST['username']);} ?>">
                                    <input class="form-control mt-3" placeholder="Wachtwoord" type="password" name="password">
                                    <input class="btn btn-danger mt-3" type="submit" name="login" value="Inloggen">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 text-center mt-2">
                    <?php
                    if (isset($_POST['register']) && !empty($_SESSION['ERROR_MESSAGE'])) {
                    ?>
                        <div class="row">
                            <div class="col-md-12 p-0">
                                <div class="alert alert-danger text-black fw-bold p-4 rounded mb-3" role="alert">
                                    <ul>
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

                    <div class="box row rounded">
                        <div class="col-md-12">
                            <h2 class="form-heading mt-3">Registreren</h2>
                            <form class="mb-3" action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                                <div class="form-group">
                                    <input class="form-control mt-2" placeholder="Gebruikersnaam" type="text" name="username" value="<?php if (isset($_POST['register'])) {echo htmlentities($_POST['username']);} ?>">
                                    <input class="form-control mt-3" placeholder="E-mail" type="email" name="email" value="<?php if (isset($_POST['register'])) {echo htmlentities($_POST['email']);} ?>">
                                    <input class="form-control mt-3" placeholder="Wachtwoord" type="password" name="password1">
                                    <input class="form-control mt-3" placeholder="Wachtwoord bevestigen" type="password" name="password2">
                                    <input class="btn btn-danger mt-3" type="submit" name="register" value="Registreren">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <section id="footer">
        <?php include_once('../components/footer.php') ?>
    </section>
</body>

</html>