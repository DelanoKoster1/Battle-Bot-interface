<?php
$active = filter_input(INPUT_POST, "active", FILTER_SANITIZE_NUMBER_INT);
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$query = "SELECT name
          FROM `event`
          WHERE `active` = 1
          ";
$results = stmtExec($query, 0, $active);
if (is_array($results)) {
    echo 
    '<div class="col-md-12 p-0">
        <div class="alert alert-success text-center text-black fw-bold p-4 mb-3 rounded" role="alert">
            Het evenement: <div class="fw-bold text-white">' . $results["name"][0] . '</div> is op dit moment actief!
        </div>
    </div>
    ';
} else {
    echo 
    '<div class="col-md-12 p-0">
        <div class="alert alert-danger text-center text-black fw-bold p-4 mb-3 rounded" role="alert">
            Er is op het moment geen evenement actief!
        </div>
    </div>
    ';
}
?>
<div class="row">
    <?= showEvents(false, false, true);?>
</div>