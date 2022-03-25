<?php
//Includes
include_once('../functions/function.php');

// Check if admin is logged in
if (!isset($_SESSION['email']) ||  $_SESSION['role'] != 2) {
    header('location: ../components/error.php');
}

//Global variables
$today = date('Y-m-d\TH:i');
$error = array();

//Switch for loading in content
switch (true) {
    case isset($_GET['poll']):
        $headerTitle = 'Poll toevoegen';
        $content = "../components/admin/poll.php";
        break;

    case isset($_GET['game']):
        $headerTitle = 'Games';
        $content = "../components/admin/game.php";
        break;

    case isset($_GET['points']);
        $headerTitle = 'Punten toevoegen';
        $content = "../components/admin/points.php";
        break;

    case isset($_GET['director']);
        $headerTitle = 'Regisseur pagina';
        $content = "../components/admin/director.php";
        break;
    case isset($_GET['bot']);
        $headerTitle = 'Bot toevoegen';
        $content = "../components/admin/bot.php";
        break;
    case isset($_GET['addRobotToEvent']);
        $headerTitle = 'Robot aan evenement toevoegen';
        $content = "../components/admin/addRobotToEvent.php";

    case isset($_GET['addTeamToEvent']);
        $headerTitle = 'Team aan evenement toevoegen';
        $content = "../components/admin/addTeamToEvent.php";
        break;
    case isset($_GET['startEvent']);
        $headerTitle = 'Evenement starten';
        $content = "../components/admin/startEvent.php";
        break;
    case isset($_GET['edit']);
        $headerTitle = 'Informatie wijzigen';
        $content = "../components/admin/edit.php";
        break;

    default:
        $headerTitle = 'Evenement toevoegen';
        $content = "../components/admin/event.php";
        break;
}

/**
 * Add event section
 */
function checkEventFields($eventDate, $eventName, $eventDescription, $eventType)
{
    $error = array();

    if (!$eventDate && empty($eventDate)) {
        $error[] = 'De evenement datum mag niet leeg zijn!';
    } else {
        if (!checkValidDate($eventDate)) {
            $error[] = 'De evenement datum is ongeldig!';
        }
    }
    if (!$eventDescription && empty($eventDescription)) {
        $error[] = 'De evenement omschrijving mag niet leeg zijn!';
    }
    if (!$eventName && empty($eventName)) {
        $error[] = 'De evenement naam mag niet leeg zijn!';
    }
    if (!$eventType && empty($eventType)) {
        $error[] = 'Het evenement type mag niet leeg zijn!';
    } else {
        if ($eventType == 'public' || $eventType == 'private') {
            //Do nothing
        } else {
            $error[] = 'Het evenement type klopt niet';
        }
    }

    if (empty($error)) {
        return false;
    } else {
        return $_SESSION['ERROR_MESSAGE'] = $error;
    }
}

function checkRobotFields($botName, $botDiscription, $macAdress, $botBoard, $botInterface)
{
    $error = array();

    if (!$botName && empty($botName)) {
        $error[] = 'Bot naam mag niet leeg zijn';
    }
    if (!$botDiscription && empty($botDiscription)) {
        $error[] = 'bot omschrijving mag niet leeg zijn!';
    }
    if (!$macAdress && empty($macAdress)) {
        $error[] = 'Mac adres mag niet leeg zijn!';
    }
    if (!$botBoard && empty($botBoard)) {
        $error[] = 'besturingsboard mag niet leeg zijn!';
    }
    if (!$botInterface && empty($botInterface)) {
        $error[] = 'interface mag niet leeg zijn!';
    }

    if (empty($error)) {
        return false;
    } else {
        return $_SESSION['ERROR_MESSAGE'] = $error;
    }
}

