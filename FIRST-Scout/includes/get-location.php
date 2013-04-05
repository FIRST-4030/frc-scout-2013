<?php

session_start();
require 'constants.php';

if (!isset($_SESSION['TeamID'])) {
    header("location: ../index.php?error=" . urlencode("Please login."));
}

try {
    $db = new PDO(DSN, DB_USER, DB_PASSWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

$query = "SELECT `location` FROM " . LOCATION_TABLE;

$stmt = $db->prepare($query);

$stmt->execute();

$json = array();
while ($locations = $stmt->fetch(PDO::FETCH_ASSOC)) {
    foreach ($locations as $value) {
        array_push($json, $value);
    }
}

$return = json_encode($json);

echo $return;
?>
