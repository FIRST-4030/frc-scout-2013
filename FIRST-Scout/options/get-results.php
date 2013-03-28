<?
# Require auth
session_start();
if(!isset($_SESSION['TeamID'])) {
    header('location: index.php?error=' . urlencode("You must login first!"));
}

if ($_POST['only'] == "true") {
    $onlyTeam = true;
} else {
    $onlyTeam = false;
}


# Allow searching by location, scouted team number, comments and timestamp
$query  = '';
$params = array();
if (($_POST['search']) != "") {
    $search = preg_replace('/[^\w ]/', '', $_POST['search']);
	$query  = '(location LIKE ? OR scouted_team_number LIKE ? OR results_comments LIKE ? OR ts LIKE ?)';
	$wild   = '%' . $search . '%';
	$params = array($wild, $wild, $wild, $wild);
}

# Limit selection to the logged in team
if ($onlyTeam) {
	if (strlen($query)) {
		$query .= ' AND';
	}
	$query .= ' team_id = ?';
	$params[] = $_SESSION['TeamID'];
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
	$sql = 'SELECT * FROM `scout_recording`';
	if (strlen($query)) {
		$sql .= ' WHERE ' . $query;
	}
    $stmt = $db->prepare($sql);
	$stmt->execute($params);
} catch (PDOException $ex) {
    die("Unable to read from DB\n " . $ex->getMessage());
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $matchID = $row['uid'];
    $autonomousPoints = $row['auto_top'] * 6 + $row['auto_middle'] * 4 + $row['auto_bottom'] * 2;
    $autonomousGoals = $row['auto_top'] + $row['auto_middle'] + $row['auto_bottom'];
    $autonomousAccuracy = $autonomousGoals / ($autonomousGoals + $row['auto_miss']) * 100;
    $teleopPoints = $row['teleop_top'] * 3 + $row['teleop_middle'] * 2 + $row['teleop_bottom'] * 1;
    $teleopGoals = $row['teleop_top'] + $row['teleop_middle'] + $row['teleop_bottom'];
    $teleopAccuracy = $teleopGoals / ($teleopGoals + $row['teleop_miss']) * 100;

    echo '<tr>';
    if ($onlyTeam) {
        echo "<td><a onfocus='this.innerHTML = &timesb;' onblur='this.innerHTML=&times;' onclick='deleteTeam($matchID)' style='font-size:24px'>&times;</a>";
    }
    echo '<td><a href=single-match-review.php?redir&match=' . $row['uid'] . ">" . $row['scouted_team_number'] . '</a></td>';
    echo '<td>' . substr($row['ts'], 0, 10) . '</td>';
    if ($onlyTeam)
        echo '<td>' . $row['user_id'] . '</td>';
    echo '<td>' . $row['scouting_team_number'] . '</td>';
    $present = $row['present'] == 1 ? "Yes" : "No";
    echo '<td>' . $present . '</td>';
    $deadRobot = $row['dead'] == 1 ? "Yes" : "No";
    echo '<td>' . $deadRobot . '</td>';
    $alliance = $row['alliance'] == "RED" ? "<p style='color:red'>Red</p>" : "<p style='color:blue'>Blue</p>";
    echo '<td>' . $alliance . '</td>';
    echo '<td>' . $row['location'] . '</td>';
    echo '<td>' . $row['match_number'] . '</td>';
    echo '<td>' . ($autonomousPoints + $teleopPoints) . '</td>';
    echo '<td>' . ($autonomousGoals + $teleopGoals) . '</td>';
    echo '<td>' . $autonomousPoints . '</td>';

    echo '<td>' . number_format($autonomousAccuracy, 1) . "%</td>";
    $frisbeePickup = $row['teleop_frisbee_pickup'] == 1 ? "Yes" : "No";
    echo '<td>' . $frisbeePickup . '</td>';
    $canBlock = $row['teleop_blocked'] == 1 ? "Yes" : "No";
    echo '<td>' . $canBlock . '</td>';

    echo '<td>' . $teleopPoints . '</td>';
    echo '<td>' . number_format($teleopAccuracy, 1) . "%</td>";
    $shootingInt = $row['teleop_shooting_range'];
    switch ($shootingInt) {
        case 0:
            $shootingRange = "Less than half court";
            break;
        case 1:
            $shootingRange = "Half court";
            break;
        case 2:
            $shootingRange = "Full court";
            break;
    }
    echo '<td>' . $shootingRange . '</td>';
    echo '<td>' . $row['teleop_robot_speed'] . '</td>';
    echo '<td>' . $row['teleop_robot_steering'] . '</td>';
    echo '<td>' . $row['climb_attempts'] . '</td>';
    echo '<td>' . $row['climb_level_reached'] . '</td>';
    echo '<td>' . $row['pyramid_goals'] . '</td>';
    $styleInt = $row['climb_style'];
    switch ($styleInt) {
        case 0:
            $climbStyle = "n/a";
            break;
        case 1:
            $climbStyle = "Corner";
            break;
        case 2:
            $climbStyle = "Inside";
            break;
        case 3:
            $climbStyle = "Face";
            break;
    }
    echo '<td>' . $climbStyle . '</td>';
    $matchInt = $row['results_match_outcome'];
    switch ($matchInt) {
        case 0:
            $matchOutcome = "Lose";
            break;
        case 1:
            $matchOutcome = "Win";
            break;
        case 2:
            $matchOutcome = "Tie";
            break;
    }

    echo '<td>' . $matchOutcome . '</td>';
    echo '<td>' . $row['results_fouls'] . '</td>';
    echo '<td>' . $row['results_technical_fouls'] . '</td>';
    echo '<td>' . $row['results_comments'] . '</td>';
    echo '</tr>';
}
?>
