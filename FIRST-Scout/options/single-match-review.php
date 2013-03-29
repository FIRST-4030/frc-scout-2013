<? session_start(); ?>
<html>
    <head>
        <title>Review Match</title>
        <?php
        include '../includes/form-headers.html';
        require '../includes/constants.php';
        if (!isset($_GET['redir'])) {
            $redir = "window.location = 'index.php'";
        } else {
            $redir = "history.go(-1)";
        }
        ?>
    </head>
    <body>
        <div class="container">
            <p class="title">Review Match</p>
            <button class="btn btn-success" onclick="<? echo $redir ?>" style="width: 200px">&larr;&nbsp;Go Back</button><br />
            <?php
            #Grab the match ID to get information and then delete it as to not get confused
            if (isset($_SESSION['MATCH_ID']) || isset($_GET['match'])) {
                if (isset($_SESSION['MATCH_ID'])) {
                    $matchID = $_SESSION['MATCH_ID'];
                    unset($_SESSION['MATCH_ID']);
                } else if (isset($_GET['match'])) {
                    $matchID = $_GET['match'];
                }

                try {
                    $db = new PDO(DSN, DB_USER, DB_PASSWD);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $ex) {
                    die("Unable to connect to DB\n " . $ex->getMessage() . "<br>" . DSN);
                }
                $getMatchInfo = $db->prepare("SELECT * FROM scout_recording WHERE uid=?");
                $getMatchInfo->execute(array($matchID));
                $matchInfo = $getMatchInfo->fetch(PDO::FETCH_ASSOC);
            } else {
                header('location: /options?error=' . urlencode("You must scout a match first!"));
            }
            ?>
            <br />
            <table class="table table-hover" style="text-align: center">
                <caption><strong>Reviewing match <? echo $matchInfo['match_number'] ?> for team <? echo $matchInfo['scouted_team_number'] . " in " . $matchInfo['location'] ?></strong></caption>
                <thead>
                </thead>
                <tbody>
                    <?
                    echo '<tr><td>Timestamp</td><td>' . $matchInfo['ts'] . '</td></tr>';
                    echo '<tr><td>Scout</td><td>' . $matchInfo['user_id'] . '</td></tr>';
                    $present = $matchInfo['present'] == 1 ? "Yes" : "No";
                    echo '<tr><td>Present</td><td>' . $present . '</td></tr>';
                    $dead = $matchInfo['dead'] == 1 ? "Yes" : "No";
                    echo '<tr><td>Dead Robot</td><td>' . $dead . '</td></tr>';
                    $alliance = $matchInfo['alliance'] == "RED" ? "Red" : "Blue";
                    echo '<tr><td>Alliance</td><td>' . $alliance . '</td></tr>';
                    echo '<tr><td>Location</td><td>' . $matchInfo['location'] . '</td></tr>';
                    echo '<tr><td>Autonomous Top Goals</td><td>' . $matchInfo['auto_top'] . '</td></tr>';
                    echo '<tr><td>Autonomous Middle Goals</td><td>' . $matchInfo['auto_middle'] . '</td></tr>';
                    echo '<tr><td>Autonomous Bottom Goals</td><td>' . $matchInfo['auto_bottom'] . '</td></tr>';
                    echo '<tr><td>Autonomous Missed Goals</td><td>' . $matchInfo['auto_miss'] . '</td></tr>';
                    $kinect = $matchInfo['kinect'] == 1 ? "Yes" : "No";
                    echo '<tr><td>Used Kinect in Autonomous</td><td>' . $kinect . '</td></tr>';
                    $frisbeePickup = $matchInfo['teleop_frisbee_pickup'] == 1 ? "Yes" : "No";
                    echo '<tr><td>Can pick up Frisbees?</td><td>' . $frisbeePickup . '</td></tr>';
                    echo '<tr><td>Teleop Top Goals</td><td>' . $matchInfo['teleop_top'] . '</td></tr>';
                    echo '<tr><td>Teleop Middle Goals</td><td>' . $matchInfo['teleop_middle'] . '</td></tr>';
                    echo '<tr><td>Teleop Bottom Goals</td><td>' . $matchInfo['teleop_bottom'] . '</td></tr>';
                    echo '<tr><td>Teleop Missed Goals</td><td>' . $matchInfo['teleop_miss'] . '</td></tr>';
                    echo '<tr><td>Teleop Blocked Goals</td><td>' . $matchInfo['teleop_blocked'] . '</td></tr>';
                    echo '<tr><td>Teleop Pyramid Goals</td><td>' . $matchInfo['teleop_pyramid'] . '</td></tr>';
                    $shootingInt = $matchInfo['teleop_shooting_range'];
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
                    echo '<tr><td>Teleop Shooting Range</td><td>' . $shootingRange . '</td></tr>';
                    echo '<tr><td>Teleop Robot Speed (1-5)</td><td>' . $matchInfo['teleop_robot_speed'] . '</td></tr>';
                    echo '<tr><td>Teleop Robot Steering (1-5)</td><td>' . $matchInfo['teleop_robot_steering'] . '</td></tr>';
                    echo '<tr><td>Pyramid Climb Attempts</td><td>' . $matchInfo['climb_attempts'] . '</td></tr>';
                    echo '<tr><td>Pyramid Goals</td><td>' . $matchInfo['climb_pyramid_goals'] . '</td></tr>';
                    echo '<tr><td>Pyramid Level Reached</td><td>' . $matchInfo['climb_level_reached'] . '</td></tr>';
                    $styleInt = $matchInfo['climb_style'];
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
                    echo '<tr><td>Timestamp</td><td>' . $climbStyle . '</td></tr>';
                    $matchInt = $matchInfo['results_match_outcome'];
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
                        case 3:
                            $matchOutcome = "Incomplete";
                            break;
                    }
                    echo '<tr><td>Outcome</td><td>' . $matchOutcome . '</td></tr>';
                    echo '<tr><td>Fouls</td><td>' . $matchInfo['results_fouls'] . '</td></tr>';
                    echo '<tr><td>Technical Fouls</td><td>' . $matchInfo['results_technical_fouls'] . '</td></tr>';
                    echo '<tr><td>Comments</td><td>' . $matchInfo['results_comments'] . '</td></tr>';
                    ?>
                </tbody>
            </table>


        </div>
    </body>
</html>
