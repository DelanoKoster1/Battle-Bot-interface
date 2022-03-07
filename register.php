<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>

</head>

<body>
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