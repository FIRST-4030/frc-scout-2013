<?php
session_start();
if(!isset($_SESSION['TeamID'])) {
    header('location: index.php?error=' . urlencode("You must login first!"));
}
require '../includes/constants.php';

$query = 'SELECT `scouted_team_number` AS "scouted_team",
AVG((`auto_top` * 6.0) +  (`auto_middle` * 4.0) +  (`auto_bottom` * 2.0)) AS "auto_average_points",
AVG((`teleop_top` * 3.0) +  (`teleop_middle` * 2.0) +  (`teleop_bottom`)) AS "teleop_average_points",
AVG((`climb_pyramid_goals` + `teleop_pyramid`) *  5) AS "pyramid_average_points",
AVG((`climb_level_reached`) * 10) AS "pyramid_average_climb_points"
FROM  `scout_recording`';

if(!empty($_POST['search'])) {
    $search = preg_replace('/[^\w ]/', '', $_POST['search']);    
    $query .= " WHERE `scouted_team_number` LIKE '%{$search}%' GROUP BY  `scouted_team_number`";
} else {
    $query .= " GROUP BY  `scouted_team_number`";
}

$db = mysqli_connect("localhost", DB_USER, DB_PASSWD, "stevenz9_robotics_scout");
if (mysqli_connect_errno()) {
    echo('Failed to connect to database: ' . mysqli_connect_error());
}

$results = mysqli_query($db, $query);

while ($row = mysqli_fetch_assoc($results)) {
    $totalAveragePoints = $row['auto_average_points'] + $row['teleop_average_points'] 
            + $row['pyramid_average_points'] + $row['pyramid_average_climb_points'];
    echo '<tr>';
    echo '<th scope="row"><a href="single-team-review.php?team=' . $row['scouted_team'] . '"><b>' . $row['scouted_team'] . '</b></a></th>';
    echo '<td><b>' . round($totalAveragePoints, 1) . '</b></td>';
    echo '<td>' . round($row['auto_average_points'], 1) . '</td>';
    echo '<td>' . round($row['teleop_average_points'], 1) . '</td>';
    echo '<td>' . round($row['pyramid_average_points'], 1) . '</td>';
    echo '<td>' . round($row['pyramid_average_climb_points'], 1) . '</td>';

    echo '</tr>';
}
//echo '</table>';
?>


