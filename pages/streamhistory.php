<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('../components/head.html');
    include_once('../functions/function.php');
    ?>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/robots.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <title>Bot Page</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>

    <main id='events'>
        <div class='containter py-4'>
            <div class="row">
                <div class="col-12 mb-2 text-center">
                    <h3>Stream geschiedenis</h3>
                </div>
            </div>

            <div class="row m-auto eventShowBox">
                <?php showEvents(); ?>
            </div>
        </div>
    </main>


</body>

<footer>
    <?php include_once('../components/footer.php') ?>
</footer>
</body>

</html>