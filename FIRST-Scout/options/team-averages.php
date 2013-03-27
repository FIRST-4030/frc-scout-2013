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
        <link href="../tablesorter/themes/blue/style.css" rel="stylesheet" type="text/css"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div class='container'>
            <p class='title'>Team Averages</p>
            <span style="margin-left: 5px;">Narrow by team: &nbsp;</span><input type="text" onkeyup="updateTeams($('#search').val())" style="margin-top: 8px; margin-left: 2px; width: 60px;" id="search">

            <table class='tablesorter' id='resultsTable'>
                <thead>
                <th>Team Number</th>
                <th>Total Points</th>
                <th>Autonomous Points</th>
                <th>Teleoperated Points</th>
                <th>Pyramid Goal Points</th>
                <th>Climbing Points</th>
                </thead>
                <tbody id='tableBody'>
                </tbody>
            </table>
        </div>
        <script type='text/javascript'>
                $(document).ready(function() {
                    updateTeams('');
                    $("#resultsTable").tablesorter();
                });

                function updateTeams(search) {
                    if (window.XMLHttpRequest) {
                        xmlHttp = new XMLHttpRequest();
                    }

                    xmlHttp.onreadystatechange = function() {
                        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                            $("#tableBody").html(xmlHttp.responseText);
                            $("#resultsTable").trigger("update");
                        }
                    }

                    var sendData = "search=" + search;
                    xmlHttp.open("POST", "get-team-averages.php", true);
                    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlHttp.send(sendData);
                }
        </script>
    </body>
</html>
