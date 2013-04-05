<?php

#Require auth (although this page is not accessed directly anyways)
session_start();

if (!isset($_SESSION['TeamNumber'])) {
    header('location: ../index.php?error=' . urlencode("That page is not accessible by mere mortals!"));
}

if(isset($_POST['tn'])) {
    $teamNumber = $_POST['tn'];
} else {
    $teamNumber = $_SESSION['TeamNumber'];
}

# Connect to DB
require '../includes/constants.php';
try {
    $db = new PDO(DSN, DB_USER, DB_PASSWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

$query = 'SELECT `ts` AS "timestamp", `match_number` AS "match_number", `results_comments` AS "comments", `uid` AS "match_id", `location` FROM ' . MATCH_TABLE . " WHERE `scouted_team_number`=?";
$args = array($teamNumber);

if(isset($_POST['location'])) {
    $location = $_POST['location'];
    $query .= ' AND `location`=?';
    array_push($args, $location);
}

$stmt = $db->prepare($query);

$stmt->execute($args);


$comments = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (!empty($row['comments'])) {
        
        array_push($comments, $row);
        
    }
}

echo json_encode($comments);
?>