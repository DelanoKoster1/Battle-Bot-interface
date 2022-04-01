<?php

$query = "SELECT    name 
          FROM      `event` 
          WHERE     `active` = 1";
$results = stmtExec($query);

if(is_array($results)) {
    if(isset($_POST["add"])) {
        if(isset($_POST["stream"])) {
            $stream = filter_input(INPUT_POST, "stream", FILTER_SANITIZE_SPECIAL_CHARS);
            $event = $results["name"][0];

            if($stream) {
                $query = "UPDATE    event 
                          SET       stream = ? 
                          WHERE     name = ?";
                stmtExec($query, 0, $stream, $event);
            } else {
                $error[] = 'Dit is geen valide stream!';
            }
        } else {
            $error[] = 'Er is geen stream geüpload!';
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
            <span>Voeg een livestream toe</span>
            <div>
                <input class="form-control" type="file" name="stream">
            </div>
            <div>
                <input class="mt-3 btn btn-success" type="submit" name="add" value="Toevoegen">
            </div>
        </div>
    </form>
</div>