if (isset($_POST['event'])) {
    //Submitted form data validation
    $eventDate = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
    $eventName = filter_input(INPUT_POST, 'eventNaam', FILTER_SANITIZE_SPECIAL_CHARS);
    $eventType = filter_input(INPUT_POST, 'eventType', FILTER_SANITIZE_SPECIAL_CHARS);
    $eventDescription = filter_input(INPUT_POST, 'eventOmschrijving', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!checkEventFields($eventDate, $eventName, $eventDescription, $eventType)) {
        //SQL Query for inserting into user table
        $sql = "INSERT INTO event (name, date, description, type) VALUES (?,?,?,?)";

        if (!stmtExec($query, 0, $eventName, $eventDate, $eventDescription, $eventType)) {
            $_SESSION['error'] = "Cannot add event";
            header("location: ../components/error.php");
        }

        //Set succes message
        $_SESSION['succes'] = 'Het evenement is succesvol toegevoegd!';

        //Send user to index.php
        header('location: admin.php');
        exit();
    }
}

if (isset($_POST['bot'])) {
    $botName = filter_input(INPUT_POST, 'botName', FILTER_SANITIZE_SPECIAL_CHARS);
    $botDiscription = filter_input(INPUT_POST, 'botDiscription', FILTER_SANITIZE_SPECIAL_CHARS);
    $macAdress = filter_input(INPUT_POST, 'macAddress', FILTER_SANITIZE_SPECIAL_CHARS);
    $botBoard = filter_input(INPUT_POST, 'board', FILTER_SANITIZE_SPECIAL_CHARS);
    $botInterface = filter_input(INPUT_POST, 'interface', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!checkRobotFields($botName, $botDiscription, $macAdress, $botBoard, $botInterface)) {
        $sql = "INSERT INTO bot (name, description, macAddress) VALUES (?,?,?)";

        if (!stmtExec($sql, 0, $botName, $botDiscription, $macAdress)) {
            $_SESSION['ERROR_MESSAGE'] = "Voer alle velden in";
            header("location: ../components/error.php");
            exit();
        }

        $sql = "INSERT INTO specs (board, interface) VALUES (?,?)";

        if (!stmtExec($sql, 0, $botBoard, $botInterface)) {
            $_SESSION['ERROR_MESSAGE'] = "Voer alle velden in";
            header("location: ../components/error.php");
            exit();
        }

        $sql = "INSERT INTO stats (wins, playedMatches) VALUES (?,?)";

        if (!stmtExec($sql, 0, 0, 0)) {
            $_SESSION['ERROR_MESSAGE'] = "Voer alle velden in";
            header("location: ../components/error.php");
            exit();
        }


        if (checkIfFile($_FILES['botPic'])) {
            if (checkFileSize($_FILES['botPic'])) {
                if (checkFileType($_FILES['botPic'])) {
                    $botId = $_SESSION['lastInsertedId'];
                    if (makeFolder($botId, "../assets/img/bots/")) {
                        if (!checkFileExist("../assets/img/bots/" . $botId . "/", $_FILES['botPic']['name'])) {
                            $query = "UPDATE `bot`
                                                    SET imagePath = ?
                                                    WHERE id = ?
                                            ";

                            if (uploadFile($_FILES['botPic'], $query, $botId, "/assets/img/bots/{$botId}/")) {
                                $_SESSION['succes'] = 'Bot aangemaakt';
                                header("location:../pages/admin.php?bot");
                                exit();
                            } else {
                                $error[] = "Er is iets fout gegaan bij  het uploaden van het bestand";
                                $_SESSION['ERROR_MESSAGE'] = $error;
                                header('location: admin.php?bot');
                                exit();
                            }
                        } else {
                            $error[] = "Het bestand bestaat al";
                            $_SESSION['ERROR_MESSAGE'] = $error;
                            header('location: admin.php?bot');
                            exit();
                        }
                    } else {
                        $error[] = "Er is iets fout gegaan bij  het uploaden van het bestand";
                        $_SESSION['ERROR_MESSAGE'] = $error;
                        header('location: admin.php?bot');
                        exit();
                    }
                } else {
                    $error[] = "Het bestandstype wordt niet geaccepteerd";
                    $_SESSION['ERROR_MESSAGE'] = $error;
                    header('location: admin.php?bot');
                    exit();
                }
            } else {
                $error[] = "Bestand is te groot";
                $_SESSION['ERROR_MESSAGE'] = $error;
                header('location: admin.php?bot');
                exit();
            }
        } else {
            $_SESSION['succes'] =  "Bot aangemaakt";
            $_SESSION['ERROR_MESSAGE'] = $error;
            header('location: admin.php?bot');
            exit();
        }
    } else {
        header('location: admin.php?bot');
        exit();
    }
}

