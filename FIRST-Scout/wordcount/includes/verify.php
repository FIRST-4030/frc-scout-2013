<?php

$teamID = $_REQUEST['team_id'];

require 'constants.php';

try {
    $db = new PDO(DSN, DB_USER, DB_PASSWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

try {
    $verify = $db->prepare('SELECT `team_id` FROM `scout_login` WHERE team_id=?');
    $verify->execute(array($teamID));
} catch (PDOException $ex) {
    die("Unable to check team\n " . $ex->getMessage());
}

$fetch = $verify->fetch(PDO::FETCH_ASSOC);


if (key_exists('team_id', $fetch)) {
    echo "true";
} else {
    echo "false";
}
?>
 