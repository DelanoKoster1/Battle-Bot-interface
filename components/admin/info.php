<?php
if (isset($_POST['change'])) {
    if(isset($_GET['botId'])) {
        if (!empty($_POST['botName'])) {
            if (!empty($_POST['description'])) {
                if (isset($_FILES['imagePath'])) {
                    if(!empty($_POST['macAdress'])) {

                        $botId = filter_input(INPUT_GET, 'botId', FILTER_SANITIZE_NUMBER_INT);
                        $botName = filter_input(INPUT_POST, 'botName', FILTER_SANITIZE_SPECIAL_CHARS);
                        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
                        $macAdress = filter_input(INPUT_POST, 'macAdress', FILTER_SANITIZE_SPECIAL_CHARS);

                        if (checkIfFile($_FILES['imagePath'])) {
                            if (checkFileSize($_FILES['imagePath'])) {
                                if (checkFileType($_FILES['imagePath'])) {
                                    if (makeFolder($botId, "../assets/img/bots/")) {
                                        if (!checkFileExist("../assets/img/bots/" . $botId . "/", $_FILES['imagePath']['name'])) {
                                            $query = "UPDATE `bot` SET imagePath = ? WHERE id = ?";
                                            
                                            deleteFile("../assets/img/bots/{$botId}/");
                
                                            if (!uploadFile($_FILES['imagePath'], $query, $botId, "/assets/img/bots/{$botId}/")) {
                                                $error[] = "Er is iets fout gegaan bij  het uploaden van het bestand!";
                                                $_SESSION['ERROR_MESSAGE'] = $error;
                                                header('location: admin.php?info');
                                                exit();
                                            } 
                                        } else {
                                            $error[] = "Het geüploade bestand bestaat al!";
                                            $_SESSION['ERROR_MESSAGE'] = $error;
                                            header('location: admin.php?info');
                                            exit();
                                        }
                                    } else {
                                        $error[] = "Er is iets fout gegaan bij  het uploaden van het bestand!";
                                        $_SESSION['ERROR_MESSAGE'] = $error;
                                        header('location: admin.php?info');
                                        exit();
                                    }
                                } else {
                                    $error[] = "Dit bestandstype wordt niet geaccepteerd!";
                                    $_SESSION['ERROR_MESSAGE'] = $error;
                                    header('location: admin.php?info');
                                    exit();
                                }
                            } else {
                                $error[] = "Het geüploade bestand is te groot!";
                                $_SESSION['ERROR_MESSAGE'] = $error;
                                header('location: admin.php?info');
                                exit();
                            }
                        }

                        $sql = "UPDATE bot SET name = ?, description = ?, macAddress = ? WHERE id = ?";
                        
                        if (!stmtExec($sql, 0, $botName, $description, $macAdress, $botId)) {
                            $_SESSION['ERROR_MESSAGE'] = "Fout met update!";
                            header("location: ../components/error.php");
                            exit();
                        }

                        ?>

                        <div class="alert alert-success text-center text-black fw-bold p-4 mb-3 rounded" role="alert">
                            <?php echo "De informatie is succesvol gewijzigd!" ?>
                        </div>

                    <?php
                    } else {
                        echo "<a href='admin.php?info'><h6>Ga terug</h6></a>";
                        $error[] = "Het Mac adres mag niet leeg zijn!";
                    }

                    $sql = "UPDATE  bot 
                            SET     name = ?, 
                                    description = ?, 
                                    macAddress = ? 
                            WHERE   id = ?";
                    
                    if (!stmtExec($sql, 0, $botName, $description, $macAdress, $botId)) {
                        $_SESSION['ERROR_MESSAGE'] = "Fout met update!";
                        header("location: ../components/error.php");
                        exit();
                    }

                    ?>

                    <div class="alert alert-success text-center text-black fw-bold p-4 mb-3 rounded" role="alert">
                        <?php echo "De informatie is succesvol gewijzigd!" ?>
                    </div>

                <?php
                } else {
                    echo "<a href='admin.php?info'><h6>Ga terug</h6></a>";
                    $error[] = "De robot afbeelding mag niet leeg zijn!";
                }
            } else {
                echo "<a href='admin.php?info'><h6>Ga terug</h6></a>";
                $error[] = "De robot omschrijving mag niet leeg zijn!";
            }
        } else {
            echo "<a href='admin.php?info'><h6>Ga terug</h6></a>";
            $error[] = "De robot naam mag niet leeg zijn!";
        }
    } else {
        echo "<a href='admin.php?info'><h6>Ga terug</h6></a>";
        $error[] = "Selecteer een robot!";
    }
}

if (isset($_POST['change2'])) {
    if (!empty($_POST['teamName'])) {
        $id = filter_input(INPUT_GET, 'teamId', FILTER_SANITIZE_NUMBER_INT);
        $name = filter_input(INPUT_POST, 'teamName', FILTER_SANITIZE_SPECIAL_CHARS);

        $sql = "UPDATE  team 
                SET     name = ? 
                WHERE   id = ?";

        if (!stmtExec($sql, 0, $name, $id)) {
            $_SESSION['ERROR_MESSAGE'] = "Fout met update!";
            header("location: ../components/error.php");
            exit();
        }
        ?>

        <div class="alert alert-success text-center text-black fw-bold p-4 mb-3 rounded" role="alert">
            <?php echo "De informatie is succesvol gewijzigd!" ?>
        </div>

    <?php
    } else {
        echo "<a href='admin.php?info'><h6>Ga terug</h6></a>";
        $error[] = "De team naam mag niet leeg zijn!";
    }
}

