<?php
$teamID = $_POST['team_id'];

require 'constants.php';

$db = mysqli_connect("localhost", DB_USER, DB_PASSWD, "stevenz9_robotics_scout");
if (mysqli_connect_errno()) {
    echo('Failed to connect to database: ' . mysqli_connect_error());
}

$query = "SELECT team_id FROM scout_login WHERE team_id=$teamID";

$result =  mysqli_query($db, $query);

$fetch = mysqli_fetch_assoc($result);

if(key_exists('team_id', $fetch)) {
    echo "true";
} else {
    echo "false";
}
?>
