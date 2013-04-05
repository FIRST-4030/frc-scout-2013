<? session_start() ?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <?
        if (!isset($_SESSION['TeamID'])) {
            header('location: ../index.php?error=' . urlencode("You must login first!"));
        }

        include '../includes/form-headers.html';
        ?>
        <title>Team Averages</title>
        <script type="text/javascript" src="../tablesorter/jquery.tablesorter.min.js"></script> 
        <script type="text/javascript" src="../visualize/visualize.jQuery.js"></script> 
        <!--[if IE]><script type="text/javascript" src="../visualize/excanvas.compiled.js"></script><![endif]-->
        <link href="../tablesorter/themes/blue/style.css" rel="stylesheet" type="text/css"/>
        <link type="text/css" rel="stylesheet" href="../visualize/css/visualize.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div class='container'>
            <p class='title'>Team Averages</p>
            <button class="btn btn-success" onclick="history.go(-1);" style="width: 200px">&larr;&nbsp;Go Back</button><br />
            <span style="margin-left: 5px;">Narrow by team: &nbsp;</span><input type="text" onkeyup="update($('#team').val(), $('#citySelector').val());" style="margin-top: 8px; margin-left: 2px; width: 60px;" id="team">
            <!--span style="margin-left: 5px;">or by location: &nbsp;</span><input type="text" onkeyup="update($('#team').val(), $('#location').val());" style="margin-top: 8px; margin-left: 2px; width: 60px;" id="location">-->
            <span> &nbsp;and/or city:&nbsp; </span>
            <select onchange="update($('#team').val(), $('#citySelector').val());" style="width: 140px; margin-top: 5px" id="citySelector"></select>


            <table class='tablesorter table-hover' id='resultsTable'>
                <caption style="display: none">Team Averages</caption>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Team Number</th>
                        <th>Matches Scouted</th>
                        <th>Total Points</th>
                        <th>Autonomous Points</th>
                        <th>Teleoperated Points</th>
                        <th>Pyramid Goal Points</th>
                        <th>Climbing Points</th>
                    </tr>
                </thead>
                <tbody id='tableBody'>
                </tbody>
            </table>
        </div>
        <script type='text/javascript'>
                $(document).ready(function() {
                    update('', '');
                    $("#resultsTable").tablesorter();
                    getLocations();
                });

                function updateTeams(team) {
                    if (window.XMLHttpRequest) {
                        xmlHttp = new XMLHttpRequest();
                    }

                    xmlHttp.onreadystatechange = function() {
                        $("#tableBody").html("Loading...");
                        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
                            $("#tableBody").html(xmlHttp.responseText);
                            $("#resultsTable").trigger("update");
                            //$('.visualize').trigger('visualizeRefresh');
                        }
                    };

                    var sendData = "search=" + search;
                    xmlHttp.open("POST", "get-team-averages.php", true);
                    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlHttp.send(sendData);
                }

                function update(team, location) {
                    if(location === "All") {
                        location = "";
                    }
                    $("#tableBody").html("Loading...");
                    $.ajax({
                        url: 'get-team-averages.php',
                        type: "POST",
                        data: {'team': team,
                            'location': location},
                        success: function(response, textStatus, jqXHR) {
                            $("#tableBody").html(response);
                            $("#resultsTable").trigger("update");
                        }
                    });
                }

                function getLocations() {
                    $.ajax({
                        url: '../includes/get-location.php',
                        type: 'POST',
                        success: function(response, textStatus, jqXHR) {
                            var locations = JSON.parse(response);
                            console.log(locations);
                            $("#citySelector").html("");
                            for (var i = 0; i < locations.length; i++) {
                                $("#citySelector").append('<option>' + locations[i] + '</option>');
                                console.log(locations[i]);
                            }
                        }
                    });
                }
        </script>
    </body>
</html>
