<div class="eventBox">
    <form action="<?= htmlentities($_SERVER['PHP_SELF']) . '?' . http_build_query($_GET); ?>" method="post">
        <div class="form-group">
            <div class="mt-3">
                <label for="date">Voer een datum in</label>
                <input id="date" class="form-control" min="<?php echo $today ?>" type="datetime-local" name="date" value="<?php if (isset($_POST['event'])) {echo htmlentities($_POST['date']);} ?>">
            </div>

            <div class="mt-3">
                <label for="name">Voer een event naam in</label>
                <input id="name" class="form-control" type="text" name="eventNaam"  placeholder="Evenement naam" value="<?php if (isset($_POST['event'])) {echo htmlentities($_POST['eventNaam']);} ?>">
            </div>

            <div class="mt-3">
                <label for="desc">Voer een event omschrijving in</label>
                <textarea id="desc" class="form-control" name="eventOmschrijving" placeholder="Evenement omschrijving"><?php if (isset($_POST['event'])) {echo htmlentities($_POST['eventOmschrijving']);} ?></textarea>
            </div>


            <div class="mt-3">
                <span >Is het event privé of openbaar?</span>

                <div class="form-check">
                    <input class="form-check-input" type="radio" value="private" name="eventType" id="eventType1">
                    <label class="form-check-label" for="eventType1">
                        Privé evenement
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="public" name="eventType" id="eventType2" checked>
                    <label class="form-check-label" for="eventType2">
                        Openbaar evenement
                    </label>
                </div>
            </div>

            <input class="btn btn-danger mt-3" type="submit" name="event" value="Evenement toevoegen">
        </div>
    </form>
</div>