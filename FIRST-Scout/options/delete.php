<?php
session_start();

if(!isset($_POST['id'])) {
    header('location: index.php?error=' . urlencode("YOU CANNOT DO THAT!"));
}
$uid = $_POST['id'];

if(!isset($_SESSION['TeamID'])) {
    header('location: ../index.php?error=' . urlencode("No."));
}

require '../includes/constants.php';
$db = mysqli_connect("localhost", DB_USER, DB_PASSWD, "stevenz9_robotics_scout");
if (mysqli_connect_errno()) {
    echo('Failed to connect to database: ' . mysqli_connect_error());
}

$query = "DELETE FROM `scout_recording` WHERE uid=$uid";
mysqli_query($db, $query);
echo "Deleted successfully";
?>
