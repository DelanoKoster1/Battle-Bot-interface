<?php
$conn = connectDB();

if (isset($_POST['change'])) {
    if (!empty($_POST['botName'])) {
        if (!empty($_POST['description'])) {
            
            $id = filter_input(INPUT_GET, 'botId', FILTER_SANITIZE_NUMBER_INT);
            $name = filter_input(INPUT_POST, 'botName', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            
            $sql = "UPDATE bot 
                    SET name = ?, 
                        description = ? 
                    WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql) or die (mysqli_error($conn));
        
            mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $id);

            mysqli_stmt_execute($stmt) or die ("<br>unable");

            ?>
            <div class="alert alert-success text-center text-black fw-bold p-4 mb-3 rounded" role="alert">
                <?php echo "De informatie is succesvol gewijzigd!" ?>
            </div>
            <?php
            mysqli_stmt_close($stmt);
            
            } else {
                echo "<a href='admin.php?info'><h6>Ga terug</h6></a>";
                $error[] = "De robot omschrijving mag niet leeg zijn!";
            }
        } else {
            echo "<a href='admin.php?info'><h6>Ga terug</h6></a>";
            $error[] = "De robot naam mag niet leeg zijn!";

    }
}
if (isset($_POST['change2'])) {
    if (!empty($_POST['teamName'])) {
        $id = filter_input(INPUT_GET, 'teamId', FILTER_SANITIZE_NUMBER_INT);
        $name = filter_input(INPUT_POST, 'teamName', FILTER_SANITIZE_SPECIAL_CHARS);

        $sql = "UPDATE team SET name=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql) or die (mysqli_error($conn));

        mysqli_stmt_bind_param($stmt, "si", $name, $id);

        mysqli_stmt_execute($stmt) or die("<br>unable");
        ?>

        <div class="alert alert-success text-center text-black fw-bold p-4 mb-3 rounded" role="alert">
            <?php echo "De informatie is succesvol gewijzigd!" ?>
        </div>

        <?php
        mysqli_stmt_close($stmt);
    } else {
        echo "<a href='admin.php?info'><h6>Ga terug</h6></a>";
        $error[] = "De team naam mag niet leeg zijn!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php
    if (!empty($error)){
        foreach ($error as $errorMsg) { ?>
            <div class="col-md-12 p-0">
                <div class="alert alert-danger text-center text-black fw-bold p-4 mt-3 mb-3 rounded" role="alert">
                    <?php echo $errorMsg ?>
                </div>
            </div><?php
        }
    }
    ?>
    <div class="row">
        <div class="col-md-6">
            <h3>Robot Informatie</h3>
            <?php
            

            $query = "SELECT id, 
                             name, 
                             description 
                      FROM bot";
            $stmt = mysqli_prepare($conn, $query) or die (mysqli_error($conn));

            mysqli_stmt_execute($stmt) or die("Cannot prepare statement");

            mysqli_stmt_bind_result($stmt, $id, $name, $description);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                echo "<table class='border border-dark'>";
                echo "<th class='infotable'>Name</th>
                      <th class='infotable'>Description</th>
                      <th class='infotable'>Edit</th>";

                while (mysqli_stmt_fetch($stmt)) {
                    echo "<tr class='infotable'>";
                    echo "<th class='infotable'>" . $name . "</th>";
                    echo "<th class='infotable'>" . $description . "</th>";
                    echo "<th class='infotable'><a href=admin.php?info&botId=" . $id . ">Edit</a></th>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                $error[] = "Er zijn geen robots beschikbaar!";
            }
            echo "<br>";
            
            //wijzigen
            if (isset($_GET["botId"])) {
                $id = $_GET["botId"];

                $sql = "SELECT name, description FROM bot WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql) or die (mysqli_error($conn));
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt) or die('<br>message');
                mysqli_stmt_store_result($stmt) or die (mysqli_error($conn));

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    mysqli_stmt_bind_result($stmt, $name, $description);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                }
            }
            ?>
        </div>
        <div class="col-md-6">
            <h3>Team informatie</h3>
            <?php
        $conn = mysqli_connect("localhost","root","")
        or die ("Cannot connect to server");

        mysqli_select_db($conn, "battlebot")
        or die("Cannot find<br>");

        $query = "SELECT id, name FROM team";
        $stmt = mysqli_prepare($conn, $query)
        or die (mysqli_error($conn));

        mysqli_stmt_execute($stmt)
        or die("Cannot prepare statement");

        mysqli_stmt_bind_result($stmt, $id, $name);
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) > 0)
        {
            echo "<table class='border border-dark'>";
            echo "<th class='infotable'>Name</th>
                  <th class='infotable'>Edit</th>";

            while (mysqli_stmt_fetch($stmt)) {
                echo "<tr class='infotable'>";
                echo "<th class='infotable'>" . $name . "</th>";
                echo "<th class='infotable'><a href=admin.php?info&teamId=" . $id . ">Edit</a></th>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            $error[] = "Er zijn geen teams beschikbaar!";
        }
        

        //wijzigen
        if(isset($_GET["teamId"])){
        $id = $_GET["teamId"];
        $sql = "SELECT name FROM team WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql) or die (mysqli_error($conn));

        mysqli_stmt_bind_param($stmt, "i", $id);

        mysqli_stmt_execute($stmt) or die('<br>message');
        mysqli_stmt_store_result($stmt) or die (mysqli_error($conn));
        if (mysqli_stmt_num_rows($stmt) > 0){
        mysqli_stmt_bind_result($stmt, $name);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        }}
    ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <h3>Robot informatie</h3>
        <form method="POST" action="">
            <p><input type="hidden" class="form-control mt-3" value="<?php echo $id; ?>" name="botId" id="id"></p>
            <h6>Robot naam</h6>
            <p><input type="text" class="form-control mt-3" value="<?php echo $name; ?>" name="botName"></p>
            <h6>Robot beschrijving</h6>
            <p><input type="text" class="form-control mt-3" value="<?php echo $description; ?>" name="description"></p>
            <input type="submit" name="change" class="btn btn-primary mt-3" value="Wijzigen">
        </form>
        </div>
        
        <div class="col-md-6">
        <h3>Team informatie</h3>
        <form method="POST" action="">
            <input type="hidden" class="form-control mt-3" value="<?php echo $id; ?>" name="teamId" id="id">
            <h6>Team naam</h6>
            <p><input type="text" class="form-control mt-3" value="<?php echo $name; ?>" name="teamName"></p>
            <input type="submit" name="change2" class="btn btn-primary mt-3" value="Wijzigen">
        </form>
        </div>
    </div>
</body>

</html>