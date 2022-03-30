<?php
$teams = getAllTeams();
$events = getAllEvents();
?>

<div class="eventRobotBox">
    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <?php
            if (!isset($_SESSION['selectedEvent'])) {
            ?>
            <div>
                <span>Selecteer een event</span>
                <select onchange="this.form.submit()" class="form-select" name="selectedEventForStream">
                    <option value="" disabled selected>Kies een event</option>
                    <?php
                        foreach ($events as $event) {
                            echo '<option value="' . $event['id'] . '">' . $event['name'] . '</option>';
                        }
                        ?>
                </select>
            </div>
            <i>Bij het selecteren van een keuze wordt er een nieuw menu getoond.</i>
            <?php
            }
            ?>

            <?php
            if (isset($_SESSION['selectedEvent'])) {
            ?>
            <div>
                <span>Selecteer een event</span>
                <input type="file" name="file">
                <input class="btn btn-success mt-3" type="submit" name="uploadStream" value="Uploaden">
                <input class="btn btn-danger mt-3" type="submit" name="streamAnnuleren" value="Annuleren">
            </div>
            <?php
            }
            ?>
        </div>
    </form>
</div>