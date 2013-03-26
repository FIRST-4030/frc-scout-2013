<?php
require '../includes/constants.php';

$query = 'SELECT `scouted_team_number` AS "scouted_team",
AVG((`auto_top` * 6.0) +  (`auto_middle` * 4.0) +  (`auto_bottom` * 2.0)) AS "auto_average_points",
AVG((`teleop_top` * 3.0) +  (`teleop_middle` * 2.0) +  (`teleop_bottom`)) AS "teleop_average_points",
AVG(`climb_pyramid_goals` *  5) AS "pyramid_average_points"
FROM  `scout_recording` 
GROUP BY  `scouted_team_number` ';

$db = mysqli_connect("localhost", DB_USER, DB_PASSWD, "stevenz9_robotics_scout");
if (mysqli_connect_errno()) {
    echo('Failed to connect to database: ' . mysqli_connect_error());
}


?>


