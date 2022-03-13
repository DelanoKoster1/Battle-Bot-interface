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

    <title>playBack pagina</title>
</head>

<body>
<section id="header">
    <?php includeHeader('page'); ?>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="embed-responsive embed-responsive-16by9">
                <video class="playVideo" width="990" height="550" controls>

                </video>
            </div>
        </div>
        <div class="col-md-3">
            <div class="chatBox">
                <div class="row">
                    <div class="col-md-12">
                        <h3 id="liveChat">Live Chat</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="chat">
                            John Doe
                            dit is een test.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="chatField">
                            <input type="text" name="chatMessage" id="chatMessage" placeholder="text here..."/>
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

<script src="../assets/js/chat.js"></script>
</body>

</html>