if (isset($_GET['points']) && isset($_GET['eventId'])) {
    $conn = connectDB();
    $teams = array();
    $eventIds = array();
    $teamPoints = array();
    $eventId = $_GET['eventId'];
    
    foreach ($_POST as $radioTeamId => $assignedPoints) {
        if (isset($_POST[$radioTeamId])) {
            $sql = "UPDATE `team-event` SET points = points + ? WHERE teamId = ?";
        }

        if (isset($_POST[$radioTeamId . 'submit'])) {
            if (is_numeric($_POST[$radioTeamId])) {
                $assignedPoints = $_POST[$radioTeamId];
                $sql = "UPDATE `team-event` SET points = ? WHERE teamId = ?";
            } else {
                $error[] = "Vul een getal in!";
            }
        }

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            header("location: ../components/error.php");
        }

        if (!mysqli_stmt_bind_param($stmt, 'ii', $assignedPoints, $radioTeamId)) {
            header('location: ../components/error.php');
        }

        if (!mysqli_stmt_execute($stmt)) {
            header('location ../components/error.php');
        }

        mysqli_stmt_close($stmt);
    }

    $sql = "SELECT teamId, `name`, eventId, points FROM `team-event` JOIN team ON team.id = `team-event`.teamId WHERE eventId = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, 'i', $eventId);

    if (!$stmt) {
        header("location: ../components/error.php");
    }

    if (!mysqli_stmt_execute($stmt)) {
        header("location: ../components/error.php");
    }

    mysqli_stmt_bind_result($stmt, $teamId, $teamName, $eventId, $points);
    mysqli_stmt_store_result($stmt);
    while (mysqli_stmt_fetch($stmt)) {
        $teams += [$teamId => $teamName];
        $teamPoints += [$teamId => $points];
        $eventIds += [$teamId => $eventId];
    }
    mysqli_stmt_close($stmt);
}

/**
 * Add team to robot section
 */
if (isset($_POST['selectedTeam'])) {
    $selectedTeam = filter_input(INPUT_POST, 'selectedTeam', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!checkSelectedTeam($selectedTeam)) {
        $_SESSION['selectedTeam'] = $selectedTeam;
        header('location: admin.php?addTeamToEvent');
    }
    header('location: admin.php?addTeamToEvent');
    exit();
}

if (isset($_POST['selectedEvent'])) {
    $selectedEvent = filter_input(INPUT_POST, 'selectedEvent', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!checkSelectedEvent($selectedEvent)) {
        //check if event & team id are already in database
        $sql = "SELECT eventId, teamId, points FROM `team-event` WHERE eventId = ? AND teamId = ?";

        //Get results from the database
        $results = stmtExec($sql, 0, $selectedEvent, $_SESSION['selectedTeam']);

        //Check if no result has been found
        if (is_array($results) && count($results) > 0) {
            $error[] = 'Dit team is al toegevoegd aan dit evenement!';
            $_SESSION['ERROR_MESSAGE'] = $error;
            unset($_SESSION['selectedTeam']);
            header('location: admin.php?addTeamToEvent');
            exit();
        } else {
            //Insert into database
            $sql = "INSERT INTO `team-event` (eventId, teamId) VALUES (?,?)";

            if (!stmtExec($sql, 0, $selectedEvent, $_SESSION['selectedTeam'])) {
                $_SESSION['error'] = "database_error";
                header("location: ../components/error.php");
            }

            unset($_SESSION['selectedTeam']);

            //Set succes message
            $_SESSION['succes'] = 'Het team is succesvol aan het evenement toegevoegd!';

            //Send user to admin.php?addTeamToEvent
            header('location: admin.php?addTeamToEvent');
            exit();
        }
    }
}

