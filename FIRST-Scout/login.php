<?php

# Do not accept or generate URL-based session IDs
# TODO: Set this globally (via apache config in .htaccess files)
ini_set('session.use_only_cookies', true);
ini_set('session.use_trans_sid', false);

session_start();
if (isset($_GET['intent']) && $_GET['intent'] == "logout") {
    unset($_SESSION['TeamNumber']);
    unset($_SESSION['UserID']);
    unset($_SESSION['MATCH_ID']);
    unset($_SESSION['Location']);
    header('location: /index.php?error=' . urlencode("Successfully logged out!"));
    exit();
}

if (isset($_POST['team_id'])) {
    require 'includes/constants.php';
    try {
        $db = new PDO(DSN, DB_USER, DB_PASSWD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        die("Unable to connect to DB\n " . $ex->getMessage());
    }

    $teamID = preg_replace('/[^\w ]/', '', $_POST['team_id']);
    $userID = preg_replace('/[^\w ]/', '', $_POST['user_id']);
    $location = preg_replace('/[^\w ]/', '', $_POST['location']);
    $teamPassword = $_POST['team_password'];

    try {
        $authenticate = $db->prepare('SELECT team_number FROM scout_login WHERE team_id = ? AND team_password = md5(?)');
        $authenticate->execute(array($teamID, $teamPassword));
        $teams = $authenticate->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        die("Unable to connect to DB\n " . $ex->getMessage());
    }

    $team_number = NULL;
    if (key_exists('team_number', $teams)) {
        # Login success
        $_SESSION['TeamNumber'] = $teams['team_number'];
        $_SESSION['UserID'] = $userID;
        $_SESSION['TeamID'] = $teamID;

	# TODO: This is not secure.
	# We should at least validate that $location exists in our list of locations.
	# We should probably also validate that it's happening around the current time.
        $_SESSION['Location'] = $location;

	# Regenerate the session ID to avoid session fixation
	session_regenerate_id();

	# Redirect to the post-login page
        header('location: options');
    } else {
        unset($_SESSION['TeamNumber']);
        unset($_SESSION['UserID']);
        unset($_SESSION['TeamID']);
        header('location: index.php?error=' . urlencode("Your username or password are incorrect."));
    }
} else {
    header("location: /index.php");
}
?>
