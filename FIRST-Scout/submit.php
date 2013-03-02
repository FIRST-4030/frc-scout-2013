<?php
require 'includes/constants.php';

$teamNum = $_POST['team_number'];
$userEmail = $_POST['user_email'];
$userPass = $_POST['user_password'];

$teamNumInt = intval($teamNum);

if ($teamNumInt == 0) {
    header('location:' . SITE_INDEX . '?error=' . urlencode("NullPointerException: team number not valid."));
} else if ($userEmail == "") {
    header('location:' . SITE_INDEX . '?error=' . urlencode("Please enter your email address."));
} else if ($userPass == "") {
    header('location: ' . SITE_INDEX . '?error=' . urlencode("Please enter your team's password."));
}

echo 'team number: ' . $teamNum . '<br>';
echo 'user email: ' . $userEmail . '<br>';
echo 'user password: ' . $userPass . '<br>';
?>