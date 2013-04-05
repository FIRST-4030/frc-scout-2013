<?php

session_start();
require 'constants.php';

try {
    $db = new PDO(DSN, DB_USER, DB_PASSWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

$query = "SELECT `location`, `expire_date` FROM " . LOCATION_TABLE;

$stmt = $db->prepare($query);

$stmt->execute();

$json = array();

if (isset($_REQUEST['have_not_yet_occured'])) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (strtotime($row['expire_date']) > time()) {
            array_push($json, $row['location']);
        } else if(strtotime($row['expire_date']) == SECONDS_BETWEEN_UNIX_EPOCH_AND_1970_01_01){ 
            array_push($json, $row['location']);
        }
    }
} else {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //foreach ($locations as $value) {
        array_push($json, $row['location']);
    }
}


$return = json_encode($json);

echo $return;
?>
