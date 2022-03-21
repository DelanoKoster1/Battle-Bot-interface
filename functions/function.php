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
    if (!empty($eventResults["id"])) {
        $ids = $eventResults["id"];

        foreach ($ids as $eventId) {
            $name = $eventResults["name"][$eventId - 1];
            $eventDate = $eventResults["date"][$eventId - 1];
            $description = $eventResults["description"][$eventId - 1];
    
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

    $query = "SELECT
              date
              FROM `event`
             ";

    $results = stmtExec($query);

    foreach($results as $unused => $date) {
        foreach($date as $typedOutDate) {
            return $typedOutDate; 
        }
    }

}

function getBots() {

    require_once('database.php');

    $query = " SELECT   name
               FROM     bot 
             ";

    $results = stmtExec($query);

    $botReturn = '';

    foreach ($results as $botArray) {
        foreach ($botArray as $bot) {
            $botReturn .= '<div class="col-lg-4 col-sm-4 col-6 mb-2 checkBot">';
                $botReturn .= '<div class="box bg-secondary d-flex justify-content-center">';
                    $botReturn .= '<div class="row g-0 w-100 text-center">';
                        $botReturn .= '<div class="col-12 pt-1">';
                            $botReturn .= '<img class="img-fluid" src="../assets/img/bot.svg" alt="Logo of a bot">';
                        $botReturn .= '</div>';
                        $botReturn .= '<div class="col-12 position-relative">';
                            $botReturn .= '<div class="botName position-absolute w-100 bottom-0">';
                                $botReturn .= '<span>'.$bot.'</span>';
                                $botReturn .= '<span><input type="checkbox" class="d-none" id="'.$bot.'" name="voteTeam[]" value="'.$bot.'"></span>';
                            $botReturn .= '</div>';
                        $botReturn .= '</div>';
                    $botReturn .= '</div>';
                $botReturn .= '</div>';
            $botReturn .= '</div>';
        }
    }

    return $botReturn;

}

function voteBot($votedBot) {
    if (count($votedBot) <= 1) {
        return "<div class='alert alert-success text-center' role='alert'>ja je hebt goed gestemt</div>";
    } else {
        return "<div class='alert alert-danger text-center' role='alert'>je mag maar op 1 robot stemmen</div>";
    }
}
