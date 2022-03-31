<?php 
    $sql = "SELECT username, id FROM account WHERE teamId = ?";
    $results = stmtExec($sql, 0, 0);

    $usernames = $results['username'];
    $userIds = $results['id'];

    

    if ($results == 1) {
        echo '<div> <a class="text-decoration-none nav-link" href="admin.php?bot">Er zijn geen bots beschikbaar. Klik hier om een bot toe te voegen!</a></div>';
    } else {
?>

    <form action="" method="post">
        <div class="col-md-4">
            <?php if(!isset($_GET['setAcc'])) { ?>
            <h4>Kies een account</h4>
            <select onchange="this.form.submit()" name="accounts" id="accounts" class="form-select mt-3">
                <option value="" disabled selected></option>
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
                    <option value="" disabled selected></option>
                </select>
            <?php } ?>
        </div>

    </form>
<?php 
}
?>