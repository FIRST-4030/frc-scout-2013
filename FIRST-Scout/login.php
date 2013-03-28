<?php

session_start();
if (isset($_GET['intent']) && $_GET['intent'] == "logout") {
    unset($_SESSION['TeamNumber']);
    unset($_SESSION['UserID']);
    unset($_SESSION['MATCH_ID']);
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
        $team_number = $teams['team_number'];
        # Login success
        $_SESSION['TeamNumber'] = $team_number;
        $_SESSION['UserID'] = $userID;
        $_SESSION['TeamID'] = $teamID;
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