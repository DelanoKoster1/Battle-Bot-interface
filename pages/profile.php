<?php
include_once('../functions/function.php');

if (!isset($_SESSION['email'])) {
    header('location: ../components/error.php');
}

if (isset($_POST['save'])) {
    if (!empty($_POST['username'])) {
        if (!empty($_POST['email'])) {
            if (!empty($_POST['password'])) {
                if (!empty($_POST['rpassword'])) {
                    if ($username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                        if ($password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                            if ($rpassword = filter_input(INPUT_POST, "rpassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                                if ($password == $rpassword) {
                                    if ($email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)) {
                                        $stmt = mysqli_prepare($conn, "
                                                UPDATE account
                                                SET username = ?,
                                                    password = ?,                               
                                                    email = ?
                                        ") or die(mysqli_error($conn));
                                        mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $password);
                                        mysqli_stmt_execute($stmt) or die(mysqli_error($conn));
                                        mysqli_stmt_close($stmt);
                                    }
                                }
                            } 
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
                            <h1 class="text-center bg-white w-100 pt-5 pb-5">Welkom, <?php echo $_SESSION['username']?></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">person</span></span>
                                <input name="username" type="text" class="form-control bg-light" placeholder="Gebruikersnaam"  value="<?php echo $_SESSION['username']?>" aria-label="username" aria-describedby="basic-addon1">                                   
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">email</span></span>
                                <input name="email" type="email" class="form-control bg-light" placeholder="Email"  value="<?php echo $_SESSION['email']?>" aria-label="email" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">lock</span></span>
                                <input name="password" id="password" type="password" class="form-control bg-light" placeholder="Wachtwoord"  value="" aria-label="password" aria-describedby="basic-addon1">
                                <span class="input-group-text bg-light" id="basic-addon1"><span id="togglePassword" class="pointer material-icons ml-8 mr-8 verticalmid">visibility_off</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-white">
                            <div class="input-group w-lg-50 mb-3 pb-2">
                                <span class="input-group-text bg-light" id="basic-addon1"><span class="material-icons ml-8 mr-8 verticalmid">lock</span></span>
                                <input name="rpassword" id="rpassword" type="password" class="form-control bg-light" placeholder="Herhaal Wachtwoord"  value="" aria-label="rpassword" aria-describedby="basic-addon1">
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

            togglePassword.addEventListener('click', function (e) {
                if (isVisible == false) {
                    isVisible = true;
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