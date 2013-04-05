<?php 
//if (!$_SESSION['TeamID']) {
//    header('location: ../index.php?error=' . urlencode("That page is not accessible to mere mortals."));
//    exit(-1);
//}
//
//$team = $_SESSION['TeamID'];
//
//$returned = array();
//
//require 'constants.php';
//try {
//    $db = new PDO(DSN, DB_USER, DB_PASSWD);
//    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $ex) {
//    die("Unable to connect to DB\n " . $ex->getMessage());
//}
//
//$query = "DELETE FROM " . MATCH_TABLE . " WHERE `match_outcome`=3 AND `team_id=?";
//$stmt = $db->prepare($query);
//try {
//    $stmt->execute(array($team));
//    array_push($returned, "success");
//} catch (PDOException $e) {
//    array_push($returned, $e->getMessage());
//}
//
//echo json_encode($returned);
?>
