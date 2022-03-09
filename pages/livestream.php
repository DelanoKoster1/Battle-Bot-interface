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

    <div class="container my-5">
        <div class="row">
            <div class="col-md-9">
                <h1>Livestream</h1>
            </div>
            <div class="col-md-3">
                <h1>Chat</h1>
            </div>
            <div class="col-md-9">
                <div class="ratio ratio-16x9">
                    <iframe id="ytplayer" type="text/html" src="https://www.youtube.com/embed/M7lc1UVf-VE?autoplay=1&origin=http://example.com" frameborder="0"></iframe>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row h-100">
                    <div class="col-12">
                        <div class="card h-100 posistion-relative">
                            <div class="card-body">
                                <div class="chatLine my-2">
                                    <span class="fw-bold">Username: </span>
                                    <span class="message">Lorem ipsum dolor sit </span>
                                </div>
                                <div class="chatLine my-2">
                                    <span class="fw-bold">Username: </span>
                                    <span class="message">Lorem ipsum dolor sit </span>
                                </div>
                                <div class="chatLine my-2">
                                    <span class="fw-bold">Username: </span>
                                    <span class="message">Lorem ipsum dolor sit </span>
                                </div>
                                <div class="chatLine my-2">
                                    <span class="fw-bold">Username: </span>
                                    <span class="message">Lorem ipsum dolor sit </span>
                                </div>
                                <div class="commandLine position-absolute bottom-0 start-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Type uw bericht" aria-label="Type uw bericht" aria-describedby="button-addon2">
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon2"><span class="material-icons align-middle">send</span></button>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="btn w-33 btn-success">1000</div>
                                            <button class="btn text-right btn-success">Scorebord</button>
                                            <button class="btn text-right btn-success">Stemmen</button>
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
    <footer>
        <?php include_once('../components/footer.php') ?>
    </footer>
</body>

</html>