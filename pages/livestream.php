<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('../components/head.html');
    include_once('../functions/function.php');
    ?>

    <link rel="stylesheet" href="../assets/css/playback.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/robots.css">

    <title>Livestream - Battlebot</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>

    <div class="container-fluid my-5">
        <div class="row">
            <div id="livestream" class="col-xl-9 col-lg-8 col-12">
                <div class="ratio ratio-16x9">
                    <iframe id="ytplayer" type="text/html" src="https://www.youtube.com/embed/M7lc1UVf-VE?autoplay=1&origin=http://example.com" frameborder="0"></iframe>
                </div>
            </div>
            <div id="chat" class="col-xl-3 col-lg-4 col-12 mt-4 mt-lg-0">
                <div class="row h-100">
                    <div class="col-12">
                        <div id="chatbox" class="chatbox h-100 collsapse show collapse-horizontal">
                            <div class="card h-100 posistion-relative">
                                <div class="card-header text-center">
                                    <div data-bs-toggle="collapse" data-bs-target="#chatbox" aria-expanded="true" aria-controls="chatbox" class="btn btn-sm btn-outline-success float-start d-none d-lg-block">
                                        <span class="material-icons align-middle">keyboard_arrow_right </span>
                                    </div>
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
                                                <div class="col-12 d-flex justify-content-between mb-3">
                                                    <div class="btn w-33 btn-success">1000</div>
                                                    <button class="btn text-right btn-success">Scorebord</button>
                                                    <button class="btn text-right btn-success vote-button">Stemmen</button>
                                                </div>
                                            <?php } else {
                                            ?>
                                                  <div class="col-12">
                                                      <p>Login om te kunnen chatten</p>
                                                  </div>          
                                            <?php
                                            } ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div data-bs-toggle="collapse" id="openChatBtn" data-bs-target="#chatbox" aria-expanded="true" aria-controls="chatbox" class="btn d-none btn-sm btn-outline-success float-end">
                            <span class="material-icons align-middle">keyboard_arrow_left</span>
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true">X</span></button>
                    <h4 class="modal-title custom_align" id="Heading">Vote for your bot</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="row justify-content-evenly">
                            <div class="col-lg-4 col-sm-4 col-6 mb-2">
                                <div class="box bg-secondary d-flex justify-content-center">
                                    <div class="row g-0 w-100 text-center">
                                        <div class="col-12 pt-1">
                                            <img class="img-fluid" src="../assets/img/bot.svg" alt="Logo of a bot">
                                        </div>
                                        <div class="col-12 position-relative">
                                            <div class="botName position-absolute w-100 bottom-0">
                                                <span>Team (X)</span>
                                                <span><input type="checkbox" id="team(X)" name="voteTeam" value="team(X)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-6">
                                <div class="box bg-secondary d-flex justify-content-center">
                                    <div class="row g-0 w-100 text-center">
                                        <div class="col-12 pt-1">
                                            <img class="img-fluid" src="../assets/img/bot.svg" alt="Logo of a bot">
                                        </div>
                                        <div class="col-12 position-relative">
                                            <div class="botName position-absolute w-100 bottom-0">
                                                <span>Team (X)</span>
                                                <span><input type="checkbox" id="team(X)" name="voteTeam" value="team(X)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-6">
                                <div class="box bg-secondary d-flex justify-content-center">
                                    <div class="row g-0 w-100 text-center">
                                        <div class="col-12 pt-1">
                                            <img class="img-fluid" src="../assets/img/bot.svg" alt="Logo of a bot">
                                        </div>
                                        <div class="col-12 position-relative">
                                            <div class="botName position-absolute w-100 bottom-0">
                                                <span>Team (X)</span>
                                                <span><input type="checkbox" id="team(X)" name="voteTeam" value="team(X)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-6">
                                <div class="box bg-secondary d-flex justify-content-center">
                                    <div class="row g-0 w-100 text-center">
                                        <div class="col-12 pt-1">
                                            <img class="img-fluid" src="../assets/img/bot.svg" alt="Logo of a bot">
                                        </div>
                                        <div class="col-12 position-relative">
                                            <div class="botName position-absolute w-100 bottom-0">
                                                <span>Team (X)</span>
                                                <span><input type="checkbox" id="team(X)" name="voteTeam" value="team(X)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-6">
                                <div class="box bg-secondary d-flex justify-content-center">
                                    <div class="row g-0 w-100 text-center">
                                        <div class="col-12 pt-1">
                                            <img class="img-fluid" src="../assets/img/bot.svg" alt="Logo of a bot">
                                        </div>
                                        <div class="col-12 position-relative">
                                            <div class="botName position-absolute w-100 bottom-0">
                                                <span>Team (X)</span>
                                                <span><input type="checkbox" id="team(X)" name="voteTeam" value="team(X)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Vote</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    <!-- /.modal-dialog -->
    </div>
    <div class="text-center">
        <h3>Doet de livestream het niet?</h3>
        <a href="https://www.twitch.tv/stendenbattlebot"><h6>Klik hier!</h6></a>
    </div>
    <footer>
        <?php include_once('../components/footer.php') ?>
    </footer>
    <script>
        let myCollapsible = document.getElementById('chatbox');
        let chat = document.getElementById("chat");
        let livestream = document.getElementById("livestream");
        let openChatBtn = document.getElementById("openChatBtn");

        myCollapsible.addEventListener('hidden.bs.collapse', function() {
            chat.classList.remove("col-xl-3", "col-lg-4", "col-12");
            chat.classList.add("col-md-1");

            livestream.classList.remove("col-xl-9", "col-lg-8", "col-12");
            livestream.classList.add("col-md-11");

            openChatBtn.classList.remove("d-none");
        });

        myCollapsible.addEventListener('show.bs.collapse', function() {
            chat.classList.add("col-xl-3", "col-lg-4", "col-12");
            chat.classList.remove("col-md-1");

            livestream.classList.add("col-xl-9", "col-lg-8", "col-12");
            livestream.classList.remove("col-md-11");

            openChatBtn.classList.add("d-none");
        });

        $(document).ready(function() {
            $("button.vote-button").click(function() {
                $("#modalEdit").modal("show");
            });
            $("button.close").click(function() {
                $("#modalEdit").modal("hide");
            });
        });
    </script>
    <script src="../assets/js/chat.js"></script>
</body>

</html>