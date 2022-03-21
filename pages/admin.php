<?php
//Includes
include_once('../functions/function.php');
include_once('../functions/database.php');

//Check if admin is logged in
if (!isset($_SESSION['email']) ||  $_SESSION['role'] != 2) {
    header('location: ../components/error.php');
}

//Global variables
$today = date("Y-m-d");
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

    default:
        $headerTitle = 'Event toevoegen';
        $content = "../components/admin/event.php";
        break;
}

//Post submissions
function checkEventFields($eventDate, $eventName, $eventDescription)
{
    global $error;

    if (!$eventDate && empty($eventDate)) {
        $error[] = 'Event datum mag niet leeg zijn!';
    } else {
        if (!checkValidDate($eventDate)) {
            $error[] = 'Event datum is ongeldig!';
        }
    }
    if (!$eventName && empty($eventName)) {
        $error[] = 'Event naam mag niet leeg zijn!';
    }
    if (!$eventDescription && empty($eventDescription)) {
        $error[] = 'Event omschrijving mag niet leeg zijn!';
    }
    if (strlen($eventName) > 255) {
        $error[] = 'Event naam is te lang!';
    }
    if (strlen($eventDescription) > 255) {
        $error[] = 'Event omschrijving is te lang!';
    }

    if (empty($error)) {
        return false;
    } else {
        return $error;
    }
}

if (isset($_POST['event'])) {
    //Submitted form data validation
    $eventDate = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
    $eventName = filter_input(INPUT_POST, 'eventNaam', FILTER_SANITIZE_SPECIAL_CHARS);
    $eventDescription = filter_input(INPUT_POST, 'eventOmschrijving', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!checkEventFields($eventDate, $eventName, $eventDescription)) {
        //SQL Query for inserting into user table
        $sql = "INSERT INTO event (name, date, description) VALUES (?,?,?)";
        stmtExec($sql, 0, $eventName, $eventDate, $eventDescription);

        if (!stmtExec($sql, 0, $eventName, $eventDate, $eventDescription)) {
            $_SESSION['error'] = "Cannot add event";
            header("location: ../components/error.php");
        }

        //Set succes message
        $_SESSION['succes'] = 'Event toegevoegd!';

        //Send user to index.php
        header('location: admin.php');
        exit();
    }
}

if (isset($_GET['points'])) {
    $teams = array();

    //Get all the teams from database
    $sql = "SELECT teamId, name FROM `team-event` JOIN team ON team.id = `team-event`.teamId";
    $results = stmtExec($sql);

    for($i = 1; $i < count($results); $i++) {
        $teams += [$results['teamId'][$i-1] => $results['name'][$i-1]];
    }
}

if (isset($_POST['submitPoints'])) {
    $poinsPerTeam = array();

    //Get all values from the radiobuttons
    foreach ($_POST as $radioTeamId => $assignedPoints) {
        $poinsPerTeam += [$radioTeamId => $assignedPoints];
        $sql = "UPDATE `team-event` SET points = points + ? WHERE teamId = ?";

        if (!stmtExec($sql, 0, $assignedPoints, $radioTeamId)) {
            header("location: ../components/error.php");
        }
    }

    $_SESSION['succes'] = 'Punten toegevoegd';

    header('location: admin.php?points');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('../components/head.html');
    ?>

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
                            <a class="nav-link text-white" href="admin.php?event">Event toevoegen</a>
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

                if (!empty($error)) {
                ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger text-black fw-bold p-4 rounded mb-3 alertBox" role="alert">
                                <ul class="mb-0">
                                    <?php
                                    foreach ($error as $errorMsg) {
                                        echo '<li>' . $errorMsg . '</li>';
                                    }
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