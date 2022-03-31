<?php include_once('../functions/function.php'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="mt-3">
            <?php
            if (isset($_POST['submitPull'])) {
                $answer3 = empty($_POST['answer3']) ? NULL : $_POST['answer3'];
                $answer4 = empty($_POST['answer4']) ? NULL : $_POST['answer4'];
                $answer5 = empty($_POST['answer5']) ? NULL : $_POST['answer5'];
                multiPoll($_POST['pullQuestion'], $_POST['pullQuestionType'], $_POST['answer1'], $_POST['answer2'], $answer3, $answer4, $answer5);
            }
            ?>
        </div>
    </div>
</div>
<?php
if (isset($_POST['endPoll'])) {
    endPoll();
}
?>
<div class="row">
    <div class="col-md-6">
        <form method="post" action="">
            <div class="form-group">
                <input type="text" name="pullQuestion" class="form-control mt-3" placeholder="Poll vraag..." />
                <label for="questionType" class="mt-3">Kies het vraag type:</label>
                <select name="pullQuestionType" onchange="differentTypes.call(this, event)" id="questionType" class="form-control mt-3">
                    <option value="">---</option>
                    <option value="multiChoice" id="multiChoice">Multiple Choice</option>
                    <option value="yesOrNo" id="yesOrNo">Ja of nee</option>
                    <option value="voteForBot" id="voteForBot">Stem op een robot</option>
                </select>
                <div id="pollTypes">
                </div>
                <input type="submit" name="submitPull" class="btn btn-primary mt-3" value="submit poll" />
                <?php echo checkIfPoll(); ?>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <form method="post" action="">
            <div class="custom-control custom-radio">
                <?php echo retrieveQuestionInfo(); ?>
            </div>
        </form>
    </div>
</div>
<?php
$sql = "SELECT active FROM poll WHERE active = 1";

$polls = stmtExec($sql);

if(is_array($polls) && count($polls["active"]) > 0) {
    $isActive = $polls["active"][0];
    ?>

    <div class="row">
        <div class="col-md-6">
            <h5 class="ms-1">Poll Uitslag:</h5>
            <?php
            echo pollQuestionAnswer();
            ?>
        </div>
    </div>
    <?php
}

// if($isActive == 1) {
?>

<!-- <div class="row">
    <div class="col-md-6">
        <h5 class="ms-1">Poll Uitslag:</h5>
        <?php
        echo pollQuestionAnswer();
        ?>
    </div>
</div> -->
<?php
// }
?>

<script src="../assets/js/poll.js"></script>