if (isset($_POST['robotEventAnnuleren'])) {
    unset($_SESSION['selectedTeam']);
    header('location: admin.php?addTeamToEvent');
}

if (isset($_POST['startEvent'])) {
    // sets all events to inactive
    $query = "UPDATE event SET active = 0";
    $result = stmtExec($query);

    // update event on active
    $query = "UPDATE event SET active = 1 WHERE id = ?";
    $id = filter_input(INPUT_POST, "startEvent", FILTER_SANITIZE_NUMBER_INT);
    $result = stmtExec($query, 0, $id);
}

if (isset($_POST['stopEvent'])) {
    $query = "UPDATE event SET active = 0 WHERE id = ?";
    $id = filter_input(INPUT_POST, "stopEvent", FILTER_SANITIZE_NUMBER_INT);
    $result = stmtExec($query, 0, $id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('../functions/function.php');
    includeHead('page'); 
    ?>
    <link href="../assets/img//logo/logo.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/admin.css">

    <title>Adminpaneel - Battlebots</title>
</head>

<body>
    <section id="header">
        <?php includeHeader('page'); ?>
    </section>

    <section id="content" class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <nav class="navbar">
                    <ul class="nav w-100 nav-fill pt-2">
                        <li class="nav-item w-100">
                            <a class="nav-link text-white" href="admin.php">Evenement toevoegen</a>
                        </li>
                        <li class="nav-item w-100">
                            <a class="nav-link text-white" href="admin.php?poll">Poll toevoegen</a>
                        </li>
                        <li class="nav-item w-100">
                            <a class="nav-link text-white" href="admin.php?game">Games</a>
                        </li>
                        <li class="nav-item w-100">
                            <a class="nav-link text-white" href="admin.php?points">Punten toevoegen</a>
                        </li>
                        <li class="nav-item w-100">
                            <a class="nav-link text-white" href="admin.php?director">Regisseur pagina</a>
                        </li>
                        <li class="nav-item w-100">
                            <a class="nav-link text-white" href="admin.php?bot">Bot toevoegen</a>
                        </li>
                        <li class="nav-item w-100">
                            <a class="nav-link text-white" href="admin.php?addTeamToEvent">Team toevoegen aan evenement</a>
                        </li>
                        <li class="nav-item w-100">
                            <a class="nav-link text-white" href="admin.php?startEvent">Evenement starten</a>
                        </li>
                        <li class="nav-item w-100">
                            <a class="nav-link text-white" href="admin.php?edit">Informatie wijzigen</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <h1><?php echo $headerTitle; ?></h1>
                    </div>
                </div>

                <?php
                if (!empty($_SESSION['succes'])) {
                ?>
                    <div class="col-md-12 p-0">
                        <div class="alert alert-success text-black fw-bold p-4 rounded-0" role="alert">
                            <ul class="mb-0">
                                <?php
                                echo '<li>' . $_SESSION['succes'] . '</li>';
                                $_SESSION['succes'] = '';
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php
                }

                if (!empty($_SESSION['ERROR_MESSAGE'])) {
                ?>
                    <div class="row" id="errorBar">
                        <div class="col-md-12">
                            <div class="alert alert-danger text-black fw-bold p-4 rounded mb-3 alertBox" role="alert">
                                <ul class="mb-0">
                                    <?php
                                    foreach ($_SESSION['ERROR_MESSAGE'] as $errorMsg) {
                                        echo '<li>' . $errorMsg . '</li>';
                                    }

                                    unset($_SESSION['ERROR_MESSAGE']);
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <?php
                        include_once($content);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>