if (!empty($error)) {
    foreach ($error as $errorMsg) { ?>
        <div class="col-md-12 p-0">
            <div class="alert alert-danger text-center text-black fw-bold p-4 mt-3 mb-3 rounded" role="alert">
                <?php echo $errorMsg ?>
            </div>
        </div>
        <?php
    }
}
?>
<div class="row">
    <div class="col-md-6">
        <h3>Robot Informatie</h3>
        <?php
        $sql = "SELECT  id, 
                        name, 
                        description, 
                        imagePath,
                        macAddress 
                FROM    bot";
        
        $bots = stmtExec($sql);
        

        if (is_array($bots) && count($bots["id"]) > 0) {
            $botIds = $bots["id"];

            echo "<table class='border border-dark'>";
            echo "<th class='infotable'>Name</th>
                 <th class='infotable'>Description</th>
                 <th class='infotable'>Image Path</th>
                 <th class='infotable'>Mac Adress</th>
                 <th class='infotable'>Edit</th>";

            for ($i = 0; $i < count($bots["id"]); $i++) {
                $botId = $bots["id"][$i];
                $botName = $bots["name"][$i];
                $description = $bots["description"][$i];
                $imagePath = $bots['imagePath'][$i];
                $macAdress = $bots['macAddress'][$i];

                if($imagePath == NULL) {
                    $imagePath = "No image";
                } else {
                    $imagePath = "<img src='..{$imagePath}'>";
                }

                echo "<tr class='infotable'>";
                echo "<th class='infotable'>" . $botName . "</th>";
                echo "<th class='infotable'>" . $description . "</th>";
                echo "<th class='infotable'>" . $imagePath . "</th>";
                echo "<th class='infotable'>" . $macAdress . "</th>";
                echo "<th class='infotable'><a href=admin.php?info&botId=" . $botId . ">Edit</a></th>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            $error[] = "Er zijn geen robots beschikbaar!";
        }
        echo "<br>";

        if (isset($_GET["botId"])) {
            $id = filter_input(INPUT_GET, "botId", FILTER_VALIDATE_INT);

            $sql = "SELECT  id, 
                            name, 
                            description, 
                            imagePath, 
                            macAddress 
                    FROM    bot 
                    WHERE   id = ?";

            $bots = stmtExec($sql, 0, $id);

            if (!is_array($bots)) {
                $_SESSION['ERROR_MESSAGE'] = "Bot bestaat niet!";
                header("location: ../components/error.php");
                exit();
            }

            $botId = $bots["id"][0];
            $botName = $bots["name"][0];
            $description = $bots["description"][0];
            $imagePath = $bots["imagePath"][0];
            $macAdress = $bots["macAddress"][0];
        }
        ?>
    </div>
    <div class="col-md-6">
        <h3>Team informatie</h3>
        <?php
        $sql = "SELECT  id, 
                        name 
                FROM    team";

        $teams = stmtExec($sql);

        if (is_array($teams) && count($teams["id"]) > 0) {
            echo "<table class='border border-dark'>";
            echo "<th class='infotable'>Name</th>
                  <th class='infotable'>Edit</th>";

            for ($i = 0; $i < count($teams["id"]); $i ++) {
                $teamId = $teams["id"][$i];
                $teamName = $teams["name"][$i];

                echo "<tr class='infotable'>";
                echo "<th class='infotable'>" . $teamName . "</th>";
                echo "<th class='infotable'><a href=admin.php?info&teamId=" . $teamId . ">Edit</a></th>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            $error[] = "Er zijn geen teams beschikbaar!";
        }

        if (isset($_GET["teamId"])) {
            $id = $_GET["teamId"];
            $sql = "SELECT  id, 
                            name 
                    FROM    team
                    WHERE   id = ?";

            $teams = stmtExec($sql, 0, $id);
            
            if (!is_array($teams)) {
                $_SESSION['ERROR_MESSAGE'] = "Bot bestaat niet!";
                header("location: ../components/error.php");
                exit();
            }

            $teamId = $teams["id"][0];
            $teamName = $teams["name"][0];
        }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h3>Robot informatie</h3>
        <form method="POST" action="" enctype="multipart/form-data">
            <p><input type="hidden" class="form-control mt-3" value="<?= $botId; ?>" name="botId" id="id"></p>
            <h6>Robot naam</h6>
            <p><input type="text" class="form-control mt-3" value="<?= $botName; ?>" name="botName"></p>
            <h6>Robot beschrijving</h6>
            <p><input type="text" class="form-control mt-3" value="<?= $description; ?>" name="description"></p>
            <h6>Robot MAC adres</h6>
            <p><input type="text" class="form-control mt-3" value="<?= $macAdress; ?>" name="macAdress" id="macAdress"></p>
            <h6>Robot foto</h6>
            <p><input type="file" class="form-control mt-3" name="imagePath"></p>
            <input type="submit" name="change" class="btn btn-primary mt-3" value="Wijzigen">
        </form>
    </div>

    <div class="col-md-6">
        <h3>Team informatie</h3>
        <form method="POST" action="">
            <p><input type="hidden" class="form-control mt-3" value="<?= $teamId; ?>" name="teamId" id="id"></p>
            <h6>Team naam</h6>
            <p><input type="text" class="form-control mt-3" value="<?= $teamName; ?>" name="teamName"></p>
            <input type="submit" name="change2" class="btn btn-primary mt-3" value="Wijzigen">
        </form>
    </div>
</div>