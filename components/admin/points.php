<div class="row">
    <div class="col-4">  
        <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <?php foreach($teams as $team) { ?>
            <div class="form-group row mt-2">
                <div class="col-4 d-flex align-items-center">
                    <span><?= $team ?></span>
                </div>
                <div class="col-8 d-flex justify-content-around">
                <input type="radio" class="btn-check" name="<?= $team ?>" id="option1" autocomplete="off">
                <label class="btn btn-secondary" for="option1">25</label>

                <input type="radio" class="btn-check" name="<?= $team ?>" id="option2" autocomplete="off">
                <label class="btn btn-secondary" for="option2">18</label>

                <input type="radio" class="btn-check" name="<?= $team ?>" id="option3" autocomplete="off">
                <label class="btn btn-secondary" for="option3">15</label>

                <input type="radio" class="btn-check" name="<?= $team ?>" id="option4" autocomplete="off">
                <label class="btn btn-secondary" for="option4">12</label>

                <input type="radio" class="btn-check" name="<?= $team ?>" id="option5" autocomplete="off">
                <label class="btn btn-secondary" for="option5">10</label>

                
                </div>
            </div>
        <?php } ?>
            <input type="submit" name="points" id="points">
        </form>
    </div>
    <div class="col-8"></div>
</div>