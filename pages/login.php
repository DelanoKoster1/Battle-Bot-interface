<?php
//Includes
include_once('../functions/function.php');

//Check if user is logged
if (isset($_SESSION['email'])) {
    header('location: ../components/error.php');
}

//Call database connection
$conn = connectDB();

//Define global variable(s)
$error = array();

/**
 * Function checkLoginFields
 * Function to check if fields are correct and not empty.
 * Display Error message if needed.
 * @param String $username Filled in username
 * @param String $email Filled in email
 * @param String $password1 Filled in password
 * @param array $error Array with errors
 * @return String/boolean $error False or error message
 */
function checkLoginFields(String $username, String $password) {
    //Call global variable(s)
    global $error;

    //If statements so the error messages will be displayed all at once instead of each individual.
    if (!$username && empty($username)) {
        $error[] = 'Gebruikersnaam is niet correct!';
    }
    if (strlen($username) > 255) {
        $error[] = 'Gebruikersnaam is te lang!';
    }
    if (!$password && empty($password)) {
        $error[] = 'Wachtwoord mag niet leeg zijn!';
    }
    if (strlen($password) > 255) {
        $error[] = 'Wachtwoord is te lang!';
    }

    if (empty($error)) {
        return false;
    } else {
        return $error;
    }
}

//Check if submitted login
if (isset($_POST['login'])) {
    //Submitted form data validation
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    //Check form data fields
    if (!checkLoginFields($username, $password)) {
        //SQL query to select all from user where the username is ...
        $query = "SELECT * FROM account WHERE username = ?";

        //Prpeparing SQL Query with database connection
        $stmt = mysqli_prepare($conn, $query);
        if (!$stmt) {
            $_SESSION['error'] = "database_error";
            header("location: ../components/error.php");
        }

        //Binding params into ? fields
        if (!mysqli_stmt_bind_param($stmt, "s", $username)) {
            $_SESSION['error'] = "database_error";
            header("location: ../components/error.php");
        }

        //Executing statement
        if (!mysqli_stmt_execute($stmt)) {
            $_SESSION['error'] = "database_error";
            header("location: ../components/error.php");
        }

        //Bind the STMT results(sql statement) to variables
        mysqli_stmt_bind_result($stmt, $ID, $teamID, $role, $username, $password2, $email);

        //Fetch STMT data
        while (mysqli_stmt_fetch($stmt)) {
        }

        //Check if no result has been found
        if (mysqli_stmt_num_rows($stmt) > 0) {
            //Check password
            if (password_verify($password, $password2)) {
                //Put value's in session
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;
                $_SESSION['id'] = $ID;

                //Close the statement and connection
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                header('location: ../index.php');
                exit();
            } else {
                $error[] = 'Inloggegevens zijn incorrect.';
            }
        } else {
            $error[] = 'Geen gebruiker gevonden met deze gebruikersnaam.';
        }
    }
}

/**
 * Function checkRegisterFields.
 * Function to check if fields are correct and not empty.
 * Display Error message if needed.
 * @param string    $email  Filled in email
 * @param string    $firstname  Filled in firstname
 * @param string    $lastname  Filled in lastname
 * @param string    $password  Filled in password
 * @param string    $password2  Filled in password2
 * @param array     $error  Array with errors
 * @return string/boolean  $error  False or error message
 */
function checkRegisterFields(string $username, string $email, string $password, string $password2) {
    //Call global variable(s)
    global $error;

    //If statements so the error messages will be displayed all at once instead of each individual.
    if (!$username && empty($username)) {
        $error[] = 'Gebruikersnaam mag niet leeg zijn!';
    }
    if (!$email && empty($email)) {
        $error[] = 'Email is onjuist!';
    }
    if (!$password && empty($password)) {
        $error[] = 'Wachtwoord mag niet leeg zijn!';
    }
    if (!$password2 && empty($password2)) {
        $error[] = 'Wachtwoord herhalen mag niet leeg zijn!';
    }
    if ($password != $password2) {
        $error[] = 'Wachtwoorden komen niet overeen!';
    }
    if (strlen($email) > 255) {
        $error[] = 'E-mail is te lang!';
    }
    if (strlen($username) > 255) {
        $error[] = 'Gebruikersnaam is te lang!';
    }
    if (strlen($password) > 255) {
        $error[] = 'Wachtwoord is te lang!';
    }

    if (empty($error)) {
        return false;
    } else {
        return $error;
    }
}

