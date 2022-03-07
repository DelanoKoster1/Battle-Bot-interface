<?php //includeonce("../components/header.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Battle Bots
        </title>
        <link rel="stylesheet" href="../assets/css/login.css">
    </head>
    <body>
        <div class="flex">
            <img class="w60 m0" src="../assets/img/nhlstenden.jpg">
            <form class="center " method="post" action="">
                <h1 class="textcenter mb-4">Login</h1>
                <div class="mb-2">
                    <input class="inputlogin" type="text" name="username" placeholder="Username">
                </div>
                <div class="mb-2">
                    <input class="inputlogin" type="text" name="password" placeholder="Password_">
                </div>
                <div class="mb-2 flex ">
                    <input class="mr-2" type="checkbox" name="remember">
                    <label class="mr-4">Remember me</label>
                    <p class="ml-4">Don't have an account?<br>
                        <a href="register.php">
                            Register here
                        </a><br>
                    </p>
                </div>
                <input class="inputlogin backblue white bold" type="submit" name="login" value="Login >">
            <form>
        </div>
        <?php include_once('../components/footer.php') ?>
    </body>
</html>