<?php
# Require auth
session_start();
if(!isset($_SESSION['TeamID'])) {
    header('location: index.php?error=' . urlencode("You must login first!"));
}

# Allow searching by scouted team number
$query  = '';
$params = array();
if (!empty($_POST['search'])) {
    $search = preg_replace('/[^\w ]/', '', $_POST['search']);
	$query  = '`scouted_team_number` LIKE ?';
	$wild   = '%' . $search . '%';
	$params = array($wild);
}

# Connect to DB
require '../includes/constants.php';
try {
    $db = new PDO(DSN, DB_USER, DB_PASSWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Unable to connect to DB\n " . $ex->getMessage());
}

# Construct and run a query
try {
	
	$sql = 'SELECT `scouted_team_number` AS "scouted_team",
	AVG((`auto_top` * 6.0) +  (`auto_middle` * 4.0) +  (`auto_bottom` * 2.0)) AS "auto_average_points",
	AVG((`teleop_top` * 3.0) +  (`teleop_middle` * 2.0) +  (`teleop_bottom`)) AS "teleop_average_points",
	AVG((`climb_pyramid_goals` + `teleop_pyramid`) *  5) AS "pyramid_average_points",
	AVG((`climb_level_reached`) * 10) AS "pyramid_average_climb_points",
        COUNT(`scouted_team_number`) AS "matches_scouted"
	FROM  `scout_recording` WHERE `results_match_outcome` != 3';
	
	if (strlen($query)) {
		$sql .= ' WHERE ' . $query;
	}
	
	$sql .= ' GROUP BY `scouted_team_number`';
	
    $stmt = $db->prepare($sql);
	$stmt->execute($params);
} catch (PDOException $ex) {
    die("Unable to read from DB\n " . $ex->getMessage());
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $totalAveragePoints = $row['auto_average_points'] + $row['teleop_average_points'] + $row['pyramid_average_points'] + $row['pyramid_average_climb_points'];
    echo '<tr>';
    echo '<td><a href="single-team-review.php?team=' . $row['scouted_team'] . '"><b>' . $row['scouted_team'] . '</b></a></td>';
    echo '<td>' . $row['matches_scouted'] . "</td>";
    echo '<td><b>' . round($totalAveragePoints, 1) . '</b></td>';
    echo '<td>' . round($row['auto_average_points'], 1) . '</td>';
    echo '<td>' . round($row['teleop_average_points'], 1) . '</td>';
    echo '<td>' . round($row['pyramid_average_points'], 1) . '</td>';
    echo '<td>' . round($row['pyramid_average_climb_points'], 1) . '</td>';

    echo '</tr>';
}
//echo '</table>';
?>


