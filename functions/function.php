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
    $today = date('Y-m-d\TH:i');

    //Check if filled in date is older then today.
    if ($date < $today) {
        return false;
    }

    //Check if date format is correct
    if (preg_match("/^(000[1-9]|00[1-9]\d|0[1-9]\d\d|100\d|10[1-9]\d|1[1-9]\d{2}|[2-9]\d{3}|[1-9]\d{4}|1\d{5}|2[0-6]\d{4}|27[0-4]\d{3}|275[0-6]\d{2}|2757[0-5]\d|275760)-(0[1-9]|1[012])-(0[1-9]|[12]\d|3[01])T(0\d|1\d|2[0-4]):(0\d|[1-5]\d)(?::(0\d|[1-5]\d))?(?:.(00\d|0[1-9]\d|[1-9]\d{2}))?$/",$date)) {
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

    $query = "SELECT id, name, date, description
              FROM event 
              WHERE date > now()
              ORDER BY date ASC
              limit 5";

    $eventResults = stmtExec($query);

    if (!empty($eventResults["id"])) {
        $ids = $eventResults["id"];

        for($i = 0; $i < count($ids); $i++) {
            $name = $eventResults["name"][$i];
            $eventDate = $eventResults["date"][$i];
            $description = $eventResults["description"][$i];
    
            echo '
            <div class="col-sm-3 mb-4">
                <div class="card eventsCard">
                    <div class="card-body">
                        <span class="calendarDate d-block text-lowercase">'. formatdate($eventDate) .'</span>
                        <span class="calendarTitle d-block text-capitalize">'. $name .'</span>
                        <span class="calendarInfo mt-4 d-block">'. $description .'</span>
                    </div>
                </div>
            </div>
            ';
        }
    } else {
        echo '
        <div class="col-sm-12 mb-4">
            <div class="card eventsCard">
                <div class="card-body text-center">
                    <span class="calendarTitle d-block text-white">Nog geen opkomende evenementen</span>
                </div>
            </div>
        </div>
        ';
    }
}

//function which shows the amount of time that's left until the event, displayed through {days, hours, minutes, seconds}
function eventTimeDescent() {

    require_once("database.php");

    $query = "SELECT    date
              FROM      `event`
              WHERE     NOW() <= date;
    ";
    $results = stmtExec($query);

    foreach($results as $date) {
        foreach($date as $typedOutDate) {
            return $typedOutDate; 
        }
    }

}

function getLivestream() {
        return '
            <iframe
            id="ytplayer"
            type="text/html"
            src="http://foscam.serverict.nl/mjpg/1/video.mjpg?1647876232941&Axis-Orig-Sw=true"
            frameborder="0">
            </iframe>
            ';
}

// function getBots() {

// }
