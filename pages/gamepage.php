<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        include_once('../components/head.html');
        include_once('../functions/function.php');
    ?>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/gamepage.css">

    <title>gamepage</title>
</head>

<body>
    <?php include_once('../components/header.php'); ?>

    <div class="container">
        <h4 style="text-align: center; margin: 10px; padding: 10px;">Robots</h4>
        <div class="row">
            <div class="col-md-2">
                <div class="game">
                    <div class="underText">
                        <span>mooi plaatje/icoontje</span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="game">
                    <div class="underText">
                        <span>mooi plaatje/icoontje</span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="game">
                    <div class="underText">
                        <span>mooi plaatje/icoontje</span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="game">
                    <div class="underText">
                        <span>mooi plaatje/icoontje</span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="game">
                    <div class="underText">
                        <span>mooi plaatje/icoontje</span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="game">
                    <div class="underText">
                        <span>mooi plaatje/icoontje</span>
                    </div>
                </div>
            </div>
        </div>

        <?php for ($row = 0; $row < 5; $row++) { ?>
            <div class="row">
                <h3 style="padding: 10px; margin: 10px;">robot (*).</h3>
                <div class="col-md-2">
                    <div class="game">
                        <div class="underText">
                            <span>mooi plaatje/icoontje</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="game">
                        <div class="underText">
                            <span>mooi plaatje/icoontje</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="game">
                        <div class="underText">
                            <span>mooi plaatje/icoontje</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="game">
                        <div class="underText">
                            <span>mooi plaatje/icoontje</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="game">
                        <div class="underText">
                            <span>mooi plaatje/icoontje</span>
                        </div>
                    </div>  
                </div>
                <div class="col-md-2">
                    <div class="game">
                        <div class="underText">
                            <span>mooi plaatje/icoontje</span>
                        </div>
                    </div>  
                </div>
            </div>
        <?php } ?>
    </div>

    <footer>
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>