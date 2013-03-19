<?php
session_start();
$intent = $_GET['intent'];
if ($intent == "login") {
    $loggedInTeam = $_POST['team_id'];
    $userID = $_POST['user_id'];
    $_SESSION['TeamID'] = $loggedInTeam;
    $_SESSION['UserID'] = $userID;
    header('location: options');
} else if ($intent == "logout") {
    if (isset($_SESSION['TeamID'])) {
        session_destroy();
        header('location: index.php?error=' . urlencode("Successfully logged out!"));
    } else {

        header('location: index.php?error=' . urlencode("You weren't logged in, whoops!"));
    }
}
//print_r($_POST);
?>