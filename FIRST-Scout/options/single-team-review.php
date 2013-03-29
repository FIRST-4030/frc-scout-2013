<?php
session_start();
if (!isset($_SESSION['TeamID'])) {
    header('location: ../index.php?error=' . urlencode("You must login first!"));
}
?>
<html>
    <head>
        <title>Individual Results</title>
        <?
        include '../includes/form-headers.html';
        if (isset($_GET['team'])) {
            $teamNumber = $_GET['team'];
        } else {
            header('location: options?error=' . urlencode("You must first select a team to navigate to this page!"));
        }
        ?>
    </head>
    <body>
        <div class="container">
            <p class="title">Averages for team <? echo $teamNumber ?></p>
            <button class="btn btn-success" onclick="history.go(-1);" style="width: 200px">&larr;&nbsp;Go Back</button><br />

            <?
            require '../includes/constants.php';

            $query = 'SELECT `scouted_team_number` AS "scouted_team",
            AVG((`auto_top` * 6.0) +  (`auto_middle` * 4.0) +  (`auto_bottom` * 2.0)) AS "auto_average_points",
            AVG(100.00 * (`auto_top` + `auto_middle` + `auto_bottom`) / (`auto_top` + `auto_middle` + `auto_bottom` + `auto_miss`)) AS "auto_accuracy",            
            AVG((`teleop_top` * 3.0) +  (`teleop_middle` * 2.0) +  (`teleop_bottom`)) AS "teleop_average_points",
            AVG(100.00 * (`teleop_top` +  `teleop_middle` +  `teleop_bottom`) / (`teleop_top` +  `teleop_middle` + `teleop_bottom` + `teleop_miss`)) AS "teleop_accuracy",
            AVG((`climb_pyramid_goals` + `teleop_pyramid`) *  5) AS "pyramid_average_points",
            AVG((`climb_level_reached`) * 10) AS "pyramid_average_climb_points",
            COUNT(`scouted_team_number`) AS "matches_scouted"
            FROM  `scout_recording`
            WHERE `scouted_team_number`=' . $teamNumber . ' AND `results_match_outcome` != 3';

            $db = mysqli_connect("localhost", DB_USER, DB_PASSWD, "stevenz9_robotics_scout");
            if (mysqli_connect_errno()) {
                echo('Failed to connect to database: ' . mysqli_connect_error());
            }

            $getResults = mysqli_query($db, $query);
            $results = mysqli_fetch_assoc($getResults);

            $totalAveragePoints = $results['auto_average_points'] + $results['teleop_average_points'] + $results['pyramid_average_points'] + $results['pyramid_average_climb_points'];
            ?>
            <br />
            <table class="table table-hover" style="text-align: left">
                <caption><strong>Reviewing averages for team <? echo $teamNumber ?></strong></caption>
                <thead>
                <tbody>
                    <?
                    echo '<tr><td>Matches Scouted</td><td>' . $results['matches_scouted'] . '</td></tr>';
                    echo '<tr><td>Total Average Points</td><td>' . round($totalAveragePoints, 1) . '</td></tr>';
                    echo "<tr><td>Autonomous Average Points</td><td>" . round($results['auto_average_points'], 1) . "</td></tr>";
                    echo "<tr><td>Autonomous Average Accuracy</td><td>" . round($results['auto_accuracy'], 1) . "%</td></tr>";
                    echo "<tr><td>Teleop Average Points</td><td>" . round($results['teleop_average_points'], 1) . "</td></tr>";
                    echo "<tr><td>Teleop Average Accuracy</td><td>" . round($results['teleop_accuracy'], 1) . "%</td></tr>";
                    echo "<tr><td>Average Pyramid Goal Points</td><td>" . round($results['pyramid_average_points'], 1) . "</td></tr>";
                    echo "<tr><td>Average Pyramid Climb Points</td><td>" . round($results['pyramid_average_climb_points'], 1) . "</td></tr>";
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>