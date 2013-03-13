<?php
require('includes/constants.php');

# Config
$DSN       = 'mysql:host=localhost;dbname=' . DB_NAME . ';charset=utf8';
$TABLE     = 'testTable';


# Start (or resume) a session. $_SESSION will now be available
session_start();

# Read something from the session
if (isset($_SESSION['testData'])) {
	print 'Session: ' . $_SESSION['testData'] . "\n";	
} else {
	print "Session: <testData not set>\n";
}

# Store something in the session
$_SESSION['testData'] = 'val3';


# Connect to the DB
try {
	$db = new PDO($DSN, DB_USER, DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $ex) {
	die("Unable to connect to DB\n");
}

# Prepare and run a query
try {
	$stmt = $db->prepare('SELECT FROM ' . $TABLE . 'WHERE col1=? AND col2=?');
	$stmt->execute(array('val1', 'val2'));
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($rows as $row) {
		print 'Row: ';
		foreach ($row as $col => $val) {
			print "\t" . $col . ' => ' . $val . "\n";
		}
		print "\n";
	}
} catch(PDOException $ex) {
	die("Unable to read from DB\n");
}

# Prepare and run a query
try {
	$stmt = $db->prepare('INSERT INTO ' . $TABLE . '(col1, col2) VALUES (?, ?)');
	$stmt->execute(array('val1', 'val2'));
	print 'Wrote ' . $db->affectedRows() . " rows\n";
} catch(PDOException $ex) {
	die("Unable to write to DB\n");
}


# Cleanup the DB connection
$db = null;

?>