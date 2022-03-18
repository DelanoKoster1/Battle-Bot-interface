<?php
session_start();

/**
 * Function to connect to Database
 * 
 */
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

/**
 * Function to include header with correct map structure
 * 
 */
function includeHeader(String $sort) {
    $_SESSION['sort'] = $sort;
    if ($sort == 'page') {
        require_once('../components/header.php');
    } else {
        require_once('components/header.php');
    }
}

/**
 * Function to check if date is valid
 * 
 */
function checkValidDate(String $date) {
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Function to format a date
 * 
 */
function formatdate(string $date) : string {
    switch(date("F", strtotime($date))) {
        case "January":
            $month = "\\J\\a\\n\\u\\a\\r\\i";
            break;
        case "February":
            $month = "\\F\\e\\b\\r\\u\\a\\r\\i";
            break;
        case "March":
            $month = "\\M\\a\\a\\r\\t";
            break;
        case "May":
            $month = "\\M\\e\\i";
            break;
        case "June":
            $month = "\\J\\u\\n\\i";
            break;
        case "July":
            $month = "\\J\\u\\l\\i";
            break;
        case "August":
            $month = "\\A\\u\\g\\u\\s\\t\\u\\s";
            break;
        case "October":
            $month = "\\O\\k\\t\\o\\b\\e\\r";
            break;
        default:
            break;
    }

    return (isset($month)) ? date("d $month Y", strtotime($date)) : date("d F Y", strtotime($date));
}

/**
 * Function to show events as HTML
 * 
 */
function showEvents() {
    require_once('database.php');

    $query = "SELECT id, name, date, description FROM event";
    $eventResults = stmtExec($query);
    $ids = $eventResults["id"];

    foreach ($ids as $eventId) {
        $name = $eventResults["name"][$eventId - 1];
        $eventDate = $eventResults["date"][$eventId - 1];
        $description = $eventResults["description"][$eventId - 1];

        echo '
        <div class="col-sm-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <span class="calendarDate d-block">'. formatdate($eventDate) .'</span>
                    <span class="calendarTitle">'. $name .'</span>
                    <span class="calendarInfo mt-4">'. $description .'</span>
                </div>
            </div>
        </div>
        ';
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

            if (!empty($eventDate)) {

                $interval = date_diff($now, $eventDate);

                $endDate = date_interval_format($interval,"%a days, %h hours, %i minutes, %s seconds");

                $genericDateDisplay = "";

                $genericDateDisplay .= '<div class="card mx-3 event">';
                    $genericDateDisplay .= '<div class="d-flex justify-content-left align-items-center">';
                        $genericDateDisplay .= '<div>';
                            $genericDateDisplay .= '<span class="calendarDate d-block">25 Maart 2022</span>';
                            $genericDateDisplay .= '<span class="calendarDate d-block">'.$endDate.'</span>';
                            $genericDateDisplay .= '<span class="calendarTitle">Testdag</span>';
                        $genericDateDisplay .= '</div>';
                    $genericDateDisplay .= '</div>';
                    $genericDateDisplay .= '<div class="d-flex justify-content-left">';
                        $genericDateDisplay .= '<span class="calendarInfo mt-4">De officiële testdag van het evenement</span>';
                    $genericDateDisplay .= '</div>';
                $genericDateDisplay .= '</div>';

                return $genericDateDisplay;

            } else {
                return "er zijn momenteel geen evenementen";
            }
        }
    }

}