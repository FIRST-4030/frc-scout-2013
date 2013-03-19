<?php

$intent = $_GET['intent'];
if ($intent == "login") {
    $loggedInTeam = $_POST['team_number'];
    $userID = $_POST['user_id'];
    setcookie("FIRSTScoutLoggedInTeam", $loggedInTeam, time() + 3600);
    setcookie("FIRSTScoutLoggedInUserID", $userID, time() + 3600);
    header('location: options');
    
} else if ($intent == "logout") {
    setcookie("FIRSTScoutLoggedInTeam", $loggedInTeam, time() - 3600);
    setcookie("FIRSTScoutLoggedInUserID", $userID, time() - 3600);
    header('location: index.php?error=' . urlencode("Successfully logged out!"));
}


//print_r($_POST);
?>