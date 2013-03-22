<!DOCTYPE html>
<html>    
    <head>
        <title>Autonomous Mode</title>
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- make mobile-friendly -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->

        <!-- css -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">

        <!-- bootstrap -->
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>        
        <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <p class="title">Autonomous: <b><?php echo $scoutedTeamNumber?></b></p>
            
            <button id="usedKinect" onclick="updateKinect()" class="btn btn-success" data-toggle="button" style="margin-top: 3px; margin-bottom: 8px;">Used Kinect?</button>
            <p><i>Record points for each goal</i></p>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(0, false)">+6</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(0, true)">&mdash;</button>
            <span id="autoSixPoint" class="autonomousIndividual">0</span>
            <br />
            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(1, false)">+4</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(1, true)">&mdash;</button>
            <span id="autoFourPoint" class="autonomousIndividual">0</span>
            <br />
            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(2, false)">+2</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(2, true)">&mdash;</button>
            <span id="autoTwoPoint" class="autonomousIndividual">0</span>
            <br />
            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(3, false)">Missed</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(3, true)">&mdash;</button>
            <span id="autoMissedPoints" class="autonomousIndividual">0</span>
            <br />
            <p style="font-weight: bold; margin-top: 5px">Total Points: <span id="totalPoints">0</span></p>

            <button class="btn btn-large" id="NextPageButton" onclick="sendData()">Continue to Teleoperated &rarr;</button>
            <br /><br />
        </div>
        <script type="text/javascript">
            var autonomousPoints = [0, 0, 0, 0];
            var usedKinect = false;

            $(document).ready(function() {
                //get rid of the title bar if it's a mobile device
                window.scrollTo(0, 1)
            });

            function updateKinect() {
                usedKinect = !usedKinect;
            }


            function update(index, negative) {
                if (autonomousPoints[index] > 0) {
                    autonomousPoints[index] += 1 * negative ? (-1) : (1);
                } else if (!negative) {
                    autonomousPoints[index]++;
                }
                updateIndividualTotals();
                updateTotals();
            }

            function updateIndividualTotals() {
                document.getElementById('autoSixPoint').innerHTML = autonomousPoints[0];
                document.getElementById('autoFourPoint').innerHTML = autonomousPoints[1];
                document.getElementById('autoTwoPoint').innerHTML = autonomousPoints[2];
                document.getElementById('autoMissedPoints').innerHTML = autonomousPoints[3];
            }

            function updateTotals() {
                document.getElementById('totalPoints').innerHTML = (autonomousPoints[0] * 6) + (autonomousPoints[1] * 4) + (autonomousPoints[2] * 2);
            }

            function sendData() {
                var invisibleForm = document.getElementById('sendForm');
                invisibleForm.innerHTML += "<input type='text' name='next_page' value='" + "forms/teleop.php" + "'</input>";
                invisibleForm.innerHTML += "<input type='text' name='autonomous_top_goals' value='" + autonomousPoints[0] + "'</input>";
                invisibleForm.innerHTML += "<input type='text' name='autonomous_middle_goals' value='" + autonomousPoints[1] + "'</input>";
                invisibleForm.innerHTML += "<input type='text' name='autonomous_bottom_goals' value='" + autonomousPoints[2] + "'</input>";
                invisibleForm.innerHTML += "<input type='text' name='autonomous_missed_goals' value='" + autonomousPoints[3] + "'</input>";
                invisibleForm.innerHTML += "<input type='text' name='autonomous_used_kinect' value='" + usedKinect + "'</input>";
                invisibleForm.submit();
            }
        </script>
        <form id="sendForm" action="entry.php" class="invisible_form" method="post"></form>
    </body>
</html>
