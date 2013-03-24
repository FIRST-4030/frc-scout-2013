<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header('location: ../index.php?error=' . urlencode("Please login first!"));
}
?>
<html>
    <head>
        <?
        require '../includes/constants.php';
        include '../includes/form-headers.html';
        ?>
        <title>Team Results</title>
        <script type="text/javascript" src="../tablesorter/jquery.tablesorter.min.js"></script> 
        <link href="../tablesorter/themes/blue/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>


        <div class="container">
            <p class="title">All Results</p>
            <table id="resultTable" class="tablesorter">
                <thead>
                    <tr>
                        <th>UID</th>
                        <th>Timestamp</th>
                        <th>Scout</th>
                        <th>Team</th>
                        <th>Present</th>
                        <th>Dead Robot</th>
                        <th>Alliance</th>
                        <th>Location</th>
                        <th>Match</th>
                        <th>Auto Top</th>
                        <th>Auto Middle</th>
                        <th>Auto Bottom</th>
                        <th>Auto Miss</th>
                        <th>Auto Kinect</th>
                        <th>Teleop Frisbee</th>
                        <th>Teleop Top</th>
                        <th>Teleop Middle</th>
                        <th>Teleop Bottom</th>
                        <th>Teleop Miss</th>
                        <th>Teleop Blocked</th>
                        <th>Teleop Pyramid</th>
                        <th>Teleop Miss</th>
                        <th>Teleop Range</th>
                        <th>Teleop Speed</th>
                        <th>Teleop Steering</th>
                        <th>climb_attempts</th>
                        <th>climb_pyramid_goals</th>
                        <th>climb_level_reached</th>
                        <th>climb_style</th>
                        <th>Match outcome</th>
                        <th>Fouls</th>
                        <th>Technical fouls</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $teamID = $_SESSION['TeamID'];
                    if ($_GET['only'] == true) {
                        $query = "SELECT * FROM scout_recording WHERE team_id=$teamID";
                    } else {
                        $query = "SELECT * FROM scout_recording";
                    }
                    $query = "SELECT * FROM scout_recording";
                    $db = mysqli_connect("localhost", DB_USER, DB_PASSWD, "stevenz9_robotics_scout");
                    if (mysqli_connect_errno()) {
                        die('Failed to connect to database: ' . mysqli_connect_error());
                    }

                    $result = mysqli_query($db, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        foreach ($row as $data) {
                            echo "<td>$data</td>";
                        }
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#resultTable").tablesorter();
            });
        </script>
    </body>
</html>