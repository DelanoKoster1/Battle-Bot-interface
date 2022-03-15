<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        include_once('../components/head.html');
        include_once('../functions/function.php');
    ?>

    <link rel="stylesheet" href="../assets/css/style.css">  
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/robots.css">


    <title>Admin Panel</title>
</head>

<body>
    <section id="header">
        <?php includeheader('page'); ?>
    </section>

    <div class="container">
        <div class="row my-5 justify-content-center">
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="box bg-secondary d-flex justify-content-center">
                    <div class="row g-0 w-100 text-center">
                        <div class="col-12 pt-1">
                            <img src="../assets/img/arrow.svg" alt="Logo of a bot" class="h-100">
                        </div>
                        <div class="col-12 position-relative">
                            <div class="botName position-absolute w-100 bottom-0">
                                <span>Start Game</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php for($count = 1; $count < 5; $count++) { ?>
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="box bg-secondary d-flex justify-content-center">
                    <div class="row g-0 w-100 text-center">
                        <div class="col-12 pt-1">
                            <img src="../assets/img/game.svg" alt="Logo of a bot">
                        </div>
                        <div class="col-12 position-relative">
                            <div class="botName position-absolute w-100 bottom-0">
                                <span>Game <?= $count ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <?php for($rowCount = 1; $rowCount <= 5; $rowCount++) { ?>
        <div class="row my-5 justify-content-center">
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="box bg-secondary d-flex justify-content-center">
                    <div class="row g-0 w-100 text-center">
                        <div class="col-12 pt-1">
                            <img src="../assets/img/bot.svg" alt="Logo of a bot">
                        </div>
                        <div class="col-12 position-relative">
                            <div class="botName position-absolute w-100 bottom-0">
                                <span>Bot <?= $rowCount ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php for($colCount = 1; $colCount < 5; $colCount++) { ?>
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="box bg-secondary d-flex justify-content-center">
                    <div class="row g-0 w-100 text-center">
                        <div class="col-12 pt-1">
                            <img src="../assets/img/game.svg" alt="Logo of a bot">
                        </div>
                        <div class="col-12 position-relative">
                            <div class="botName position-absolute w-100 bottom-0">
                                <span>Start Game <?= $colCount ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>


    <footer>
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>