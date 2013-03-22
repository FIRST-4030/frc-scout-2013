<?php

# Config
include 'includes/constants.php';
$TABLE = "scout_recording";

# Start (or resume) a session. $_SESSION will now be available
session_start();
# Check for authentication; redirect if not logged in
if (!isset($_SESSION['TeamNumber'])) {
    header('Location: /index.php?error=' . urlencode("Please login first."));
    exit(0);
}

# Sanitize all incoming data (allow only a-z A-Z 0-9, underscore and space in all fields)
foreach ($_POST as $key) {
    $_POST[$key] = preg_replace('/[^\w ]/', '', $_POST[$key]);
}

# Connect to the DB
try {
    $db = new PDO(DSN, DB_USER, DB_PASSWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Unable to connect to DB\n");
}

# Set defaults for the global state
$next_page = "prematch.php";
$db_stmt = NULL;
$db_vals = NULL;

# Prematch
if (isset($_POST['prematch_team_number'])) {

    # Force the data types
    $scoutedTeamNumber = intval($_POST['prematch_team_number']);
    $present = ($_POST['prematch_team_present'] ? true : false);
    $dead = ($_POST['prematch_dead_robot'] ? true : false);
    $alliance = ($_POST['prematch_red_alliance'] ? 'RED' : 'BLUE');

    # Save the data
    try {
        $db->beginTransaction();
        $stmt = $db->prepare('INSERT INTO ' . $TABLE . ' (ts, user_id, scouted_team_number, present, dead, alliance) VALUES (now(), ?, ?, ?, ?, ?)');
        $stmt->execute(array($_SESSION['UserID'], $scoutedTeamNumber, $present, $dead, $alliance));
        $_SESSION['MATCH_ID'] = $db->lastInsertId();
        if (!$_SESSION['MATCH_ID']) {
            throw new PDOException('No auto_ID returned', -1);
        }
        $db->commit();
    } catch (PDOException $ex) {
        ### TODO -- Debug
        die("Unable to save data\n" . $ex->getMessage() . "\n");
    }

    # State for the global actions
    $next_page = 'autonomous.php';
    $db_stmt = NULL;
    $db_vals = NULL;


# Autonomous
} else if (isset($_POST['autonomous_top_goals'])) {

    # Force the data types
    $top = intval($_POST['autonomous_top_goals']);
    $middle = intval($_POST['autonomous_middle_goals']);
    $bottom = intval($_POST['autonomous_bottom_goals']);
    $miss = intval($_POST['autonomous_missed_goals']);
    $kinect = ($_POST['autonomous_used_kinect'] == "true" ? true : false);

    # Build a query for the global action
    $db_stmt = 'UPDATE ' . $TABLE . ' SET auto_top=?, auto_middle=?, auto_bottom=?, auto_miss=?, auto_kinect=?';
    $db_vals = array($top, $middle, $bottom, $miss, $kinect);

    # Set the next page
    $next_page = 'teleop.php';
}
#Teleop
else if (isset($_POST['teleop_can_pickup_frisbees'])) {
    # Force the data types
    $frisbeePickup = ($_POST['teleop_can_pickup_frisbees'] == "true" ? true : false);
    $top = intval($_POST['teleop_top_goals']);
    $middle = intval($_POST['teleop_middle_goals']);
    $bottom = intval($_POST['teleop_bottom_goals']);
    $miss = intval($_POST['teleop_missed_goals']);
    $block = intval($_POST['teleop_missed_goals']);
    $pyramid = intval($_POST['teleop_missed_goals']);
    $shootingRange = intval($_POST['teleop_shooting_range']);
    $robotSpeed = intval($_POST['teleop_robot_speed']);
    $robotManeuverability = intval($_POST['teleop_robot_maneuverability']);


    $db_stmt = 'UPDATE ' . $TABLE . ' SET teleop_frisbee_pickup=?, teleop_top=?, teleop_middle=?, 
        teleop_bottom=?, teleop_miss=?, teleop_blocked=?, teleop_pyramid=?, teleop_shooting_range=?,
        teleop_robot_speed=?, teleop_robot_steering=?';
    $db_vals = array($frisbeePickup, $top, $middle, $bottom, $miss, $block, $pyramid, $shootingRange, $robotSpeed, $robotManeuverability);

    # Set the next page
    $next_page = 'climb.php';
} else if (isset($_POST['climb_attempts'])) {     
    $db_stmt = "UPDATE " . $TABLE . " SET climb_attempts=?, climb_pyramid_goals=?, climb_level_reached=?, climb_style=?";
    $db_vals = array($_POST['climb_attempts'], $_POST['climb_pyramid_goals'], $_POST['climb_level_reached'], $_POST['climb_climb_style']);   
    $next_page = "results.php";
    
//        results_match_outcome SMALLINT NOT NULL,
//        results_fouls SMALLINT NOT NULL,
//        results_technical_fouls SMALLINT NOT NULL,
//        results_comments TEXT,
} else if (isset ($_POST['results_match_outcome'])) {
    $db_stmt = "UPDATE " . $TABLE . " SET results_match_outcome=?, results_fouls=?, results_technical_fouls=?, results_comments=?";
    $db_vals = array($_POST['results_match_outcome'], $_POST['results_fouls'], $_POST['results_technical_fouls'], $_POST['results_comments']);
}
# Final DB entry should unset MATCH_ID for safety
# Nothing explictly breaks if you don't, but it avoids potential user error
# Run any DB query left for us, appending "WHERE uid=<saved match ID>"
if ($db_stmt !== NULL) {
    if ($_SESSION['MATCH_ID']) {
        try {
            $db->beginTransaction();
            $stmt = $db->prepare($db_stmt . ' WHERE uid=?');
            $db_vals[] = $_SESSION['MATCH_ID'];
            $stmt->execute($db_vals);
            if (!$stmt->rowCount()) {
                throw new PDOException('Invalid MATCH_ID: ' . $_SESSION['MATCH_ID'], -2);
            }
            $db->commit();
        } catch (PDOException $ex) {
            ## TODO -- Debug
            die("Unable to save data\n" . $ex->getMessage() . "\n");
        }
    } else {
        $next_page = $PAGE_ONE;
    }
    $db_stmt = NULL;
    $db_vals = NULL;
}

if(isset($_POST['results_fouls'])) {
    unset($_SESSION['MATCH_ID']);
    
}

# Display the next page
require 'forms/' . $next_page;

# Cleanup
$db = null;
exit(0);
?>
