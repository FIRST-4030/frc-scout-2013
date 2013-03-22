<?php

# Config
$DB_NAME   = 'scout';
$DSN       = 'mysql:host=localhost;unix_socket=/tmp/mysql.sock;dbname=' . $DB_NAME . ';charset=utf8';
$DB_USER   = 'root';
$DB_PASSWD = 'bobola22';
$TABLE     = 'scout';
$PAGE_ONE  = 'prematch.php';


# Start (or resume) a session. $_SESSION will now be available
session_start();
### TODO -- Stop faking a user
$_SESSION['USER_ID'] = '28804';

# Check for authentication; redirect if not logged in
if (!$_SESSION['USER_ID']) {
	header('Location: login.php');
	exit(0);
}

### TODO -- Debug
echo 'Stored MATCH_ID: ' . $_SESSION['MATCH_ID'] . "\n";

# Sanitize all incoming data (allow only a-z A-Z 0-9, underscore and space in all fields)
foreach ($_POST as $key) {
	$_POST[$key] = preg_replace('/[^\w ]/', '', $_POST[$key]);
}

# Connect to the DB
try {
	$db = new PDO($DSN, $DB_USER, $DB_PASSWD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $ex) {
	die("Unable to connect to DB\n");
}

# Set defaults for the global state
$next_page = $PAGE_ONE;
$db_stmt   = NULL;
$db_vals   = NULL;

# Prematch
if (isset($_POST['prematch_team_number'])) {

	# Force the data types
	$robot    = intval($_POST['prematch_team_number']);
	$present  = ($_POST['prematch_team_present'] ? true : false);
	$dead     = ($_POST['prematch_dead_robot'] ? true : false);
	$alliance = ($_POST['prematch_red_alliance'] ? 'RED' : 'BLUE');
	
	# Save the data
	try {
		$db->beginTransaction();
		$stmt = $db->prepare('INSERT INTO ' . $TABLE . ' (ts, user_id, robot, present, dead, alliance) VALUES (now(), ?, ?, ?, ?, ?)');
		$stmt->execute(array($_SESSION['USER_ID'], $robot, $present, $dead, $alliance));
		$_SESSION['MATCH_ID'] = $db->lastInsertId();
		if (!$_SESSION['MATCH_ID']) {
			throw new PDOException('No auto_ID returned', -1);
		}
		$db->commit();
	} catch(PDOException $ex) {
		### TODO -- Debug
		die("Unable to save data\n" . $ex->getMessage() . "\n");
	}
	
	# State for the global actions
	$next_page = 'autonomous.php';
	$db_stmt   = NULL;
	$db_vals   = NULL;


# Autonomous
} else if (isset($_POST['autonomous_top_goals'])) {
	
	# Force the data types
	$top    = intval($_POST['autonomous_top_goals']);
	$middle = intval($_POST['autonomous_middle_goals']);
	$bottom = intval($_POST['autonomous_bottom_goals']);
	$miss   = intval($_POST['autonomous_missed_goals']);	
	$kinect = ($_POST['autonomous_used_kinect'] ? true : false);
	
	# Build a query for the global action
	$db_stmt   = 'UPDATE ' . $TABLE . ' SET auto_top=?, auto_middle=?, auto_bottom=?, auto_miss=?, kinect=?';
	$db_vals   = array($top, $middle, $bottom, $miss, $kinect);
	
	# Set the next page
	$next_page = 'teleop.php';
}

# Run any DB query left for us, appending "WHERE uid=<saved match ID>"
if ($db_stmt !== NULL) {
	if ($_SESSION['MATCH_ID']) {
		try {
			$db->beginTransaction();
			$stmt = $db->prepare($db_stmt . ' WHERE uid=?');
			$db_vals[] = $_SESSION['MATCH_ID'];
			$stmt->execute($db_vals);
			$db->commit();
		} catch(PDOException $ex) {
			## TODO -- Debug
				die("Unable to save data\n" . $ex->getMessage() . "\n");
		}
	} else {
		$next_page = $PAGE_ONE;
	}
	$db_stmt = NULL;
	$db_vals = NULL;
}

# Display the next page
require 'forms/' . $next_page;

# Cleanup
$db = null;
exit(0);

?>
