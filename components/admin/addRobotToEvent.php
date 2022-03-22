<?php
$robots = getAllRobots();
$events = getAllEvents();
?>
<div class="eventRobotBox">
    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <div>
                <span>Selecteer een robot</span>
                <select class="form-select" aria-label="Default select example" name="selectedRobot">
                    <option value="" disabled selected>Kies een robot</option>
                    <?php
                    foreach ($robots as $robot) {
                        echo '<option value="'. $robot['id'] .'">' . $robot['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mt-3">
                <span>Selecteer een event</span>
                <select class="form-select" aria-label="Default select example" name="selectedEvent">
                    <option value="" disabled selected>Kies een event</option>
                    <?php
                    foreach ($events as $event) {
                        echo '<option value="'. $event['id'] .'">' . $event['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <input class="btn btn-danger mt-3" type="submit" name="robotToEvent" value="Robot aan event toevoegen">
        </div>
    </form>
</div>