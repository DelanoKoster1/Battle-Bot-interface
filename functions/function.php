<?php
session_start();

function connectDB () {
    //Require ENV
    require_once('env.php');

    // Connect to server (localhost server)
    $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    // Test the connection
    if (!$conn) {
        $_SESSION['error'] = "database_connect_error";
        header("location: error.php");
    }

    return $conn;
}

function includeHeader (String $sort) {
    $_SESSION['sort'] = $sort;
    if ($sort == 'page') {
        require_once('../components/header.php');
    } else {
        require_once('components/header.php');
    }
}

/**
 * Function checkUserInDatabase
 * Function to check if user already exists in database
 * Return Error message if needed.
 * @param   string          $username  Filled in username
 * @return  string/boolean  $error  False or error message
 */
function checkUserInDataBase(string $username) {
    //Call global variable(s)
    global $error;
    $conn = connectDB();

    //SQL Query for selecting all users where an email is in DB
    $query = "SELECT * FROM user WHERE username = ?";

    //Prpeparing SQL Query with database connection
    $stmt = mysqli_prepare($conn, $query);
    if(!$stmt){
        $_SESSION['error'] = "database_error";
        header("location: ../components/error.php");
    }

    //Binding params into ? fields
    if(!mysqli_stmt_bind_param($stmt, "s", $username)){
        $_SESSION['error'] = "database_error";
        header("location: ../components/error.php");
    }

    //Executing statement
    if(mysqli_stmt_execute($stmt)){
        $_SESSION['error'] = "database_error";
        header("location: ../components/error.php");
    };

    //Bind the STMT results(sql statement) to variables
    mysqli_stmt_bind_result($stmt, $ID, $one, $two, $three, $four, $five);

    //Store STMT data
    mysqli_stmt_store_result($stmt);

    //Check if a result has been found with number of rows
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        $error[] = 'Gebruiker niet gevonden.';
        return $error;
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}