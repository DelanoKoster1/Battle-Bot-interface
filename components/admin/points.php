<div class="row">
    <div class="col-3">  
        <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group row">
                <div class="col-4 d-flex align-items-center">
                    <span>INF1A</span>
                </div>
                <div class="col-8 d-flex justify-content-around">
                <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off">
                <label class="btn btn-secondary" for="option1">25</label>

                <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
                <label class="btn btn-secondary" for="option2">18</label>

                <input type="radio" class="btn-check" name="options" id="option3" autocomplete="off">
                <label class="btn btn-secondary" for="option3">15</label>

                <input type="radio" class="btn-check" name="options" id="option4" autocomplete="off">
                <label class="btn btn-secondary" for="option4">12</label>

                <input type="radio" class="btn-check" name="options" id="option5" autocomplete="off">
                <label class="btn btn-secondary" for="option5">10</label>
                </div>
            </div>
        </form>
    </div>
    <div class="col-9"></div>
</div>