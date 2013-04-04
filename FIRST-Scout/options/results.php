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
        <link href="../tablesorter/themes/blue/style_foo.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>                
        <div class="results_container">
            <p class="title" id="title">Results collected by all teams</input></p>
            <button class="btn btn-success" onclick="history.go(-1);" style="width: 200px">&larr;&nbsp;Go Back</button><br />
            <div class="btn-group" data-toggle="buttons-radio" style="margin-top: 10px; margin-bottom: 10px">
                <button class="btn active" value="false" onclick="updateTeams(false, $('#search').val());">All Teams</button>


                <button class="btn" value="true "onclick="updateTeams(true, $('#search').val());">Only <? echo $teamNumber ?></button>
            </div>
            <span style="margin-left: 5px;">Search: </span><input type="text" onkeyup="updateTeams($('.resultsByTeam .active').val(), $('#search').val());" style="margin-top: 9px; margin-left: 2x;" id="search" placeholder='team, location, comments, date'>
            <table id="resultTable" class="tablesorter table-hover">
                <thead>
                    <tr>
                        <th id="delete">Delete</th>
                        <th>Team</th>
                        <th>Date</th>
                        <th>Scout name</th>
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
                        <th>Speed (1-3)</th>
                        <!--<th>Climb Attempts</th>-->
                        <th>Level Reached</th>
                        <th>Pyramid Goals</th>
                        <th>Style</th>
                        <th>Match Outcome</th>
                        <!--<th>Fouls</th>-->
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
                    updateTeams(false, "");
                });

                function updateTeams(onlyTeam, search) {
                    tableBody = document.getElementById('tableBody');
                    tableBody.innerHTML = "Loading";
                    if (onlyTeam) {
                        document.getElementById('title').innerHTML = "Results collected by team <? echo $teamNumber ?>";
                        $("#delete").show();
                        //$("#scoutName").show();
                    } else {
                        document.getElementById('title').innerHTML = "Results collected by all teams";
                        $("#delete").hide();
                        //$("#scoutName").hide();
                    }

                    if (window.XMLHttpRequest) {
                        xmlHttp = new XMLHttpRequest();
                    }

                    xmlHttp.onreadystatechange = function() {
                        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
                            tableBody.innerHTML = xmlHttp.responseText;
                            $("#resultTable").tablesorter();
                            $("#resultTable").trigger("update");
                        }
                    };
                    xmlHttp.open("POST", "get-results.php", true);
                    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    var sendData = "only=" + onlyTeam + "&search=" + search;
                    xmlHttp.send(sendData);
                }

                function deleteTeam(id) {
                    var answer = confirm("Are you sure you want to delete this match data?");
                    if (answer) {
                        if (window.XMLHttpRequest) {
                            xmlHttp = new XMLHttpRequest();
                        }
                        xmlHttp.onreadystatechange = function() {
                            if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
                                alert(xmlHttp.responseText);
                                updateTeams(false, $('#search').val());
                            }
                        };
                        xmlHttp.open("POST", "delete.php", true);
                        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        var sendData = "id=" + id;
                        xmlHttp.send(sendData);
                    }
                }
        </script>
    </body>
</html>