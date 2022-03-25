<?php
        $conn = mysqli_connect("localhost","root","")
        or die ("Cannot connect to server");

        mysqli_select_db($conn, "battlebot")
        or die ("No db with that name<br>");

        if (isset($_POST['change'])) {
            if (!empty($_POST['name'])) {
                if (!empty($_POST['description'])) {
                    

                    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
                    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
                    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

                    $stmt = mysqli_prepare($conn, "UPDATE bot SET name=?, description=? WHERE id=?") or die (mysqli_error($conn));
                
                    mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $id);

                    mysqli_stmt_execute($stmt) or die ("<br>unable");

                    echo ("Informatie gewijzigd");

                    mysqli_stmt_close($stmt);
                    
                    } else {
                        die("Description not empty");
                    }
                
                } else {
                    die("Name not empty");
    
            }
        }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit info</title>
</head>
<body>
<?php
        if(isset($_GET["id"])){
        $id = $_GET["id"];
        $stmt = mysqli_prepare($conn, "SELECT name, description FROM bot WHERE id = ?") or die (mysqli_error($conn));

        mysqli_stmt_bind_param($stmt, "i", $id);

        mysqli_stmt_execute($stmt) or die('<br>message');
        mysqli_stmt_store_result($stmt) or die (mysqli_error($conn));
        if (mysqli_stmt_num_rows($stmt) > 0){
        mysqli_stmt_bind_result($stmt, $name, $description);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        }}
    ?>
    <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" value="<?php echo $id; ?>" name="id" id="id">
        <input type="text" value="<?php echo $name; ?>" name="name">Bot name<br>
        <input type="text" value="<?php echo $description; ?>" name="description">Bot description<br>
        <input type="submit" name="change" value="wijzig">
    </form>
</body>
</html>