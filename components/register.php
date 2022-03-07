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