/**
 * Function checkUserInDatabase
 * Function to check if user already exists in database
 * Return Error message if needed.
 * @param   string          $username  Filled in username
 * @return  string/boolean  $error  False or error message
 */
function checkUserInDataBase(mysqli $conn, string $username) {
    //Call global variable(s)
    global $error;

    //SQL Query for selecting all users where an email is in DB
    $query = "SELECT * FROM account WHERE username = ?";

    //Prpeparing SQL Query with database connection
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        $_SESSION['error'] = "database_error";
        header("location: ../components/error.php");
    }

    //Binding params into ? fields
    if (!mysqli_stmt_bind_param($stmt, "s", $username)) {
        $_SESSION['error'] = "database_error";
        header("location: ../components/error.php");
    }

    //Executing statement
    if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['error'] = "database_error";
        header("location: ../components/error.php");
    };

    //Bind the STMT results(sql statement) to variables
    mysqli_stmt_bind_result($stmt, $ID, $teamid, $roleid, $username, $password, $email);

    //Store STMT data
    mysqli_stmt_store_result($stmt);

    //Check if a result has been found with number of rows
    if (mysqli_stmt_num_rows($stmt) > 0) {
        while(mysqli_stmt_fetch($stmt)) {
            if($email == filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)) {
                $error[] = 'Er bestaat al een account met deze email';
            }
            if($username == filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS)) {
                $error[] = 'Er bestaat al een gebruiker met deze gebruikersnaam';
            }
        }
        mysqli_stmt_close($stmt);      
        return $error;
    } else {
        mysqli_stmt_close($stmt);
        return false;
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
        if (!checkUserInDataBase($conn, $username)) {
            //Hash the password before putting in database
            $password = password_hash($password, PASSWORD_DEFAULT);

            //Define standard role, user
            $role = 0;
            $teamid = 0;

            //SQL Query for inserting into user table
            $query = "INSERT INTO account (teamId, roleId, username, password, email) VALUES (?,?,?,?,?)";

            //Prpeparing SQL Query with database connection
            $stmt = mysqli_prepare($conn, $query);
            if (!$stmt) {
                $_SESSION['error'] = "database_error";
                header("location: ../components/error.php");
            }

            //Binding params into ? fields
            if (!mysqli_stmt_bind_param($stmt, "sssss", $teamid, $role, $username, $password, $email)) {
                $_SESSION['error'] = "database_error";
                header("location: ../components/error.php");
            }

            //Executing statement
            if (!mysqli_stmt_execute($stmt)) {
                mysqli_stmt_error($stmt);
                $_SESSION['error'] = "database_error";
                header("location: ../components/error.php");
            }

            // log user in
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            //Close the statement and connection
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

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
    include_once('../components/head.html');
    ?>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/loginregister.css">

    <title>Inlogscherm - Battlebots</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>

    <section id="content" class="container mb-3">
        <div class="row">
            <div class="col-md-12 text-center mt-2">
                <h1>Login/Register</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 text-center mt-2">
                <?php
                if (isset($_POST['login']) && !empty($error)) {
                ?>
                    <div class="row">
                        <div class="col-md-12 p-0">
                            <div class="alert alert-danger text-black fw-bold p-4 rounded mb-3" role="alert">
                                <ul>
                                    <?php
                                    foreach ($error as $errorMsg) {
                                        echo '<li>' . $errorMsg . '</li>';
                                    }
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
                                <input class="form-control mt-2" placeholder="Gebruikersnaam" type="text" name="username">
                                <input class="form-control mt-3" placeholder="Wachtwoord" type="password" name="password">
                                <input class="btn btn-danger mt-3" type="submit" name="login" value="Inloggen">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 text-center mt-2">
                <?php
                if (isset($_POST['register']) && !empty($error)) {
                ?>
                    <div class="row">
                        <div class="col-md-12 p-0">
                            <div class="alert alert-danger text-black fw-bold p-4 rounded mb-3" role="alert">
                                <ul>
                                    <?php
                                    foreach ($error as $errorMsg) {
                                        echo '<li>' . $errorMsg . '</li>';
                                    }
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
                        <h2 class="form-heading mt-3">Registeren</h2>
                        <form class="mb-3" action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="form-group">
                                <input class="form-control mt-2" placeholder="Gebruikersnaam" type="text" name="username">
                                <input class="form-control mt-3" placeholder="E-mail" type="email" name="email">
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