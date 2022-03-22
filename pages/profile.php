<?php
include_once('../functions/function.php');

global $error;

$conn = connectDB();
$query = "SELECT username, password, email FROM `account` WHERE id =" . $_SESSION['id'];
$results = stmtExec($query, 0, $_SESSION['id']);

if (!isset($_SESSION['email'])) {
    header('location: ../components/error.php');
}
if (!empty($_POST['password']) && empty($_POST['newpassword']) || empty($_POST['rpassword']) && !empty($_POST['rpassword'])) {
    $error[] =  'De wachtwoorden komen niet overeen';
}
$query = "SELECT username, email, password FROM `account` WHERE id = ?";
$results = stmtExec($query, 0, $_SESSION['id']);
$username = $results["username"][0];
$email = $results["email"][0];
$password = $results["password"][0];
$hash = $password;

if (isset($_POST['save'])) {
    if (!empty($_POST['username'])) {
        if (!empty($_POST['email'])) {
            if (!empty($_POST['curpassword'])) {
                if (!empty($_POST['newpassword']) && !empty($_POST['rpassword'])) {
                    if ($username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                        if ($email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)) {
                            if ($curPassword = filter_input(INPUT_POST, "curpassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                                if (password_verify($curPassword, $hash)) {
                                    if ($newPassword = filter_input(INPUT_POST, "newpassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                                        if ($rpassword = filter_input(INPUT_POST, "rpassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                                            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                                            $query = "UPDATE `account` SET username = ?, email = ?, password = ? WHERE id = ?";
                                            stmtExec($query, 0, $username, $email, $newPassword, $_SESSION['id']);
                                            echo "<div class='alert alert-success text-black mb-0 p-4 fw-bold'>De gegevens zijn succesvol aangepast</div>";
                                        } else {
                                            $error[] = 'Het herhaal wachtwoord is ongeldig';
                                        }
                                    } else {
                                        $error[] = 'Het nieuwe wachtwoord is ongeldig';
                                    }
                                } else {
                                    $error[] = 'Het huidige wachtwoord klopt niet';
                                }
                            } else {
                                $error[] = 'Het huidige wachtwoord is ongeldig';
                            }
                        } else {
                            $error[] = 'Het e-mailadres is ongeldig';
                        }
                    } else {
                        $error[] = 'De gebruikersnaam is ongeldig';
                    }
                } elseif (empty($_POST['newpassword']) && empty($_POST['rpassword'])) {
                    if ($username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                        if ($email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)) {
                            if ($curPassword = filter_input(INPUT_POST, "curpassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                                if (password_verify($curPassword, $hash)) {
                                    $query = "SELECT username FROM `account` WHERE NOT id = ?";
                                    $results = stmtExec($query, 0, $username, $_SESSION['id']);  
                                    $curPassword = password_hash($curPassword, PASSWORD_DEFAULT);
                                    $query = "UPDATE `account` SET username = ?, email = ?, password = ? WHERE id = ?";
                                    stmtExec($query, 0, $username, $email, $curPassword, $_SESSION['id']);
                                    echo "<div class='alert alert-success text-black mb-0 p-4 fw-bold'>De gegevens zijn succesvol aangepast</div>";
                                } else {
                                    $error[] = 'Het huidige wachtwoord klopt niet';
                                }
                            } else {
                                $error[] = 'Het huidige wachtwoord is ongeldig';
                            }
                        } else {
                            $error[] = 'Het e-mailadres is ongeldig';
                        }
                    } else {
                        $error[] = 'De gebruikersnaam is ongeldig';
                    }
                } else {
                    $error[] = 'Het nieuwe wachtwoord en het herhaal wachtwoord komen niet overeen';
                }
            } else {
                $error[] = 'De huidige wachtwoord mag niet leeg zijn';
            }
        } else {
            $error[] = 'Het e-mailadres mag niet leeg zijn';
        }
    } else {
        $error[] = 'De gebruikersnaam mag niet leeg zijn';
    }
    if (isset($_POST['save']) && !empty($error)) {
        foreach ($error as $errorMsg) { ?>
            <div class="col-md-12 p-0">
                <div class="alert alert-danger text-black fw-bold p-4 mb-0 rounded" role="alert">
                    <?php echo $errorMsg; ?>
                </div>
            </div><?php
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
                            <h1 class="text-center bg-white w-100 pt-5 pb-5">Welkom, <?php echo $username?></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">person</span></span>
                                <input name="username" type="text" class="form-control bg-light" placeholder="Gebruikersnaam"  value="<?php echo $username?>" aria-label="username" aria-describedby="basic-addon1">                                   
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">email</span></span>
                                <input name="email" type="email" class="form-control bg-light" placeholder="Email"  value="<?php echo $email?>" aria-label="email" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">lock</span></span>
                                <input name="curpassword" id="curpassword" type="password" class="form-control bg-light" placeholder="Huidig Wachtwoord" aria-label="curpassword" aria-describedby="basic-addon1">
                                <span class="input-group-text bg-light" id="basic-addon1"><span id="toggleCurPassword" class="pointer material-icons ml-8 mr-8 verticalmid">visibility_off</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">lock</span></span>
                                <input name="newpassword" id="newpassword" type="password" class="form-control bg-light" placeholder="Nieuw Wachtwoord" aria-label="newpassword" aria-describedby="basic-addon1">
                                <span class="input-group-text bg-light" id="basic-addon1"><span id="toggleNewPassword" class="pointer material-icons ml-8 mr-8 verticalmid">visibility_off</span></span>
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
            // Change eye icon for current password field
            const toggleCurPassword = document.querySelector('#toggleCurPassword');
            const curpassword = document.querySelector('#curpassword');

            let isVisibleCur = false;
            toggleCurPassword.addEventListener('click', function (e) {
                if (isVisibleCur == false) {
                    isVisibleCur = true;
                    document.getElementById("toggleCurPassword").textContent = "visibility";
                } else {
                    isVisibleCur = false;
                    document.getElementById("toggleCurPassword").textContent = "visibility_off";
                }
                const type = curpassword.getAttribute('type') === 'password' ? 'text' : 'password';
                curpassword.setAttribute('type', type);
            });

            // Change eye icon for new password field
            const toggleNewPassword = document.querySelector('#toggleNewPassword');
            const newpassword = document.querySelector('#newpassword');

            let isVisibleNew = false;
            toggleNewPassword.addEventListener('click', function (e) {
                if (isVisibleNew == false) {
                    isVisibleNew = true;
                    document.getElementById("toggleNewPassword").textContent = "visibility";
                } else {
                    isVisibleNew = false;
                    document.getElementById("toggleNewPassword").textContent = "visibility_off";
                }
                const type = newpassword.getAttribute('type') === 'password' ? 'text' : 'password';
                newpassword.setAttribute('type', type);
            });

            // Change eye icon for repeat password field
            const toggleRPassword = document.querySelector('#toggleRPassword');
            const rpassword = document.querySelector('#rpassword');

            let isVisibleR = false;
            toggleRPassword.addEventListener('click', function (e) {
                if (isVisibleR == false) {
                    isVisibleR = true;
                    document.getElementById("toggleRPassword").textContent = "visibility";
                } else {
                    isVisibleR = false;
                    document.getElementById("toggleRPassword").textContent = "visibility_off";
                }
                const type = rpassword.getAttribute('type') === 'password' ? 'text' : 'password';
                rpassword.setAttribute('type', type);
            });
        </script>
    </body>
</html>

