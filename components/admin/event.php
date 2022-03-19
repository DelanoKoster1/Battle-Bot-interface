<div class="eventBox">
    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <input class="form-control mt-3" min="<?php echo $today ?>" type="date" name="date">
            <input class="form-control mt-3" placeholder="Event naam" type="text" name="eventNaam">
            <textarea class="form-control mt-3" name="eventOmschrijving" placeholder="Event omschrijving"></textarea>
            <input class="btn btn-danger mt-3" type="submit" name="event" value="Event toevoegen">
        </div>
    </form>
</div>