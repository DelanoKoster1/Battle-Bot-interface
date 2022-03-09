<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        include_once('../components/head.html');
        include_once('../functions/function.php');
    ?>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="styleshsseet" href="../assets/css/footer.css">

    <title>Registreren</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>

    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="username">Username</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="e-mail">E-mail</label><br>
        <input type="text" id="email" name="email" required><br>
        <label for="password">Password</label><br>
        <input type="text" id="password" name="password" required><br><br>
        <input type="submit" name="submit" value="submit">
        <a href="Login.php">Login now</a>
    </form>
</body>

</html>