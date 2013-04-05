<?php
session_start();
if (!isset($_SESSION['TeamID'])) {
    header('location: ../index.php?error=' . urlencode("You must login first!"));
}
?>
<html>
    <head>
        <link href="../tablesorter/themes/blue/style_foo.css" rel="stylesheet" type="text/css"/>

        <title>Individual Results</title>
        <?
        include '../includes/form-headers.html';
        if (isset($_GET['team'])) {
            $teamNumber = $_GET['team'];
        } else {
            header('location: options?error=' . urlencode("You must first select a team to navigate to this page!"));
        }

        if (isset($_GET['location'])) {
            $location = $_GET['location'];
        }
        ?>
    </head>
    <body>
        <div class="container">
            <p class="title">Averages for team <?
                echo $teamNumber;
                if (isset($location)) {
                    echo " in $location";
                }
                ?></p>
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
            WHERE `scouted_team_number`=? AND `results_match_outcome` != 3';

            $params = array($teamNumber);
            if (strlen($location)) {
                $locationParam = "%" . $location . "%";
                $query .= " AND location LIKE ?";
                array_push($params, $locationParam);
            }

            try {
                $db = new PDO(DSN, DB_USER, DB_PASSWD);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $ex) {
                die("Unable to connect to DB\n " . $ex->getMessage());
            }
            $stmt = $db->prepare($query);
            $stmt->execute($params);

            $results = $stmt->fetch(PDO::FETCH_ASSOC);

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
            <br />
            <div id='comment_feed_load' style='margin: 5px; padding: 5px'>
                <p class='small_title'>Observations about this team's matches:</p>
                <table id='comment_feed_table' class='tablesorter table-hover'>
                    <thead>
                    <th>Date</th>
                    <th>Match</th>
                    <th>Location</th>
                    <th>Comments</th>
                    </thead>
                    <tbody id='comments_feed'>

                    </tbody>
                </table>
            </div>       
        </div>
        <script type='text/javascript'>
                $(document).ready(function() {
                    loadComments();
                });

                function loadComments() {
                    $.ajax({
                        url: 'get-comments.php',
                        type: "POST",
                        data: {'tn': <? echo $teamNumber ?>, 'location': '<? echo $location ?>'},
                        success: function(response, textStatus, jqXHR) {
                            var comments = JSON.parse(response);
                            for (var i = 0; i < comments.length; i++) {
                                $("#comments_feed").append('<tr>');
                                $("#comments_feed").append('<td>' + comments[i].timestamp.substring(0, 10) + '</td>');
                                $("#comments_feed").append('<td><a href="single-match-review.php?redir&match=' + comments[i].match_id + '">' + comments[i].match_number + '</a></td>');
                                $("#comments_feed").append('<td>' + comments[i].location + '</td>');
                                $("#comments_feed").append('<td>' + comments[i].comments.replace("\\", "") + '</td>');
                                $("#comments_feed").append('</tr>');
                            }
                            $("#comment_feed_table").trigger("update");
                        }
                    });
                }
        </script>
    </body>
</html>