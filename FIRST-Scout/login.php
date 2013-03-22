<?php
session_start();
if ($_GET['intent'] == "logout") {
    unset($_SESSION['TeamNumber']);
    unset($_SESSION['UserID']);
    header('location: /index.php?error=' . urlencode("Successfully logged out!"));
    exit();
}

if (isset($_POST['team_id'])) {
    require 'includes/constants.php';
    try {
        $db = new PDO(DSN, DB_USER, DB_PASSWD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        die("Unable to connect to DB\n " . $ex->getMessage() . "<br>" . DSN);
    }

    $teamID = preg_replace('/[^\w ]/', '', $_POST['team_id']);
    $userID = preg_replace('/[^\w ]/', '', $_POST['user_id']);
    
    $teamPassword = $_POST['team_password'];

    $authenticate = $db->prepare("SELECT team_number FROM scout_login WHERE team_id = ? AND team_password = md5(?)");
    $authenticate->execute(array($teamID, $teamPassword));
    $teams = $authenticate->fetch(PDO::FETCH_ASSOC);
    $team_number = NULL;
    if (key_exists('team_number', $teams)) {
        $team_number = $teams['team_number'];
        # Login success
        $_SESSION['TeamNumber'] = $team_number;
        $_SESSION['UserID'] = $userID;
        header('location: options');
    } else {
        unset($_SESSION['TeamNumber']);
        unset($_SESSION['UserID']);
        header('location: index.php?error=' . urlencode("Your username or password are incorrect."));
    }
} else {
    header("location: /index.php");
}
?>