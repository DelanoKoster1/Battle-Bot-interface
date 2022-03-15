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
                                            <div class="col-12">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="Type uw bericht" aria-label="Type uw bericht" id="chatMessage" aria-describedby="button-addon2">
                                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"><span class="material-icons align-middle">send</span></button>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between mb-3">
                                                <div class="btn w-33 btn-success">1000</div>
                                                <button class="btn text-right btn-success">Scorebord</button>
                                                <button class="btn text-right btn-success">Stemmen</button>
                                            </div>
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
        })
    </script>
    <script src="../assets/js/chat.js"></script>
</body>

</html>