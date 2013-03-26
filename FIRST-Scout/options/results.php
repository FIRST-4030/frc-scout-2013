<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header('location: ../index.php?error=' . urlencode("Please login first!"));
}
$teamNumber = $_SESSION['TeamNumber'];
?>
<!DOCTYPE html>
<html>
    <head>
        <?
        include '../includes/form-headers.html';
        ?>
        <title>Team Results</title>
        <script type="text/javascript" src="../tablesorter/jquery.tablesorter.min.js"></script> 
        <link href="../tablesorter/themes/blue/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>                
        <div class="results_container">
            <p class="title" id="title">Results for all teams</input></p>
            <a href="<? echo $teamButtonAction ?>"><? echo $teamButtonText ?></a>
            <div class="btn-group" data-toggle="buttons-radio" style="margin-top: 10px; margin-bottom: 10px">
                <button id="redAlliance" class="btn active" onclick="updateTeams(false)">All Teams</button>
                <button id="blueAlliance" class="btn" onclick="updateTeams(true)">Only <? echo $teamNumber ?></button>
            </div>
            <span style="margin-left: 5px;">Search: </span><input type="text" style="margin-top: 9px; margin-left: 2x;" name="search" placeholder='team, location, comments, date'>
            <table id="resultTable" class="tablesorter">
                <thead>
                    <tr>
                        <th>Team</th>
                        <th>Date</th>
                        <th id="scoutName">Scout name</th>
                        <th>Scouted by team</th>
                        <th>Present</th>
                        <th>Dead Robot</th>
                        <th>Alliance</th>
                        <th>Location</th>
                        <th>Match</th>
                        <th>Total Points</th>
                        <th>Total Goals</th>
                        <th>Autonomous Points</th>
                        <th>Autonomous Accuracy</th>
                        <th>Frisbee pickup</th>
                        <th>Can block?</th>
                        <th>Teleop Points</th>
                        <th>Teleop Accuracy</th>
                        <th>Shooting Range</th>
                        <th>Speed (1-4)</th>
                        <th>Maneuverability (1-4)</th>
                        <th>Climb Attempts</th>
                        <th>Level Reached</th>
                        <th>Pyramid Goals</th>
                        <th>Style</th>
                        <th>Match Outcome</th>
                        <th>Fouls</th>
                        <th>Technical Fouls</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody id="tableBody">

                </tbody>
            </table>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#resultTable").tablesorter();
                updateTeams(false);
            });
            
            function updateTeams(onlyTeam) {
                tableBody = document.getElementById('tableBody');
                tableBody.innerHTML = "Loading";
                if(onlyTeam) {
                    document.getElementById('title').innerHTML = "Results for team <? echo $teamNumber ?>";
                    $("#scoutName").show();
                } else {
                    document.getElementById('title').innerHTML = "Results for all teams";                   
                    $("#scoutName").hide();
                }
                
                if(window.XMLHttpRequest) {
                    xmlHttp = new XMLHttpRequest();
                }
                xmlHttp.onreadystatechange = function() {
                    if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                        tableBody.innerHTML = xmlHttp.responseText;
                    }
                }
                xmlHttp.open("POST","get-results.php",true);  
                xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");  
                xmlHttp.send("only=" + onlyTeam);
            }
        </script>
    </body>
</html>