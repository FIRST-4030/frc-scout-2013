<?php

session_start();

if (!isset($_POST['id'])) {
    header('location: index.php?error=' . urlencode("YOU CANNOT DO THAT!"));
}
$uid = intval($_POST['id']);

if (!isset($_SESSION['TeamID'])) {
    header('location: ../index.php?error=' . urlencode("No."));
}

require 'includes/constants.php';
try {
    $db = new PDO(DSN, DB_USER, DB_PASSWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

try {
	$del = $db->prepare('DELETE FROM `scout_recording` WHERE uid = ? AND team_id = ?');
	$authenticate->execute(array($uid, $_SESSION['TeamID']));
} catch (PDOException $ex) {
    die("Unable to delete\n " . $ex->getMessage());
}

echo "Deleted successfully";
?>
