<?php

$teamID = $_REQUEST['location_query'];

require 'constants.php';

try {
    $db = new PDO(DSN, DB_USER, DB_PASSWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

if (isset($_REQUEST['getloc'])) {
    try {
        $verify = $db->prepare('SELECT `uid` FROM ' . LOCATION_TABLE . ' WHERE location=?');
        $verify->execute(array($teamID));
    } catch (PDOException $ex) {
        die("Unable to check location " . $ex->getMessage());
    }

    $fetch = $verify->fetch(PDO::FETCH_ASSOC);


    if (key_exists('uid', $fetch)) {
        $json = array("indexed" => true);
    } else {
        $json = array("indexed" => false);
    }
    
    echo json_encode($json);
}
?>
 