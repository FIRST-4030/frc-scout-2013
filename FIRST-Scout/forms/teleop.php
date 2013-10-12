<!DOCTYPE html>
<html>    
    <head>
        <title>Teleoperated Mode</title>
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->

        <!-- These work! -->
        <!-- css -->
        <link href="../bootstrap2/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link href="../jqwidgets_unused/jqwidgets/styles/jqx.base.css" rel="stylesheet" type="text/css" />

        <!--jqwidgets and bootstrap -->
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>        
        <script type="text/javascript" src="../bootstrap2/js/bootstrap.min.js"></script>
        <? include 'includes/borders.php'; ?>

    </head>

    <body>
        <div class="container">
            <p class="title">Teleoperated: <b><?php echo $scoutedTeamNumber ?></b></p>
            <button id="frisbeePickup" onclick="updateCanPickupFrisbees();" class="btn btn-success" data-toggle="button" style="margin-top: 3px; margin-bottom: 8px;">Can pick up Frisbees?</button>
            <button id="canBlock" onclick="updateCanBlock();" class="btn btn-success" data-toggle="button" style="margin-top: 3px; margin-bottom: 8px;">Can block?</button>
            <p><i>Record points for each goal</i></p>

            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(0, false);">+3</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(0, true);">&mdash;</button>
            <span id="teleopThreePoint" class="autonomousIndividual">0</span>
            <br />
            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(1, false);">+2</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(1, true);">&mdash;</button>
            <span id="teleopTwoPoint" class="autonomousIndividual">0</span>
            <br />
            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(2, false);">+1</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(2, true);">&mdash;</button>
            <span id="teleopOnePoint" class="autonomousIndividual">0</span>
            <br />
            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(3, false);">Missed</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(3, true);">&mdash;</button>
            <span id="teleopMissedPoints" class="autonomousIndividual">0</span>
            <br />
            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(4, false);">Pyramid Goal</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(4, true);">&mdash;</button>
            <span id="teleopPyramidPoints" class="autonomousIndividual">0</span>
            <br />
            <p style="font-weight: bold; margin-top: 5px">Total Points: <span id="totalPoints">0</span></p>

            <p style="margin-bottom:2px;"><i>Shooting range:</i></p>
            <div class="btn-group" data-toggle="buttons-radio">
                <button class="btn btn-danger active" onclick="updateRange(0);">Under half court</button>
                <button class="btn btn-warning" onclick="updateRange(1);">Half court</button>
                <button class="btn btn-success" onclick="updateRange(2);">Full court</button>
            </div>


            <p style="margin-bottom: 2px; margin-top: 10px;" class="small_title"><i>Robot speed</i></p>
            <p style="margin-bottom: 1px">Slow &mdash; Average &mdash; Fast</p>
            <div class="btn-group robotSpeed" data-toggle="buttons-radio">
                <button class="btn btn-small active">1</button>
                <span>Slow</span>
                <button class="btn btn-small">2</button>
                <button class="btn btn-small">3</button>
                <button class="btn btn-small">4</button>
                <button class="btn btn-small">5</button>
                <span>Fast</span>
            </div>


            <p style="margin-bottom: 2px" class="small_title"><i>Robot steering</i></p>
            <p style="margin-bottom: 1px">Loose &mdash; Average &mdash; Tight</p>
            <div class="btn-group robotManeuverability" data-toggle="buttons-radio">
                <button class="btn btn-small active">1</button>
                <button class="btn btn-small">2</button>
                <button class="btn btn-small">3</button>
                <button class="btn btn-small">4</button>
                <button class="btn btn-small">5</button>
            </div>
            <br /><br />
            <button class="btn btn-large" id="NextPageButton" onclick="sendData();">Continue to Climbing &rarr;</button>
            <br /><br />
        </div>
        <script type="text/javascript">
                $(document).ready(function() {
                    window.scrollTo(0, 1);

                    $('#RobotSpeed').on('change', function() {
                        document.getElementById('robotSpeedFeedback').innerHTML = " " + $('#RobotSpeed').val();
                    });

                    $('#RobotManeuverability').on('change', function() {
                        document.getElementById('RobotManeuverabilityFeedback').innerHTML = " " + $('#RobotManeuverability').val();
                    });
                });

                var teleopPoints = [0, 0, 0, 0, 0];
                function update(index, negative) {
                    if (teleopPoints[index] > 0) {
                        teleopPoints[index] += 1 * negative ? (-1) : (1);
                    } else if (!negative) {
                        teleopPoints[index]++;
                    }
                    updateIndividualTotals();
                    updateTotals();
                }

                var range = 0;
                function updateRange(newRange) {
                    range = newRange;
                }

                var canPickupFrisbees = false;

                function updateCanPickupFrisbees() {
                    canPickupFrisbees = !canPickupFrisbees;
                }

                var canBlock = false;
                function updateCanBlock() {
                    canBlock = !canBlock;
                }

                function updateIndividualTotals() {
                    document.getElementById('teleopThreePoint').innerHTML = teleopPoints[0];
                    document.getElementById('teleopTwoPoint').innerHTML = teleopPoints[1];
                    document.getElementById('teleopOnePoint').innerHTML = teleopPoints[2];
                    document.getElementById('teleopMissedPoints').innerHTML = teleopPoints[3];
                    document.getElementById('teleopPyramidPoints').innerHTML = teleopPoints[4];
                }

                function updateTotals() {
                    document.getElementById('totalPoints').innerHTML = (teleopPoints[0] * 3) + (teleopPoints[1] * 2) + (teleopPoints[2] * 1) + (teleopPoints[4] * 5);
                }

                function sendData() {
                    var invisibleForm = document.getElementById('sendForm');
                    invisibleForm.innerHTML += "<input type='text' name='next_page' value='" + "forms/climb.php" + "'</input>";
                    invisibleForm.innerHTML += "<input type='text' name='teleop_can_pickup_frisbees' value='" + canPickupFrisbees + "'</input>";
                    invisibleForm.innerHTML += "<input type='text' name='teleop_top_goals' value='" + teleopPoints[0] + "'</input>";
                    invisibleForm.innerHTML += "<input type='text' name='teleop_middle_goals' value='" + teleopPoints[1] + "'</input>";
                    invisibleForm.innerHTML += "<input type='text' name='teleop_bottom_goals' value='" + teleopPoints[2] + "'</input>";
                    invisibleForm.innerHTML += "<input type='text' name='teleop_missed_goals' value='" + teleopPoints[3] + "'</input>";
                    invisibleForm.innerHTML += "<input type='text' name='teleop_blocked_goals' value='" + canBlock + "'</input>";
                    invisibleForm.innerHTML += "<input type='text' name='teleop_pyramid_goals' value='" + teleopPoints[4] + "'</input>";
                    invisibleForm.innerHTML += "<input type='text' name='teleop_shooting_range' value='" + range + "'</input>";
                    invisibleForm.innerHTML += "<input type='text' name='teleop_robot_speed' value='" + $(".robotSpeed .active").text() + "'</input>";
                    invisibleForm.innerHTML += "<input type='text' name='teleop_robot_maneuverability' value='" + $(".robotManeuverability .active").text() + "'</input>";
                    invisibleForm.submit();
                }
        </script>
        <form id="sendForm" action="entry.php" class="invisible_form" method="post"></form>
    </body>
</html>
