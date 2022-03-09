<?php
require_once "../functions/database.php";

if(isset($_GET['database'])) {
    if($_GET['database'] === "refresh") {
        $setupdir = array_diff(scandir("./"), array('..', '.'));

        foreach($setupdir as $file) {
            if(is_file($file) && $file == "database.sql") {
                $sqlFile = $file;
            }
        }

        $sqlFileContent = file_get_contents($sqlFile);

        $sqlFileArray = explode(";", $sqlFileContent);
        $sqlFileArray = array_diff($sqlFileArray, array(""));

        foreach($sqlFileArray as $sql) {
            if(!str_contains($sql, "USE")) {
                stmtExec($sql);
            }
        }
    } else if($_GET['database'] === "delete") {
        $sql = "DROP DATABASE battlebot";
        stmtExec($sql);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BattleBot Setup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Setup BattleBot</h1>
        <div class="database">
            <h2>Database</h2>
            <a href="?database=refresh">Import / Refresh</a>
            <a href="?database=delete">Delete</a>
        </div>
    </main>
</body>
</html>