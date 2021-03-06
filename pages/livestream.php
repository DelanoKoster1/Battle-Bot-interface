<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('../functions/function.php');
    includeHead('page');
    ?>
    <link href="../assets/img//logo/logo.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/playback.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/robots.css">

    <title>Livestream - Battlebots</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>

    <?php
    if (isset($_POST['submitAnswer'])) {
        if (!empty($_POST['questionAnswer'])) {
            pollQuestionAnswer();
            pollAddUser($_SESSION['username'], $_POST['questionAnswer']);
        }
    }
    ?>
    <div class="container-fluid my-5">
        <div class="row">
            <div id="livestream" class="col-xl-9 col-lg-8 col-12">
                <div class="ratio ratio-16x9">
                    <?= getLivestream(); ?>
                </div>
            </div>
            <div id="chat" class="col-xl-3 col-lg-4 col-12 mt-4 mt-lg-0">
                <div class="row h-100">
                    <div class="col-12">
                        <div id="chatbox" class="chatbox h-100 collapsed collapse-horizontal">
                            <div class="card h-100 posistion-relative">
                                <div class="card-header text-center">
                                    <span class="fw-bold">
                                        Chat
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="chatmessage-container h-75">
                                    </div>

                                    <div class="commandLine position-absolute bottom-0 start-0">
                                        <div class="row">
                                            <?php if (isset($_SESSION['username'])) {
                                            ?>
                                                <div class="col-12">
                                                    <div class="input-group mb-3">

                                                        <input type="text" class="form-control" placeholder="Type uw bericht" aria-label="Type uw bericht" id="chatMessage" aria-describedby="button-addon2">
                                                        <input type="hidden" id="username" value='<?php echo $_SESSION['username'] ?>'>
                                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><span class="material-icons align-middle">send</span></button>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-between mb-3 buttons-group">
                                                    <div class="btn w-33 btn-success">1000</div>
                                                    <a href="./points.php" class="btn text-right btn-success">Scorebord</a>
                                                    <button class="btn text-right btn-success vote-button">Stemmen</button>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-12">
                                                    <p>Log in om te kunnen chatten</p>
                                                </div>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close btn btn-success" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true">X</span></button>
                    <h4 class="modal-title custom_align" id="Heading">Stem Nu!</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="formBot" action="">
                        <div class="custom-control custom-radio">
                            <?php echo retrieveQuestionInfo(); ?>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="submit" form="formBot" name="submitAnswer" class="btn btn-warning btn-lg w-100" value="stem nu!">
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <h3>Doet de livestream het niet?</h3>
        <a target="_blank" href="https://www.twitch.tv/stendenbattlebot">
            <h6>Klik hier!</h6>
        </a>
    </div>
    <footer>
        <?php include_once('../components/footer.php') ?>
    </footer>
    <script>
        $(document).ready(function() {
            $("button.vote-button").click(function() {
                $("#modalEdit").modal("show");
            });
            $("button.close").click(function() {
                $("#modalEdit").modal("hide");
            });
        });
    </script>
    <script src="../assets/js/functions.js"></script>
    <script src="../assets/js/chat.js"></script>
</body>

</html>