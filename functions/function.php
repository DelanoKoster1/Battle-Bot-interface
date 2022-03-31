<?php
session_start();

/**
 * Function debug
 * $type:   1 for print_r(), 0 or empty for var_dump()
 * @param void      $var
 * @param int       $type  
 * @return string   debug message
 */
function debug($var, int $type = 0) {
    echo "<pre>";
    if ($type) {
        print_r($var);
    } else {
        var_dump($var);
    }
    echo "</pre>";
}

/**
 * Function connectDB
 * Function to connect to Database
 * @return object  $conn   Database connection
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
 * Function fail
 * Function to display fail message
 * @param string    $code
 * @param string    $info
 * @return HTML
 */
function fail(?string $code = NULL, ?string $info = NULL) {
    switch ($code) {
            // Database Fail: Common
        case 'DB00':
            echo "Statement Preparation Error! $info";
            break;
        case 'DB01':
            echo "Statement Execution Error! $info";
            break;
        case 'DB02':
            echo "Cannot bind the result to the variables. $info";
            break;
        case 'DB03':
            echo "Could not connect to the database. $info";
            break;
        case 'DB04':
            echo "Could not connect to MySQL. $info";
            break;
            // Database Fail: With Binding
        case 'DB10':
            echo "No information variables are given while this is needed!";
            break;
        case 'DB11':
            echo "You have to give more information variables for this statement! You need to have $info variables.";
            break;
        case 'DB12':
            echo "You have to set chars for each bind parameter to execute this statement! \nChoose between 's' (string), 'i' (integer), 'd' (double) or 'b' (blob).";
            break;
        case 'DB13':
            echo "You have to give more / less chars for this statement! You need to have $info chars.";
            break;
        case 'DB14':
            echo "Cannot bind the parameters for this statement. $info";
            break;
        case 'DB15':
            echo "You have given invalid chars as bind chars! You only can choose between: 's' (string), 'i' (integer), 'd' (double) or 'b' (blob).";
            break;
        default:
            echo "Something went wrong";
            break;
    }
}

 /**
 * Function stmtExec
 * Function to execute query
 * @param   string           $sql: Give the sql query to execute                                                                                    
 * @param   int              $failCode: Use a code for fail messages, You can easily create 1 above                           
 * @param   ...              $BindParamVars: Use this when need to use WHERE conditions -> Use known DB variables    
 * @return  boolean/object   $results 
 */
