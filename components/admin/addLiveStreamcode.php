<?php

$query = "SELECT    name 
          FROM      `event` 
          WHERE     `active` = 1";
$results = stmtExec($query);
if (is_array($results)) {
?>
    <div class="eventRobotBox">
        <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="form-group">
                <span>Voeg een livestream toe</span>
                <div>
                    <input class="form-control" type="text" name="stream">
                </div>
                <div>
                    <input class="mt-3 btn btn-success" type="submit" name="addStreamCode" value="Toevoegen">
                </div>
            </div>
        </form>
    </div>
    <?php
} else {
    $error[] = 'Activeer eerst de livestream om een code toe te kunnen voegen!';
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