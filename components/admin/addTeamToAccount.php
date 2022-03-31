<?php 
    $sql = "SELECT username, id  
            FROM account 
            WHERE teamId = ?";
    $results = stmtExec($sql, 0, 0);

    $sql = "SELECT team.name, team.id
            FROM team";
    $teamResults = stmtExec($sql, 0, 0);

    $usernames = $results['username'];
    $userIds = $results['id'];
    $teamNames = $teamResults['team.name'];
    $teamIds = $teamResults['team.id'];
    

    if ($results == 1) {
        echo '<div> <a class="text-decoration-none nav-link" href="admin.php?addTeamToAccount">Er zijn geen accounts zonder team</a></div>';
    } else {
?>
    <form action="" method="post">
        <div class="col-md-4">
            <?php if(!isset($_GET['setAcc'])) {
            (isset($_SESSION['succes'])) ? $_SESSION['succes'] : "";
            ?> 
            <h4>Kies een account</h4>
            <select onchange="this.form.submit()" name="accounts" id="accounts" class="form-select mt-3">
                <option value="" disabled selected>Kies een account</option>
                <?php
                    for($i = 0; $i < count($usernames); $i++) {
                        echo "<option value='{$userIds[$i]}'>{$usernames[$i]}</option>";
                    }
                ?>
            </select>
            <?php } ?>

            <?php if(isset($_GET['setAcc'])) { ?>
                <h4>Kies een team</h4>
                <select onchange="this.form.submit()" name="teams" id="teams" class="form-select mt-3">
                    <option value="" disabled selected>Kies een team</option>
                    <?php
                        for($i = 0; $i < count($teamNames); $i++) {
                            echo "<option value='{$teamIds[$i]}'>{$teamNames[$i]}</option>";
                        }
                    ?>
                </select>
            <?php } ?>
        </div>

    </form>
<?php 
}
?>