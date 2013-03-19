<!DOCTYPE html>
<html>    
    <head>
        <title>Pre-match Information</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>

        <!-- These work! -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>        
        <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <p class="title" id ="title" style="margin-bottom: 10px;">Pre-match Information</p>
            <div id="inputContainer">
                <button id="robotPresent" onclick="updateCheckbox(0)" class="btn btn-success active" data-toggle="button">Present</button>
                <button id="deadRobot" onclick="updateCheckbox(1)" class="btn btn-warning" data-toggle="button">Dead Robot</button>
                <br />
                <input id="location" name="location" type="text" style="margin-bottom: 2px; margin-top: 5px; width: 215px" placeholder="Location" /><br />
                <input id="teamNumber" placeholder="Team Number" type="number" style="width: 100px"/>
                <input id="matchNumber" placeholder="Match Number" type="number" style="width: 100px"/>  
                <br />
                <div class="btn-group" data-toggle="buttons-radio" style="margin-top: 10px; margin-bottom: 10px">
                    <button id="redAlliance" onclick="updateAlliance(true)" class="btn btn-danger active">Red Alliance</button>
                    <button id="blueAlliance" onclick="updateAlliance(false)" class="btn btn-primary">Blue Alliance</button>
                </div>
                <br />
                <button class="btn" style="margin-top: 10px" onclick="sendData()">Continue to Autonomous &rarr;</button>
                <br /><br />
            </div>
        </div>

        <script type="text/javascript">
            var present = true;
            var deadRobot = false;
            var redAlliance = true;
                    
            $(document).ready(function() {
                window.scrollTo(0, 1);
            });  

            function updateCheckbox(num) {
                num === 0 ? present = !present : deadRobot = !deadRobot;
            }
                    
            function updateAlliance(red) {
                if(red) {
                    if(!redAlliance) {
                        redAlliance = !redAlliance;
                    }
                } else {
                    if(redAlliance) {
                        redAlliance = !redAlliance;
                    }
                }
            }

            function sendData() {
                var invisibleForm = document.getElementById('sendForm');            
                invisibleForm.innerHTML += "<input type='text' name='next_page' value='" + "forms/autonomous.php" + "'</input>";
                invisibleForm.innerHTML += "<input type='text' name='prematch_team_present' value='" + present + "'></input>";
                invisibleForm.innerHTML += "<input type='text' name='prematch_dead_robot' value='" + deadRobot + "'></input>";
                invisibleForm.innerHTML += "<input type='text' name='prematch_location' value='" + $("#location").val() + "'></input>";
                invisibleForm.innerHTML += "<input type='number' name='prematch_team_number' value='" + $("#teamNumber").val() + "'></input>";
                invisibleForm.innerHTML += "<input type='number' name='prematch_match_number' value='" + $("#matchNumber").val() + "'></input>";
                invisibleForm.innerHTML += "<input type='text' name='prematch_red_alliance' value='" + redAlliance + "'></input>";
                invisibleForm.submit();
            }

        </script>
        <form id="sendForm" action="../processdata.php" class="invisible_form" method="post"></form>
    </body>
</html>
<!--
keep this just in case we decide to use it
<p style="margin-bottom: 2px;" id="alliance">Alliance Partners:</p>
<input id="alliancePartner1" type="number" />
<input id="alliancePartner2" type="number" />
<p style="margin-bottom: 2px;" id="opposition">Opposing Alliance:</p>
<input id="opposition1" type="number" />
<input id="opposition2" type="number" />
<input id="opposition3" type="number" />-->

