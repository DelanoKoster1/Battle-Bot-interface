<div class="row">
    <div class="col-4">  
        <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <?php foreach($teams as $teamId => $team) { ?>
            <div class="form-group row mt-2">
                <div class="col-4 d-flex align-items-center">
                    <span><?= $team ?></span>
                </div>
                <div class="col-8 d-flex justify-content-around">
                <input type="radio" class="btn-check" name="<?= $teamId ?>" id="<?=$team?>" value="25" autocomplete="off">
                <label class="btn btn-secondary" for="<?=$team?>">25</label>

                <input type="radio" class="btn-check" name="<?= $teamId ?>" id="<?=$team . '1'?>" value="18" autocomplete="off">
                <label class="btn btn-secondary" for="<?=$team . '1'?>">18</label>

                <input type="radio" class="btn-check" name="<?= $teamId ?>" id="<?=$team . '2'?>" value="15" autocomplete="off">
                <label class="btn btn-secondary" for="<?=$team . '2'?>">15</label>

                <input type="radio" class="btn-check" name="<?= $teamId ?>" id="<?=$team . '3'?>" value="12" autocomplete="off">
                <label class="btn btn-secondary" for="<?=$team . '3'?>">12</label>

                <input type="radio" class="btn-check" name="<?= $teamId ?>" id="<?=$team . '4'?>" value="10" autocomplete="off">
                <label class="btn btn-secondary" for="<?=$team . '4'?>">10</label>

                
                </div>
            </div>
        <?php } ?>
            <input type="submit" name="submitPoints" id="submitPoints" value="Punten toevoegen">
        </form>
    </div>
    <div class="col-8">
    </div>
</div>