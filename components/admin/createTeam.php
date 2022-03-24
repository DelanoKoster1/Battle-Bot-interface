<form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
    <div class="col-4">
        <input class="form-control mt-3" placeholder="Team Naam" name="teamName" id="teamName" type="text">
        <?php
        $sql = "SELECT bot.id FROM `bot` WHERE `id` NOT IN (SELECT team.botId FROM `team`)";
        $results = stmtExec($sql, 0);
        if (!$results) {
            $_SESSION['error'] = "Voer alle velden in";
            header("location: ../components/error.php");
        }
        ?>
        <select class="form-select mt-3" name="bots" id="bots">
            <?php
            $ids = $results["bot.id"];
            for ($i = 0; $i < count($ids); $i++) {
                $sql = "SELECT name, id FROM bot WHERE id = ?";
                $result = stmtExec($sql, 0, $results["bot.id"][$i]);
                $name = $result['name'][$i];
                $botId = $result['id'][$i];
                echo '
                    <option value=" ' . $botId . '"> ' . $name . '</option>
                ';
            }

            ?>
        </select>
        <input class="btn btn-danger mt-3" type="submit" id="submitTeam" name="submitTeam" value="Team aanmaken">
    </div>
</form>