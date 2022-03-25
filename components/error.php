<?php
include_once('../functions/function.php');

switch (isset($_SESSION['error'])) {
    case 'database_error':
        $errormessage = 'Database error';
        unset($_SESSION['error']);
        break;

    case 'database_connect_error':
        $errormessage = 'Database connection error';
        unset($_SESSION['error']);
        break;

    default:
        $errormessage = '404';
        break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('head.php');
    ?>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/error.css">

    <title><?php echo $errormessage; ?></title>
</head>

<body>
    <section id="error">
        <div class="page-wrap d-flex flex-row align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        <i class="fas fa-robot fs10em"></i>
                        <span class="display-1 d-block text-uppercase"><?php echo $errormessage; ?></span>
                        <div class="mb-4 lead">Neem contact op met de beheerder.</div>
                        <a href="../index.php" class="btn btn-link">Terug naar de homepagina</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>