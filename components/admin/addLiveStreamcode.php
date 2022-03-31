<?php

$query = "SELECT name FROM `event` WHERE `active` = 1";
$results = stmtExec($query);

if(is_array($results)) {
    if(isset($_POST["add"])) {
        if(isset($_POST["stream"])) {
            $stream = filter_input(INPUT_POST, "stream", FILTER_SANITIZE_SPECIAL_CHARS);
            $event = $results["name"][0];

            if($stream) {
                $query = "UPDATE event SET stream = ? WHERE name = ?";
                stmtExec($query, 0, $stream, $event);
            } else {
                $error[] = 'Dit is geen valide stream!';
            }
        } else {
            $error[] = 'Je hebt geen stream meegegeven!';
        }
    }
} else {
    $error[] = 'Er is momenteel geen stream actief! Activeer eerst de stream!';
}

?>

<div class="eventRobotBox">
    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <?php
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
        <div class="form-group">
            <div>
                <span>Voeg Livestream toe</span>
                <input type="text" name="stream">
                <input type="submit" name="add" value="Voeg toe">
            </div>
        </div>
    </form>
</div>