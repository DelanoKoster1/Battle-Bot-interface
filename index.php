<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        include_once('components/head.html');
        include_once('functions/function.php');
    ?>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <title>Voorpagina</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('index'); ?>
    </section>
    <section id="content">
        <div class="container">
            <div class="row py-5">
                <div class="col-6">
                    <h1>Welkom op Battlebots</h1>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam libero distinctio, voluptate tempora enim expedita repellat nesciunt vero, impedit delectus non vel dolorum? Quidem repudiandae maiores, facilis maxime ab natus!
                    </p>
                </div>
                <div class="col-lg-6 text-center">
                    <img class="img-fluid frontpageIMG" src="assets/img/photo1.png" alt="Battlebots">
                </div>
            </div>
        </div>
    </section>

    <section id="bots">
        <div class="botBanner py-2">
            <div class="container">
                <div class="row my-4">
                    <div class="col-12 text-center mb-4">
                        <h3 class="text-white">Ontmoet de Bots</h3>
                    </div>
                    <div class="col-lg-12 d-flex justify-content-between">
                        <div class="card">
                            <img src="assets/img/bots/BB_sawblaze-beauty.jpg" class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center"><a href="#" class="stretched-link">Card title</a></h5>
                            </div>
                        </div>
                        <div class="card">
                            <img src="assets/img/bots/BB_sawblaze-beauty.jpg" class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center"><a href="#" class="stretched-link">Card title</a></h5>
                            </div>
                        </div>
                        <div class="card">
                            <img src="assets/img/bots/BB_sawblaze-beauty.jpg" class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center"><a href="#" class="stretched-link">Card title</a></h5>
                            </div>
                        </div>
                        <div class="card">
                            <img src="assets/img/bots/BB_sawblaze-beauty.jpg" class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center"><a href="#" class="stretched-link">Card title</a></h5>
                            </div>
                        </div>
                        <div class="card">
                            <img src="assets/img/bots/BB_sawblaze-beauty.jpg" class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center"><a href="#" class="stretched-link">Card title</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="events">
        <div class="container py-4">
            <div class="row">
                <div class="col-12 mb-2 text-center">
                    <h3>Evenementen</h3>
                </div>
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="card mx-3 event">
                        <div class="d-flex justify-content-left align-items-center">
                            <div>
                                <span class="calendarDate d-block">25 Maart 2022</span>
                                <span class="calendarTitle">Testdag</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-left">
                            <span class="calendarInfo mt-4">De officiële testdag van het evenement</span>
                        </div>
                    </div>
                    <div class="card mx-3 event">
                        <div class="d-flex justify-content-left align-items-center">
                            <div>
                                <span class="calendarDate d-block">14 April 2022</span>
                                <span class="calendarTitle">Race dag</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-left">
                            <span class="calendarInfo mt-4">De officiële race dag van het evenement</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include_once('components/footer.php') ?>
</body>

</html>