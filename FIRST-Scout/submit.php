<?php
/*
 * temporary actions just to do some stuff for now
 * will be integrated mySQL later, obviously
 */
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
} else if($teamNumInt == 4030 && $userEmail == "terabyte128@gmail.com" && $userPass == "robots!") {
    header('location: /input_forms');
} else {
    header('location:' . SITE_INDEX . "?error=" . urlencode("You don't appear to have an account!"));
}
/*
  echo 'team number: ' . $teamNumInt . '<br>';
  echo 'user email: ' . $userEmail . '<br>';
  echo 'user password: ' . $userPass . '<br>';
 */
?>