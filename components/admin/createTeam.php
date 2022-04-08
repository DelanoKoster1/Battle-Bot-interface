<?php
$sql = "SELECT  bot.id 
        FROM    `bot` 
        WHERE   `id` NOT IN (
                            SELECT  team.botId 
                            FROM    `team`)";
$results = stmtExec($sql, 0);

if (!$results) {
    $_SESSION['error'] = "Voer alle velden in!";
    header("location: ../components/error.php");
}

if ($results == 1) {
    echo '<div> <a class="text-decoration-none nav-link" href="admin.php?bot">Er zijn geen robots beschikbaar. Klik hier om een robot toe te voegen!</a></div>';
} else {
    echo "Kies een robot";
?>
    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <div class="col-4">
            <select class="form-select mt-3" name="bots" id="bots">
                <?php
                $ids = $results["bot.id"];
                for ($i = 0; $i < count($ids); $i++) {

                    $sql = "SELECT  name, 
                                    id 
                            FROM    bot 
                            WHERE   id = ?";
                    $result = stmtExec($sql, 0, $results["bot.id"][$i]);
                    $name = $result['name'][0];
                    $botId = $result['id'][0];
                    echo '
                    <option value="' . $botId . '"> ' . $name . '</option>
                ';
                }
                foreach ($error as $errorMsg) { ?>
                    <div class="col-md-12 p-0">
                        <div class="alert alert-danger text-center text-black fw-bold p-4 mt-3 mb-3 rounded" role="alert">
                            <?php echo $errorMsg ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </select>
            <input class="form-control mt-3" placeholder="Team Naam" name="teamName" id="teamName" type="text">
            <input class="btn btn-danger mt-3" type="submit" id="submitTeam" name="submitTeam" value="Team aanmaken">
        </div>
    </form>
<?php
}
