<?php

# Config
require 'includes/constants.php';
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
	if (array_key_exist($key, $_POST)) {
		$_POST[$key] = preg_replace('/[^\w ]/', '', $_POST[$key]);
	}
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
    $_SESSION['scouted_team'] = $scoutedTeamNumber;
    $present = ($_POST['prematch_team_present'] == "true" ? 1 : 0);
    $alliance = ($_POST['prematch_red_alliance'] == "true" ? 'RED' : 'BLUE');
    $teamID = $_SESSION['TeamID'];
    # Save the data
    try {
        $db->beginTransaction();
        $stmt = $db->prepare('INSERT INTO ' . $TABLE . ' (ts, user_id, team_id, scouting_team_number, scouted_team_number, present, alliance, location, match_number) VALUES (now(), ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute(array($_SESSION['UserID'], $teamID, $_SESSION['TeamNumber'], $scoutedTeamNumber, $present, $alliance, $_POST['prematch_location'], $_POST['prematch_match_number']));
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
    $scoutedTeamNumber = $_SESSION['scouted_team'];
    # Force the data types
    $top = intval($_POST['autonomous_top_goals']);
    $middle = intval($_POST['autonomous_middle_goals']);
    $bottom = intval($_POST['autonomous_bottom_goals']);
    $miss = intval($_POST['autonomous_missed_goals']);
    $kinect = ($_POST['autonomous_used_kinect'] == "true" ? 1 : 0);

    # Build a query for the global action
    $db_stmt = 'UPDATE ' . $TABLE . ' SET auto_top=?, auto_middle=?, auto_bottom=?, auto_miss=?, auto_kinect=?';
    $db_vals = array($top, $middle, $bottom, $miss, $kinect == true ? 1 : 0);

    # Set the next page
    $next_page = 'teleop.php';
}
#Teleop
else if (isset($_POST['teleop_can_pickup_frisbees'])) {
    # Force the data types
    $scoutedTeamNumber = $_SESSION['scouted_team'];
    $frisbeePickup = ($_POST['teleop_can_pickup_frisbees'] == "true" ? 1 : 0);
    $top = intval($_POST['teleop_top_goals']);
    $middle = intval($_POST['teleop_middle_goals']);
    $bottom = intval($_POST['teleop_bottom_goals']);
    $miss = intval($_POST['teleop_missed_goals']);
    $block = intval($_POST['teleop_blocked_goals'] == "true" ? 1 : 0);
    $pyramid = intval($_POST['teleop_pyramid_goals']);
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
    $scoutedTeamNumber = $_SESSION['scouted_team'];
    $db_stmt = "UPDATE " . $TABLE . " SET climb_attempts=?, climb_pyramid_goals=?, climb_level_reached=?, climb_style=?";
    $db_vals = array($_POST['climb_attempts'], $_POST['climb_pyramid_goals'], $_POST['climb_level_reached'], $_POST['climb_climb_style']);
    $next_page = "results.php";
} else if (isset($_POST['results_match_outcome'])) {
    $dead = ($_POST['results_dead_robot'] == "true" ? 1 : 0);
    $scoutedTeamNumber = $_SESSION['scouted_team'];
    $db_stmt = "UPDATE " . $TABLE . " SET results_match_outcome=?, results_fouls=?, results_technical_fouls=?, results_comments=?, dead=?";
    $db_vals = array($_POST['results_match_outcome'], $_POST['results_fouls'], $_POST['results_technical_fouls'], $_POST['results_comments'], $dead);
    $next_page = "../options?error=Entry successful!";
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
//            if (!$stmt->rowCount()) {
//                throw new PDOException('Invalid MATCH_ID: ' . $_SESSION['MATCH_ID'], -2);
//            }
            $db->commit();
        } catch (PDOException $ex) {
            ## TODO -- Debug
            die("Unable to save data\n" . $ex->getMessage() . "\n");
        }
    } else {
        $next_page = "/options?error=" . urlencode("You must start from the beginning!");
    }
    $db_stmt = NULL;
    $db_vals = NULL;
}

if (isset($_POST['results_fouls'])) {
    header("location: /options/single-match-review.php");
}

# Display the next page
require 'forms/' . $next_page;

# Cleanup
$db = null;
exit(0);
?>