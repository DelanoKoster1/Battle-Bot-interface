<?php
$conn = connectDB();

if (isset($_POST['change'])) {
    if (!empty($_POST['name'])) {
        if (!empty($_POST['description'])) {
            
            $id = filter_input(INPUT_GET, 'botId', FILTER_SANITIZE_NUMBER_INT);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            

            $stmt = mysqli_prepare($conn, "UPDATE bot SET name=?, description=? WHERE id=?") or die (mysqli_error($conn));
        
            mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $id);

            mysqli_stmt_execute($stmt) or die ("<br>unable");

            echo ("<div>Informatie gewijzigd</div>");
            
            mysqli_stmt_close($stmt);
            
            } else {
                die("Description not empty");
            }
        
        } else {
            die("Name not empty");

    }
}
if (isset($_POST['change2'])) {
    if (!empty($_POST['name'])) {
        $id = filter_input(INPUT_GET, 'teamId', FILTER_SANITIZE_NUMBER_INT);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);

        $stmt = mysqli_prepare($conn, "UPDATE team SET name=? WHERE id=?") or die (mysqli_error($conn));

        mysqli_stmt_bind_param($stmt, "si", $name, $id);

        mysqli_stmt_execute($stmt) or die("<br>unable");
        
        echo ("Informatie gewijzigd");

        mysqli_stmt_close($stmt);

    } else {
        die("Name not empty");
    }
}

?>

<div class="row">
    <div class="col-md-6">
        <h3>Bot Info</h3>
        <?php
        

        $query = "SELECT id, name, description FROM bot";
        $stmt = mysqli_prepare($conn, $query) or die (mysqli_error($conn));

        mysqli_stmt_execute($stmt) or die("Cannot prepare statement");

        mysqli_stmt_bind_result($stmt, $id, $name, $description);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo "Number of rows: " . mysqli_stmt_num_rows($stmt);
            echo "<table border='1'>";
            echo "<th style='text-align: left;'>Name</th><th>Description</th><th>Edit</th>";

            while (mysqli_stmt_fetch($stmt)) {
                echo "<tr>";
                echo "<th>" . $name . "</th>";
                echo "<th>" . $description . "</th>";
                echo "<th><a href=admin.php?info&botId=" . $id . ">Edit</a></th>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No bots";
        }
        echo "<br>";
        
        //wijzigen
        if (isset($_GET["botId"])) {
            $id = $_GET["botId"];

            $stmt = mysqli_prepare($conn, "SELECT name, description FROM bot WHERE id = ?") or die (mysqli_error($conn));
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
        <h3>Team info</h3>
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
        echo "Number of rows: " . mysqli_stmt_num_rows($stmt);
        echo "<table border='1'>";
        echo "<th style='text-align: left;'>Name</th><th>Edit</th>";

        while (mysqli_stmt_fetch($stmt)) {
            echo "<tr>";
            echo "<th>" . $name . "</th>";
            echo "<th><a href=admin.php?info&teamId=" . $id . ">Edit</a></th>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No teams";
    }
    

    //wijzigen
    if(isset($_GET["teamId"])){
    $id = $_GET["teamId"];
    $stmt = mysqli_prepare($conn, "SELECT name FROM team WHERE id = ?") or die (mysqli_error($conn));

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
    <h3>Bot info</h3>
    <form method="POST" action="">
        <input type="hidden" value="<?php echo $id; ?>" name="botId" id="id">
        <input type="text" value="<?php echo $name; ?>" name="name">Bot name<br>
        <input type="text" value="<?php echo $description; ?>" name="description">Bot description<br>
        <input type="submit" name="change" value="wijzig">
    </form>
    </div>


    
    <div class="col-md-6">
    <h3>Team info</h3>
    <form method="POST" action="">
        <input type="hidden" value="<?php echo $id; ?>" name="teamId" id="id">
        <input type="text" value="<?php echo $name; ?>" name="name">Team name<br>
        <input type="submit" name="change2" value="wijzig">
    </form>
    </div>
</div>