function stmtExec(string $sql = "", int $failCode = 0, ...$bindParamVars) {
    //Require env.php
    require_once('env.php');

    // Create connection
    if ($conn = connectDB()) {

        // Check if the statement can be prepared
        if ($stmt = mysqli_prepare($conn, $sql)) {

            // Check if the statement needs to bind
            if (substr_count($sql, "?")) {

                // Check if the given params for binding in the query is the same as
                // The total binding places
                if (count($bindParamVars) == substr_count($sql, "?")) {

                    // Initialize $paramChars, for the binding params
                    $paramChars = "";

                    // Check each variables their data types for the
                    // Right char
                    foreach ($bindParamVars as $var) {
                        if (is_int($var)) {
                            $paramChars .= "i";
                        } else if (is_string($var)) {
                            $paramChars .= "s";
                        } else if (is_double($var)) {
                            $paramChars .= "d";
                        } else {
                            $paramChars .= "b";
                        }
                    }

                    // Check if it's NOT possible to bind
                    if (!mysqli_stmt_bind_param($stmt, $paramChars, ...$bindParamVars)) {
                        fail("DB" . $failCode . "4", mysqli_error($conn));
                        return false;
                    }
                } else {
                    // If not enough binding variables
                    fail("DB11", substr_count($sql, "?"));
                    return false;
                }
            }

            // Check if it can be executed
            if (mysqli_stmt_execute($stmt)) {

                // sets lastinserted id back into the session
                $_SESSION['lastInsertedId'] = mysqli_insert_id($conn);

                // Store results
                mysqli_stmt_store_result($stmt);

                // Check if there are any results
                if (mysqli_stmt_num_rows($stmt) > 0) {

                    // This piece of code just gets the names of the SELECT statement
                    // So there are logic variables to bind to the results

                    $sql = str_replace("DISTINCT ", "", $sql);
                    $totalFromKey = substr_count($sql, "FROM");
                    $totalEndKey = substr_count($sql, ")");
                    $totalOpenKey = substr_count($sql, "(");

                    // Check FROM
                    for ($i = 0; $i < $totalFromKey; $i++) {
                        if ($i === 0) {
                            $posFromKey[$i] = strpos($sql, "FROM");
                        } else {
                            $posFromKey[$i] = strpos($sql, "FROM", $posFromKey[$i - 1] + 1);
                            if ($i - 1 >= 0 && $posFromKey[$i] == $posFromKey[$i - 1]) {
                                $posFromKey[$i] = strpos($sql, "FROM", $posFromKey[$i - 1] + 1);
                            }
                        }
                    }

                    // Check nested query open sign
                    for ($i = 0; $i < $totalOpenKey; $i++) {
                        if ($i === 0) {
                            $posOpenKey[$i] = strpos($sql, "(");
                        } else {
                            $posOpenKey[$i] = strpos($sql, "(", $posOpenKey[$i - 1] + 1);
                            if ($i - 1 >= 0 && $posOpenKey[$i] == $posOpenKey[$i - 1]) {
                                $posOpenKey[$i] = strpos($sql, "(", $posOpenKey[$i - 1] + 1);
                            }
                        }
                    }

                    // Check nested query end sign
                    for ($i = 0; $i < $totalEndKey; $i++) {
                        if ($i === 0) {
                            $posEndKey[$i] = strpos($sql, ")");
                        } else {
                            $posEndKey[$i] = strpos($sql, ")", $posEndKey[$i - 1] + 1);
                            if ($i - 1 >= 0 && $posEndKey[$i] == $posEndKey[$i - 1]) {
                                $posEndKey[$i] = strpos($sql, ")", $posEndKey[$i - 1] + 1);
                            }
                        }
                    }

                    // Get Right positions in nested queries and form for array values
                    for ($k = 0; $k < count($posFromKey); $k++) {
                        $posFrom = $posFromKey[$k];
                        if (!empty($posEndKey) && !empty($posOpenKey)) {

                            if ($posOpenKey[0] > $posFromKey[0]) {
                                goto finish;
                            }

                            for ($i = 0; $i < count($posOpenKey); $i++) {
                                $posOpen = $posOpenKey[$i];
                                $posEnd = $posEndKey[$i];

                                if ($posFrom > $posEnd && $posEnd > $posOpen) {
                                    if ($i + 1 < $totalOpenKey && $posOpenKey[$i + 1] > $posFrom && $posEndKey[$i + 1] > $posOpenKey[$i + 1]) {
                                        goto finish;
                                    } else if ($i + 1 == $totalOpenKey) {
                                        goto finish;
                                    }
                                } else {
                                    $posFrom = 0;
                                }
                            }
                        }
                    }
                    finish:
                    if ($posFrom != 0) {
                        $selectResults = substr($sql, 7, $posFrom - 8);
                    } else {
                        $selectResults = substr($sql, 7);
                    }

                    $selectResults = explode(",", $selectResults);

                    for ($i = 0; $i < count($selectResults); $i++) {
                        if (str_contains($selectResults[$i], " AS ")) {
                            $selectResults[$i] = substr($selectResults[$i], strpos($selectResults[$i], " AS ") + 4);
                        }
                        $selectResults[$i] = str_replace('\s', '', $selectResults[$i]);
                        $selectResults[$i] = trim($selectResults[$i]);
                        $bindResults[] = $selectResults[$i];
                    }

                    // Bind results to the variables
                    if (mysqli_stmt_bind_result($stmt, ...$bindResults)) {
                        $i = 0;
                        while (mysqli_stmt_fetch($stmt)) {
                            $j = 0;
                            foreach ($bindResults as $result) {
                                $results[$selectResults[$j]][] = $result;
                                $j++;
                            }
                            $i++;
                        }
                        mysqli_stmt_close($stmt);
                        return $results;
                    } else {
                        fail("DB" . $failCode . "2", mysqli_error($conn));
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                // Execution error
                fail("DB" . $failCode . "1", mysqli_error($conn));
                return false;
            }
        } else {
            // Preperation error
            fail("DB00", mysqli_error($conn));
            return false;
        }

        // Close connection
        mysqli_close($conn);
    } else {
        // Fail connection
        fail("DB04", mysqli_error($conn));
        return false;
    }
}

/**
 * Function checkLoginFields
 * Function to check if fields are correct and not empty.
 * @param String $username Filled in username
 * @param String $email Filled in email
 * @param String $password1 Filled in password
 * @param array $error Array with errors
 * @return Array/boolean $error False or error message
 */
function checkLoginFields(String $username, String $password) {
    //Call global variable(s)
    $error = array();

    //If statements so the error messages will be displayed all at once instead of each individual.
    if (!$username && empty($username)) {
        $error[] = 'Gebruikersnaam is niet correct!';
    }
    if (strlen($username) > 50) {
        $error[] = 'Gebruikersnaam is te lang!';
    }
    if (!$password && empty($password)) {
        $error[] = 'Wachtwoord mag niet leeg zijn!';
    }
    if (strlen($password) > 200) {
        $error[] = 'Wachtwoord is te lang!';
    }

    if (empty($error)) {
        return false;
    } else {
        return $_SESSION['ERROR_MESSAGE'] = $error;
    }
}

/**
 * Function checkRegisterFields
 * Function to check if fields are correct and not empty.
 * @param string    $email  Filled in email
 * @param string    $firstname  Filled in firstname
 * @param string    $lastname  Filled in lastname
 * @param string    $password  Filled in password
 * @param string    $password2  Filled in password2
 * @param array     $error  Array with errors
 * @return Array/boolean  $error  False or error message
 */
function checkRegisterFields(string $username, string $email, string $password, string $password2) {
    //Call global variable(s)
    $error = array();

    //If statements so the error messages will be displayed all at once instead of each individual.
    if (!$username && empty($username)) {
        $error[] = 'Gebruikersnaam mag niet leeg zijn!';
    }
    if (!$email && empty($email)) {
        $error[] = 'Email is onjuist!';
    }
    if (!$password && empty($password)) {
        $error[] = 'Wachtwoord mag niet leeg zijn!';
    }
    if (!$password2 && empty($password2)) {
        $error[] = 'Wachtwoord herhalen mag niet leeg zijn!';
    }
    if ($password != $password2) {
        $error[] = 'Wachtwoorden komen niet overeen!';
    }
    if (!preg_match('/^[A-Za-z][A-Za-z0-9]{0,49}$/', $username)) {
        $error[] = 'Gebruikersnaam voldoet niet aan de standaarden!';
    }
    if (!preg_match('/^[A-Za-z][A-Za-z0-9]{0,254}$/', $password)) {
        $error[] = 'Wachtwoord voldoet niet aan de standaarden!';
    }
    if (strlen($email) > 200) {
        $error[] = 'E-mail is te lang!';
    }

    if (empty($error)) {
        return false;
    } else {
        return $_SESSION['ERROR_MESSAGE'] = $error;
    }
}

/**
 * Function checkProfileFields
 * Function to check if fields are correct and not empty.
 * @param string            $username  Filled in firstname
 * @param string            $email  Filled in email 
 * @param string            $password  Filled in password
 * @param string            $password2  Filled in password2
 * @return Array/boolean   $error  False or error message
 */
function checkProfileFields(string $username, string $email, string $password, string $password2) {
    //Call global variable(s)
    $error = array();

    //If statements so the error messages will be displayed all at once instead of each individual.
    if (!$username && empty($username)) {
        $error[] = 'Gebruikersnaam mag niet leeg zijn!';
    }
    if (!$email && empty($email)) {
        $error[] = 'Email is onjuist!';
    }
    if (!$password && empty($password)) {
        $error[] = 'Wachtwoord mag niet leeg zijn!';
    }
    if (!$password2 && empty($password2)) {
        $error[] = 'Wachtwoord herhalen mag niet leeg zijn!';
    }
    if ($password != $password2) {
        $error[] = 'Wachtwoorden komen niet overeen!';
    }
    if (strlen($email) > 200) {
        $error[] = 'E-mail is te lang!';
    }
    if (strlen($username) > 50) {
        $error[] = 'Gebruikersnaam is te lang!';
    }
    if (strlen($password) > 255) {
        $error[] = 'Wachtwoord is te lang!';
    }

    if (empty($error)) {
        return false;
    } else {
        return $_SESSION['ERROR_MESSAGE'] = $error;
    }
}

/**
 * Function checkProfilePassword
 * Function to check if fields are correct and not empty.
 * @param string          $newPassword
 * @param string          $repeatPassword
 * @return boolean/array  $error  False or error message
 */
function checkProfilePassword($newPassword, $repeatPassword) {
    $error = array();

    if ($newPassword != $repeatPassword) {
        $error[] = 'Het nieuwe wachtwoord en de herhaal wachtwoord velden komen niet overeen.';
    }
    if (empty($newPassword)) {
        $error[] = 'Nieuw wachtwoord mag niet leeg zijn!';
    }
    if (empty($repeatPassword)) {
        $error[] = 'Wachtwoord herhalen mag niet leeg zijn!';
    }

    if (empty($error)) {
        return true;
    } else {
        $_SESSION['ERROR_MESSAGE'] = $error;
        return false;
    }
}

/**
 * Function checkUserInDatabase
 * Function to check if user already exists in database
 * @param   string          $username  Filled in username
 * @param   string          $email     Filled in email
 * @param   boolean         $profile   check if this is profile page
 * @return  boolean/array   $error  False or error message
 */
function checkUserInDataBase(string $username, string $email, $profile = false) {
    //Call global variable(s)
    $error = array();

    //SQL Query for selecting all users where an email is in DB
    if ($profile) {
        $sql = "SELECT username, email FROM account WHERE username = ? AND email = ?";
    } else {
        $sql = "SELECT username, email FROM account WHERE username = ? OR email = ?";
    }

    $results = stmtExec($sql, 0, $username, $email);

    //Check if a result has been found
    if (is_array($results) && count($results) > 0) {
        for ($i = 0; $i < count($results["email"]); $i++) {
            $email = $results['email'][$i];

            if ($email == filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)) {
                $error[] = 'Er bestaat al een account met deze email';
            }
        }

        for ($i = 0; $i < count($results["username"]); $i++) {
            $username = $results['username'][$i];

            if ($username == filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS)) {
                $error[] = 'Er bestaat al een gebruiker met deze gebruikersnaam';
            }
        }

        return $_SESSION['ERROR_MESSAGE'] = $error;
    } else {
        return false;
    }
}


