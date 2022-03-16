<?php
session_start();

function connectDB() {
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

function includeHeader(String $sort) {
    $_SESSION['sort'] = $sort;
    if ($sort == 'page') {
        require_once('../components/header.php');
    } else {
        require_once('components/header.php');
    }
}

//function which shows the amount of time that's left until the event, displayed through {days, hours, minutes, seconds}
function eventTimeDescent() {

    require_once("database.php");

    $query = "SELECT
              date
              FROM `event`
             ";

    $results = stmtExec($query);

    $now = new DateTime();

    foreach($results as $unused => $date) {
        foreach($date as $typedOutDate) {
            $eventDate = new DateTime($typedOutDate);
        }
    }

    if (!empty($eventDate)) {

        $interval = date_diff($now, $eventDate);

        $endDate = date_interval_format($interval,"%a days, %h hours, %i minutes, %s seconds");

        return $endDate;

    } else {
        return "er zijn momenteel geen evenementen";
    }

}
