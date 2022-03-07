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
            <div class="col-md-10">
                <video class="playVideo" width="990" height="500" controls>

                </video>
            </div>
            <div class="col-md-2">

            </div>
        </div>
    </div>
</body>

</html>