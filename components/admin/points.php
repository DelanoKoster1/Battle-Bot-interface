<?php
$results = getActiveEvent();
?>

<div class="row">
    <?php
    if (!isset($_GET['eventId'])) {
        showEvents(false, true);
    }
    ?>
</div>

<?php
if (isset($_GET['eventId'])) {
    if (is_array($results) && $results['eventId'][0] == $_GET['eventId']) { ?>
        <div class="row">
            <div class="col-lg-4">
                <form action="" method="post" id="points-form">
                    <?php foreach ($teams as $teamId => $team) { ?>
                        <div class="form-group row mt-2">
                            <div class="col-lg-4 d-flex align-items-center">
                                <span><?= $team ?></span>
                            </div>
                            <div class="col-lg-8 d-flex justify-content-around">
                                <input type="radio" class="btn-check" onclick="this.form.submit()" name="<?= $teamId ?>" id="<?= $team ?>" value="25" <?= (($teamPoints[$teamId] + 25) > 75) ? "disabled" : ""; ?>>
                                <label class="btn btn-secondary" for="<?= $team ?>">25</label>

                                <input type="radio" class="btn-check" onclick="this.form.submit()" name="<?= $teamId ?>" id="<?= $team . '1' ?>" value="18" <?= (($teamPoints[$teamId] + 18) > 75) ? "disabled" : ""; ?>>
                                <label class="btn btn-secondary" for="<?= $team . '1' ?>">18</label>

                                <input type="radio" class="btn-check" onclick="this.form.submit()" name="<?= $teamId ?>" id="<?= $team . '2' ?>" value="15" <?= (($teamPoints[$teamId] + 15) > 75) ? "disabled" : ""; ?>>
                                <label class="btn btn-secondary" for="<?= $team . '2' ?>">15</label>

                                <input type="radio" class="btn-check" onclick="this.form.submit()" name="<?= $teamId ?>" id="<?= $team . '3' ?>" value="12" <?= (($teamPoints[$teamId] + 12) > 75) ? "disabled" : ""; ?>>
                                <label class="btn btn-secondary" for="<?= $team . '3' ?>">12</label>

                                <input type="radio" class="btn-check" onclick="this.form.submit()" name="<?= $teamId ?>" id="<?= $team . '4' ?>" value="10" <?= (($teamPoints[$teamId] + 10) > 75) ? "disabled" : ""; ?>>
                                <label class="btn btn-secondary" for="<?= $team . '4' ?>">10</label>
                            </div>
                        </div>
                    <?php } ?>
                </form>
            </div>
            <div class="col-lg-8 <?= (count($teamPoints) > 1) ? "d-flex" : ""; ?>">
                <div class="row mt-2 d-flex align-content-around">
                    <?php foreach ($teamPoints as $teamId => $points) { ?>
                        <div class="col-lg-6 d-block d-flex text-left align-items-center">
                            <span>Punten: <?= $points ?></span>
                        </div>
                        <div class="col-lg-6 align-items-center">
                            <form action="" method="post" class="h-100">
                                <input type="text" class="h-100" name="<?= $teamId ?>" id="<?= $teamId . '5' ?>">
                                <input type="submit" class="btn btn-secondary h-100" name="<?= $teamId . 'submit' ?>" id="<?= $teamId . '5' ?>" value="Set">
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php
    } else {
        $error[] = "Start eerst een evenement om punten toe te kunnen voegen!";
    }
    ?>

    <div class="row mt-3">
        <div class="col-12">
            <a href="admin.php?points" class="btn btn-secondary btn-sm" role="button">Ga terug</a>
        </div>
    </div>

    <?php
}
if (!empty($error)) {
    foreach ($error as $errorMsg) { ?>
        <div class="col-md-12 p-0">
            <div class="alert alert-danger text-center text-black fw-bold p-4 mt-3 mb-3 rounded" role="alert">
                <?php echo $errorMsg ?>
            </div>
        </div>
        <?php
    }
}
?>