/**
 * Function includeHeader
 * Function to include header with correct map structure
 * @param  string    $sort
 * @return object    require_once
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
 * Function includeHead
 * Function to include header with correct map structure
 * @param  string    $sort
 * @return object    require_once
 */
function includeHead(String $sort) {
    $_SESSION['sort'] = $sort;
    if ($sort == 'page') {
        require_once('../components/head.php');
    } else {
        require_once('components/head.php');
    }
}

/**
 * Function checkValidDate
 * Function to check if date is valid
 * @param  string    $date
 * @return boolean
 */
function checkValidDate(String $date) {
    $today = date('Y-m-d\TH:i');

    //Check if filled in date is older then today.
    if ($date < $today) {
        return false;
    }

    //Check if date format is correct
    if (preg_match("/^(000[1-9]|00[1-9]\d|0[1-9]\d\d|100\d|10[1-9]\d|1[1-9]\d{2}|[2-9]\d{3}|[1-9]\d{4}|1\d{5}|2[0-6]\d{4}|27[0-4]\d{3}|275[0-6]\d{2}|2757[0-5]\d|275760)-(0[1-9]|1[012])-(0[1-9]|[12]\d|3[01])T(0\d|1\d|2[0-4]):(0\d|[1-5]\d)(?::(0\d|[1-5]\d))?(?:.(00\d|0[1-9]\d|[1-9]\d{2}))?$/", $date)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Function formatdate
 * Function to format a date
 * @param  string    $date
 * @return string
 */
function formatdate(string $date): string {
    switch (date("F", strtotime($date))) {
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
 * Function showEvents
 * Function to show events as HTML
 * @param  boolean    $limit
 * @param  boolean    $admin
 * @param  boolean    $start
 * @return HTML
 */
function showEvents(bool $limit = false, bool $admin = false, $start = false) {
    $query = "SELECT id, name, date, description
              FROM event 
              WHERE date > NOW()
              AND type = 'public'
              ORDER BY date ASC ";

    $query .= ($limit) ? "LIMIT 4" : "";

    $eventResults = stmtExec($query);

    if (!empty($eventResults["id"])) {
        $ids = $eventResults["id"];

        for ($i = 0; $i < count($ids); $i++) {
            $name = $eventResults["name"][$i];
            $eventDate = $eventResults["date"][$i];
            $description = $eventResults["description"][$i];
            $id = $eventResults["id"][$i];

            if ($admin) {
                echo '
                <div class="col-sm-3 mb-4">
                    <div class="card eventsCard">
                        <div class="card-body">
                            <span class="calendarDate d-block text-lowercase">' . formatdate($eventDate) . '</span>
                            <span class="calendarTitle d-block text-capitalize"><a href="../pages/admin.php?points&eventId=' . $id . '" class="text-white stretched-link">' . $name . '</a></span>
                            <span class="calendarInfo mt-4 d-block">' . $description . '</span>    
                        </div>
                    </div>
                </div>
                ';
            } else if ($start) {
                echo '
                <div class="col-sm-3 mb-4">
                    <div class="card eventsCard">
                        <div class="card-body">
                            <span class="calendarDate d-block text-lowercase">' . formatdate($eventDate) . '</span>
                            <span class="calendarTitle d-block text-capitalize">' . $name . '</span>
                            <form action="" method="post">
                                <button class="bg-success border-0 rounded text-light p-1 me-3 mt-3 mb-3" type="submit" name="startEvent" value="' . $id . '">Start</button>
                                <button class="bg-danger border-0 rounded text-light p-1 me-3 mt-3 mb-3" type="submit" name="stopEvent" value="' . $id . '">Stop</button>
                            </form>
                        </div>
                    </div>
                </div>
                ';
            } else {
                echo '
                <div class="col-sm-3 mb-4">
                <div class="card eventsCard">
                    <div class="card-body">
                        <span class="calendarDate d-block text-lowercase">' . formatdate($eventDate) . '</span>
                        <span class="calendarTitle d-block text-capitalize">' . $name . '</span>
                        <span class="calendarInfo mt-4 d-block">' . $description . '</span>
                    </div>
                </div>
            </div>';
            }
        }
    } else {
        echo '
        <div class="col-sm-12 mb-4">
            <div class="card eventsCard">
                <div class="card-body text-center">
                    <span class="calendarTitle d-block text-white">Er zijn op het moment geen opkomende evenementen</span>
                </div>
            </div>
        </div>
        ';
    }
}

/**
 * Function eventTimeDescent
 * Function which shows the amount of time that's left until the event, displayed through {days, hours, minutes, seconds}
 * @return String $typedOutDate
 */
function eventTimeDescent() {
    $query = "SELECT    date
              FROM      `event`
              WHERE     NOW() <= date;
    ";
    $results = stmtExec($query);

    foreach ($results as $date) {
        foreach ($date as $typedOutDate) {
            return $typedOutDate;
        }
    }
}

/**
 * Function getLivestream
 * Function to get the livestream
 * @return HTML
 */
function getLivestream() {
    $query = "SELECT name
              FROM `event`
              WHERE active = 1";
    $results = stmtExec($query, 0);
    if ($results == 1) {
        echo '<div class="col-md-12 p-0">
                  <div class="alert alert-danger text-center text-black fw-bold p-4 mb-3 rounded" role="alert">
                      Er is op het moment geen livestream actief!
                  </div>
              </div>';
    } else {
        return '
            <img
            src="http://foscam.serverict.nl/mjpg/1/video.mjpg?1647876232941&Axis-Orig-Sw=true">
            ';
    }
}

/**
 * Function multiPoll
 * this function is there to activate another function if conditions are met
 * @param  String    $question
 * @param  String    $questionType
 * @param  String    $answer1
 * @param  String    $answer2
 * @param  String    $answer3
 * @param  String    $answer4
 * @param  String    $answer5
 * @return String
 */
function multiPoll($question, $questionType, $answer1, $answer2, $answer3, $answer4, $answer5) {

    if (!empty($question)) {
        if ($questionType == "multiChoice") {
            multiChoicePoll($question, $questionType, $answer1, $answer2, $answer3, $answer4);
        } else if ($questionType == "yesOrNo") {
            yesOrNoPoll($question, $questionType, $answer1, $answer2);
        } else if ($questionType == "voteForBot") {
            voteForBotPoll($question, $questionType, $answer1, $answer2, $answer3, $answer4, $answer5);
        } else {
            return "Deze optie bestaat niet";
        }
    } else {
        return "De vraag kan niet leeg zijn";
    }
}

/**
 * Function multiChoicePoll
 * this function INSERTS a question into the database if certain conditions are met
 * @param  String    $question
 * @param  String    $questionType
 * @param  String    $answer1
 * @param  String    $answer2
 * @param  String    $answer3
 * @param  String    $answer4
 * @return String
 */
function multiChoicePoll($question, $questionType, $answer1, $answer2, $answer3, $answer4) {

    if (!empty($answer1)) {
        if (!empty($answer2)) {
            if (!empty($answer3)) {
                if (!empty($answer4)) {
                    $query = "INSERT INTO `poll` (questionType,question,answer1,answer2,answer3,answer4,answer5,pollOutcome,active) 
                                VALUES (?,?,?,?,?,?,NULL,NULL,1)";

                    stmtExec($query, 0, $questionType, $question, $answer1, $answer2, $answer3, $answer4);
                } else {
                    return "Het antwoord mag niet leeg zijn voor dit vraag type!";
                }
            } else {
                return "Het antwoord mag niet leeg zijn voor dit vraag type!";
            }
        } else {
            return "Het antwoord mag niet leeg zijn voor dit vraag type!";
        }
    } else {
        return "Het antwoord mag niet leeg zijn voor dit vraag type!";
    }
}

/**
 * Function yesOrNoPoll
 * this function INSERTS a question into the database if certain conditions are met
 * @param  String    $question
 * @param  String    $questionType
 * @param  String    $answer1
 * @param  String    $answer2
 * @return String
 */
function yesOrNoPoll($question, $questionType, $answer1, $answer2) {

    if (!empty($answer1)) {
        if (!empty($answer2)) {
            $query = "INSERT INTO `poll` (questionType,question,answer1,answer2,answer3,answer4,answer5,pollOutcome,active) 
            VALUES (?,?,?,?,NULL,NULL,NULL,NULL,1)";

            stmtExec($query, 0, $questionType, $question, $answer1, $answer2);
        } else {
            return "Het antwoord mag niet leeg zijn voor dit vraag type!";
        }
    } else {
        return "Het antwoord mag niet leeg zijn voor dit vraag type!";
    }
}

/**
 * Function voteForBotPoll
 * this function INSERTS a question into the database if certain conditions are met
 * @param  String    $question
 * @param  String    $questionType
 * @param  String    $answer1
 * @param  String    $answer2
 * @param  String    $answer3
 * @param  String    $answer4
 * @param  String    $answer5
 * @return String
 */
function voteForBotPoll($question, $questionType, $answer1, $answer2, $answer3, $answer4, $answer5) {

    if (!empty($answer1)) {
        if (!empty($answer2)) {
            if (!empty($answer3)) {
                if (!empty($answer4)) {
                    if (!empty($answer5)) {
                        $query = "INSERT INTO `poll` (questionType,question,answer1,answer2,answer3,answer4,answer5,pollOutcome,active) 
                        VALUES (?,?,?,?,?,?,?,NULL,1)";

                        stmtExec($query, 0, $questionType, $question, $answer1, $answer2, $answer3, $answer4, $answer5);
                    } else {
                        return "Het antwoord mag niet leeg zijn voor dit vraag type!";
                    }
                } else {
                    return "Het antwoord mag niet leeg zijn voor dit vraag type!";
                }
            } else {
                return "Het antwoord mag niet leeg zijn voor dit vraag type!";
            }
        } else {
            return "Het antwoord mag niet leeg zijn voor dit vraag type!";
        }
    } else {
        return "Het antwoord mag niet leeg zijn voor dit vraag type!";
    }
}

/**
 * Function retrieveQuestionInfo
 * this function retrieves the question and answers from the database if the conditions are met
 * it shows all possible answers depending on which question is retrieved
 * @return HTML
 */
function retrieveQuestionInfo() {

    $query = "SELECT question, answer1, answer2, answer3, answer4, answer5, active FROM poll WHERE active = 1";

    $results = stmtExec($query);

    $questionnaire = "";

    if (!empty($results['active'][0])) {
        if ($results['active'][0] != NULL) {

            $questionnaire .= '<h4>De vraag luid: ' . $results['question'][0] . '</h4>';
            $questionnaire .= '<input type="radio" id="question1" class="custom-control-input mt-3" name="questionAnswer" value="' . $results['answer1'][0] . '">';
            $questionnaire .= '<label class="custom-control-label" for="question1">' . $results['answer1'][0] . '</label> <br>';
            $questionnaire .= '<input type="radio" id="question2" class="custom-control-input mt-3" name="questionAnswer" value="' . $results['answer2'][0] . '">';
            $questionnaire .= '<label class="custom-control-label" for="question2">' . $results['answer2'][0] . '</label> <br>';
            if ($results['answer3'][0] != NULL) {
                $questionnaire .= '<input type="radio" id="question3" class="custom-control-input mt-3" name="questionAnswer" value="' . $results['answer3'][0] . '">';
                $questionnaire .= '<label class="custom-control-label" for="question3">' . $results['answer3'][0] . '</label> <br>';
            }
            if ($results['answer4'][0] != NULL) {
                $questionnaire .= '<input type="radio" id="question4" class="custom-control-input mt-3" name="questionAnswer" value="' . $results['answer4'][0] . '">';
                $questionnaire .= '<label class="custom-control-label" for="question4">' . $results['answer4'][0] . '</label> <br>';
            }
            if ($results['answer5'][0] != NULL) {
                $questionnaire .= '<input type="radio" id="question5" class="custom-control-input mt-3" name="questionAnswer" value="' . $results['answer5'][0] . '">';
                $questionnaire .= '<label class="custom-control-label" for="question5">' . $results['answer5'][0] . '</label> <br>';
            }

            return $questionnaire;
        } else {
            return "<h5 class='alert alert-danger mt-3'>Er is op het moment geen poll actief!</h5>";
        }
    } else {
        return "<h5 class='alert alert-danger mt-3'>Er is op het moment geen poll actief!</h5>";
    }
}

/**
 * Function pollUserCheck
 * @param  String    $username
 * @param  String    $givenAnswer
 * @return boolean
 */
function pollUserCheck($username, $givenAnswer) {

    $checkUserPoll = "SELECT userName FROM `poll-outcome`";

    $usersOffPoll = stmtExec($checkUserPoll);

    $checkUserAccount = "SELECT username FROM `account` WHERE username = ?  ";

    $usersOffAccount = stmtExec($checkUserAccount, 0, $username);

    if (empty($usersOffPoll['userName'])) {

        $query =  "INSERT INTO `poll-outcome` (userName,`givenAnswer`) VALUES (?,?)";

        if (!empty($username) && !empty($givenAnswer)) {
            stmtExec($query, 0, $username, $givenAnswer);

            $getInsertedUser = "SELECT userName FROM `poll-outcome`";

            $users = stmtExec($getInsertedUser);

            $insertPoints = "UPDATE `account` SET points = points + 3 WHERE userName = ?";

            foreach ($users['userName'] as $user) {
                stmtExec($insertPoints, 0, $user);
            }
        }
    } else {
        foreach ($usersOffPoll['userName'] as $userResponse) {
            foreach ($usersOffAccount['username'] as $userAccount) {
                if (ucfirst(strtolower($userResponse)) != ucfirst(strtolower($userAccount))) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}

/**
 * Function pollAddUser
 * this function adds a user which has answered a question of the poll within that moment
 * @param  String    $username
 * @param  String    $givenAnswer
 */
function pollAddUser($username, $givenAnswer) {

    if (pollUserCheck($username, $givenAnswer) == true) {

        $query = "INSERT INTO `poll-outcome` (userName,`givenAnswer`) VALUES (?,?)";

        if (!empty($username) && !empty($givenAnswer)) {
            stmtExec($query, 0, $username, $givenAnswer);

            $getInsertedUser = "SELECT userName FROM `poll-outcome`";

            $users = stmtExec($getInsertedUser);

            $insertPoints = "UPDATE `account` SET points = points + 3 WHERE userName = ?";

            foreach ($users['userName'] as $user) {
                stmtExec($insertPoints, 0, $user);
            }
        }
    }
}

/**
 * Function endPoll
 * this function ends the poll which has been activated
 */
function endPoll() {

    $changeActive = "UPDATE `poll` SET active = NULL WHERE active = 1";

    stmtExec($changeActive, 0);

    $deletePollOutcome = "TRUNCATE TABLE `poll-outcome`";

    stmtExec($deletePollOutcome, 0);
}

/**
 * Function checkIfPoll
 * this function checks if there is a poll and shows an input if the conditions have been met
 * @return HTML/String
 */
function checkIfPoll() {
    $checkIfPoll = "SELECT  active FROM poll";

    $getActive = stmtExec($checkIfPoll);

    if (!empty($getActive['active'])) {
        foreach ($getActive['active'] as $active) {
            if ($active == 1) {
                return '<input type="submit" name="endPoll" class="btn btn-danger mt-3" value="eindig poll" />';
            } else {
                return "Er is op het moment geen poll actief!";
            }
        }
    }
}

//This function shows the answers of the user who have participated in the poll in percentage
function pollQuestionAnswer() {

    $voteArray = [];

    $query = "SELECT    userName, givenAnswer
              FROM      `poll-outcome`
             ";

    $results = stmtExec($query);

    if (!empty($results['givenAnswer'])) {

        foreach ($results['givenAnswer'] as $postQuestion) {
            array_push($voteArray, $postQuestion);
        }
    }

    $values = array_count_values($voteArray);

    $progressBar = '';

    foreach ($values as $number) {

        $percentage = ($number / 100) * 100;

        $progressBar .= '<div class="progress mt-3">';
        $progressBar .= '<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="100" style="width:' . $percentage . '%">';
        $progressBar .= $percentage . "%";
        $progressBar .= '</div>';
        $progressBar .= '</div>';
    }

    return $progressBar;
}

function getProfileInfo() {
    $query = "SELECT    username,
                        email,
                        password
                FROM    `account`
                WHERE   id = ?
            ";
    return stmtExec($query, 0, $_SESSION['id']);
}
/**
 * Function to get all robots
 * 
 * @return Array Array of all robots with names from db
 */
function getAllRobots() {
    $conn = connectDB();
    $arr = array();

    //Creating a table
    $query = "SELECT * FROM bot";

    //Prpeparing SQL Query with database connection
    if (!$stmt = mysqli_prepare($conn, $query)) {
        $_SESSION['error'] = "database_error";
        header("location: error.php");
    }

    //Executing statement
    if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['error'] = "database_error";
        header("location: error.php");
    }

    //Bind the STMT results(sql statement) to variables
    mysqli_stmt_bind_result($stmt, $id, $statsId, $specsId, $name, $description, $imagePath);

    while (mysqli_stmt_fetch($stmt)) {
        $arr[] = ['id' => $id, 'statsId' => $statsId, 'specsId' => $specsId, 'name' => $name, 'description' => $description, 'imagePath' => $imagePath];
    }

    return $arr;
}

function getAllTeams() {
    $conn = connectDB();
    $arr = array();

    //Creating a table
    $query = "SELECT * FROM team";

    //Prpeparing SQL Query with database connection
    if (!$stmt = mysqli_prepare($conn, $query)) {
        $_SESSION['error'] = "database_error";
        header("location: error.php");
    }

    //Executing statement
    if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['error'] = "database_error";
        header("location: error.php");
    }

    //Bind the STMT results(sql statement) to variables
    mysqli_stmt_bind_result($stmt, $id, $botId, $name);

    while (mysqli_stmt_fetch($stmt)) {
        $arr[] = ['id' => $id, 'statsbotIdId' => $botId, 'name' => $name, 'name' => $name];
    }

    return $arr;
}

/**
 * Function to get all avaiable events based on robot id
 * 
 * @return Array Array of all events with names from db
 */
function getAllEvents() {
    $conn = connectDB();
    $arr = array();

    //Creating a table
    $query = "SELECT * FROM `event`";

    //Prpeparing SQL Query with database connection
    if (!$stmt = mysqli_prepare($conn, $query)) {
        $_SESSION['error'] = "database_error";
        header("location: error.php");
    }

    //Executing statement
    if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['error'] = "database_error";
        header("location: error.php");
    }

    //Bind the STMT results(sql statement) to variables
    mysqli_stmt_bind_result($stmt, $id, $name, $date, $description, $type, $active, $stream);

    while (mysqli_stmt_fetch($stmt)) {
        $arr[] = ['id' => $id, 'name' => $name, 'date' => $date, 'description' => $description, 'type' => $type, 'active' => $active];
    }

    return $arr;
}

/**
 * Function to check selected team ID
 * 
 */
function checkSelectedTeam($teamID) {
    $error = array();

    if (!$teamID && empty($teamID) || $teamID == 0) {
        $error[] = 'Kies een team!';
    }

    //Check if ID is in database
    $sql = "SELECT id, botId, name FROM team WHERE id = ?";

    //Get results from the database
    $results = stmtExec($sql, 0, $teamID);

    //Check if no result has been found
    if (is_array($results) && count($results) > 0) {
        //Do nothing
    } else {
        $error[] = 'Dit team bestaat niet!';
    }

    if (empty($error)) {
        return false;
    } else {
        return $_SESSION['ERROR_MESSAGE'] = $error;
    }
}


/**
 * Function to check selected event ID
 */
function checkSelectedEvent($eventID) {
    $error = array();

    if (!$eventID && empty($eventID) || $eventID == 0) {
        $error[] = 'Kies een evenement!';
    }

    //Check if ID is in database
    $sql = "SELECT id, name, date, description, type FROM event WHERE id = ?";

    //Get results from the database
    $results = stmtExec($sql, 0, $eventID);

    //Check if no result has been found
    if (is_array($results) && count($results) > 0 && empty($error)) {
        //Do nothing
    } else {
        $error[] = 'Dit evenement bestaat niet!';
    }

    if (empty($error)) {
        return false;
    } else {
        return $_SESSION['ERROR_MESSAGE'] = $error;
    }
}

/**
 * @param: $file: returns file object with properties
 * @return: true or false
 */
function checkIfFile($file) {
    return is_uploaded_file($file["tmp_name"]);
}

/**
 * @param: $file: returns file object with properties
 * @return: true or false
 */
function checkFileSize($file) {
    if ($file["size"] <= 5000000) {
        return true;
    } else {
        return false;
    }
}

/**
 * @param: $file: returns file object with properties
 * @return: true or false
 */
function checkFileType($file) {
    $mimeArray = ["image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "video/mp4"];
    $fileInfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file["tmp_name"]);
    if (in_array($fileInfo, $mimeArray)) {
        if (!$file["error"] > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * @param: $id: returns id
 * @param: $path: returns file path
 * @return: true or false
 */
function makeFolder(int $id, string $path) {
    $directory = $path . $id;
    if (!file_exists($directory)) {
        mkdir($directory, 0777);
    }

    return true;
}

/**
 * @param: $directory: returns directory to file
 * @param: $fileName: returns file name
 * @return: true or false
 */
function checkFileExist(string $directory, string $fileName) {
    return file_exists($directory . $fileName);
}

/**
 * @param: $directory: returns directory to file
 * @return: true
 */
function deleteFile(string $directory) {
    $files = glob($directory . '*'); // get all file names
    foreach ($files as $file) { // iterate files
        if (is_file($file)) {
            unlink($file); // delete file
        }
    }

    return true;
}

/**
 * @param: $file: returns file object with properties
 * @param: $Id int: relation ID
 * @param: $directory: returns directory
 * @return: true or false
 */
function uploadFile($file, string $query, int $id, string $directory) {
    if (move_uploaded_file($file["tmp_name"], realpath(dirname(getcwd())) . $directory . $file["name"]) && stmtExec($query, 0, $directory . $file["name"], $id)) {
        return true;
    } else {
        return false;
    }
}

function getActiveEvent() {
    $sql = "SELECT teamId, points, team.`name`, eventId 
    FROM `team-event` 
    INNER JOIN team ON team.id = `team-event`.teamId
    INNER JOIN `event` ON `team-event`.eventId = `event`.id
    WHERE `event`.active = 1";

    return stmtExec($sql);
}

function changeTeamInfo() {
    $sql = "SELECT  bot.name, bot.description, bot.imagePath, specs.board, specs.interface, team.name
            FROM    `bot`
            JOIN    `specs`     ON specs.id = bot.specsId
            JOIN    `team`      ON team.botId = bot.id  
            JOIN    `account`   ON account.teamId = team.id
            WHERE   account.username = ?       
           ";


    $botInfo = stmtExec($sql, 0, $_SESSION['username']);
    
    $returnForm = '';

    $returnForm .= '<form method="post" action="" enctype="multipart/form-data">';
        $returnForm .= '<div class="form-group">';
            $returnForm .= '<label for="teamNaam" class="mt-3">team naam</label>';
            $returnForm .= '<input type="text" id="teamNaam" class="form-control mt-3" value="'. $botInfo['team.name'][0] .'" placeholder="'. $botInfo['team.name'][0] .'" />';
            $returnForm .= '<label for="botName" class="mt-3">Bot naam</label>';
            $returnForm .= '<input type="text" id="botName" class="form-control mt-3" value="'. $botInfo['bot.name'][0] .'" placeholder="'. $botInfo['bot.name'][0] .'" />';
            $returnForm .= '<label for="botDescription" class="mt-3">bot omschrijving</label>';
            $returnForm .= '<input type="text" id="botDescription" class="form-control mt-3" value="'. $botInfo['bot.description'][0] .'" placeholder="'. $botInfo['bot.description'][0] .'" />';
            $returnForm .= '<label for="botImagePath" class="mt-3">bot foto</label>';
            $returnForm .= '<img src="..'.$botInfo['bot.imagePath'][0].'" height="100" width="100">';
            $returnForm .= '<input type="file" id="botImagePath" name="botTeamImage" class="form-control mt-3" value="..'.$botInfo['bot.imagePath'][0].'" />';
            $returnForm .= '<label for="specsBoard" class="mt-3">specificatie board</label>';
            $returnForm .= '<input type="text" id="specsBoard" class="form-control mt-3" value="'. $botInfo['specs.board'][0] .'" placeholder="'. $botInfo['specs.board'][0] .'" />';
            $returnForm .= '<label for="specsInterface" class="mt-3">specificatie interface</label>';
            $returnForm .= '<input type="text" id="specsInterface" class="form-control mt-3" value="'. $botInfo['specs.interface'][0] .'" placeholder="'. $botInfo['specs.interface'][0] .'" />';
            $returnForm .= '<input type="submit" class="btn btn-primary mt-3" value="verander info" name="playerInfoChange">';
        $returnForm .= '</div>';
    $returnForm .= '</form>';

    return $returnForm;
}
