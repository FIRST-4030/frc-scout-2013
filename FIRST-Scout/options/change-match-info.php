<?php
/*
if (isset($_POST['id']) && isset($_POST['value']) && isset($_POST['team_id']) && isset($_POST['match_id'])) {
    require '../includes/constants.php';

    $requestField = $_POST['id'];
    $requestValue = $_POST['value'];
    $teamID = $_POST['team_id'];
    $matchID = $_POST['match_id'];
    print_r($_POST);
    echo $_SESSION['TeamID'];
    if ($teamID != $_SESSION['TeamID']) {
        echo $teamID . "!=" . $_SESSION['TeamID'];
        //exit(-1);
    }
    return $requestValue;
    
    echo 'post-session';
    echo 'pre-database';
    try {
        $db = new PDO(DSN, DB_USER, DB_PASSWD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        die("Unable to connect to DB\n " . $ex->getMessage() . "<br>" . DSN);
    }
    $changeInfo = $db->prepare('UPDATE `scout_recording` SET `?`="?" WHERE uid=?');
    $changeInfo->execute(array($requestField, $requestValue, $matchID));
    echo "string: " . $changeInfo->queryString;
    echo 'post-database';
    $getChangedInfo = $db->prepare("SELECT ? FROM `scout_recording` WHERE uid=?");
    $getChangedInfo->execute(array($matchID, $matchID));


    print_r($getChangedInfo->fetch(PDO::FETCH_ASSOC));
} else {
    print_r($_POST);
}
 
 */
echo  $_POST['value'] . " was not changed.";
?>
