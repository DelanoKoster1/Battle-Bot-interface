<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once('../components/head.html') ?>
    <?php include_once('../components/header.php') ?>
    <link rel="stylesheet" href="../assets/css/playback.css">
    <title>playBack pagina</title>
</head>

<body>
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
                                <form method="post" action="">
                                    <input type="text" name="chatMessage" id="chatMessage" placeholder="text here..."/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</body>

</html>