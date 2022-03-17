<?php
include_once('../functions/function.php');
require_once("../functions/database.php");

$conn = connectDB();
$query = "SELECT username, password, email FROM `account` WHERE id =" . $_SESSION['id'];
$results = stmtExec($query, 0, $_SESSION['id']);
    
if (!isset($_SESSION['email'])) {
    header('location: ../components/error.php');
}
if (!empty($_POST['password']) && empty($_POST['rpassword']) || empty($_POST['password']) && !empty($_POST['rpassword'])) {
    echo "passwords don't match, try again";
}
if (isset($_POST['save'])) {
    // Only username
    if (!empty($_POST['username']) && empty($_POST['password']) && empty($_POST['rpassword']) && empty($_POST['email'])) {
        if ($username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            $query = "UPDATE `account` SET username = ? WHERE id = ?";
            $results = stmtExec($query, 0, $username, $_SESSION['id']);
            echo "Succes username";
        } else {
            echo "user filter";
        }
    // Only email
    } elseif (!empty($_POST['email']) && empty($_POST['password']) && empty($_POST['rpassword']) && empty($_POST['username'])) {
        if ($email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)) {
            $query = "UPDATE `account` SET email = ? WHERE id = ?";
            $results = stmtExec($query, 0, $email, $_SESSION['id']);
            echo "Succes email";
        } else {
            echo "email filter";
        }
    // Only passwords
    } elseif (!empty($_POST['password']) && !empty($_POST['rpassword']) && empty($_POST['email']) && empty($_POST['username'])) {
        if ($_POST['password'] == $_POST['rpassword']) {
            if ($password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                if ($rpassword = filter_input(INPUT_POST, "rpassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $query = "UPDATE `account` SET password = ? WHERE id = ?";
                    $results = stmtExec($query, 0, $password, $_SESSION['id']);
                    echo "Succes password";
                } else {
                    echo "rpassword filter";
                }
            } else {
                echo "password filter";
            }
        } else {
            echo "passwords don't match";
        }
    // Username and email
    } elseif (!empty($_POST['username']) && !empty($_POST['email']) && empty($_POST['password']) && empty($_POST['rpassword'])) {
        if ($username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            if ($email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)) {
                $query = "UPDATE `account` SET username = ?, email = ? WHERE id = ?";
                $results = stmtExec($query, 0, $username, $email, $_SESSION['id']);
                echo "Succes username & email";
            } else {
                echo "email filter";
            }
        } else {
            echo "username filter";
        }
    // Username & passwords
    } elseif (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['rpassword']) && empty($_POST['email'])) {
        if ($username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            if ($password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                if ($rpassword = filter_input(INPUT_POST, "rpassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $query = "UPDATE `account` SET username = ?, password = ? WHERE id = ?";
                    $results = stmtExec($query, 0, $username, $password, $_SESSION['id']);
                    echo "Succes username & passwords";
                } else {
                    echo "rpassword filter";
                }
            } else {
                echo "password filter";
            }
        } else {
            echo "username filter";
        }
    // Email & passwords
    } elseif (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['rpassword']) && empty($_POST['username'])) {
        if ($email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)) {
            if ($password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                if ($rpassword = filter_input(INPUT_POST, "rpassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $query = "UPDATE `account` SET email = ?, password = ? WHERE id = ?";
                    $results = stmtExec($query, 0, $email, $password, $_SESSION['id']);
                    echo "Succes email & passwords";
                } else {
                    echo "rpassword filter";
                }
            } else {
                echo "password filter";
            }
        } else {
            echo "email filter";
        }
    } else {
        if ($username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            if ($email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)) {
                if ($password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                    if ($rpassword = filter_input(INPUT_POST, "rpassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        $query = "UPDATE `account` SET username = ?, email = ?, password = ? WHERE id = ?";
                        $results = stmtExec($query, 0, $username, $email, $password, $_SESSION['id']);
                        echo "Succes all";
                    } else {
                        echo "rpassword filter";
                    }
                } else {
                    echo "password filter";
                }
            } else {
                echo "email filter";
            }
        } else {
            echo "username filter";
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
                            <h1 class="text-center bg-white w-100 pt-5 pb-5">Welkom, <?php //echo $username?></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">person</span></span>
                                <input name="username" type="text" class="form-control bg-light" placeholder="Gebruikersnaam"  value="<?php //echo $username?>" aria-label="username" aria-describedby="basic-addon1">                                   
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">email</span></span>
                                <input name="email" type="email" class="form-control bg-light" placeholder="Email"  value="<?php // echo $email?>" aria-label="email" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">lock</span></span>
                                <input name="password" id="password" type="password" class="form-control bg-light" placeholder="Wachtwoord" aria-label="password" aria-describedby="basic-addon1">
                                <span class="input-group-text bg-light" id="basic-addon1"><span id="togglePassword" class="pointer material-icons ml-8 mr-8 verticalmid">visibility_off</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">lock</span></span>
                                <input name="rpassword" id="rpassword" type="password" class="form-control bg-light" placeholder="Herhaal Wachtwoord" aria-label="rpassword" aria-describedby="basic-addon1">
                                <span class="input-group-text bg-light" id="basic-addon1"><span id="toggleRPassword" class="pointer material-icons ml-8 mr-8 verticalmid">visibility_off</span></span>
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
        <script>
            // Selecting the fields
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            let isVisibleRep = false;
            togglePassword.addEventListener('click', function (e) {
                if (isVisibleRep == false) {
                    isVisibleRep = true;
                    document.getElementById("togglePassword").textContent = "visibility";
                } else {
                    isVisible = false;
                    document.getElementById("togglePassword").textContent = "visibility_off";
                }
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
            });

            // Selecting the fields
            const toggleRPassword = document.querySelector('#toggleRPassword');
            const rpassword = document.querySelector('#rpassword');

            let isVisible = false;
            toggleRPassword.addEventListener('click', function (e) {
                if (isVisible == false) {
                    isVisible = true;
                    document.getElementById("toggleRPassword").textContent = "visibility";
                } else {
                    isVisible = false;
                    document.getElementById("toggleRPassword").textContent = "visibility_off";
                }
                const type = rpassword.getAttribute('type') === 'password' ? 'text' : 'password';
                rpassword.setAttribute('type', type);
            });
        </script>
    </body>
</html>

