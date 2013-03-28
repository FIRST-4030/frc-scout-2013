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
            <button class="btn btn-success" onclick="history.go(-1)" style="width: 200px">&larr;&nbsp;Go Back</button><br />
            <span style="margin-left: 5px;">Narrow by team: &nbsp;</span><input type="text" onkeyup="updateTeams($('#search').val())" style="margin-top: 8px; margin-left: 2px; width: 60px;" id="search">

            <table class='tablesorter table-hover' id='resultsTable'>
                <caption style="display: none">Team Averages</caption>
                <thead>
                    <tr>
                        <th>Team Number</th>
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
                updateTeams('');
                $("#resultsTable").tablesorter();
                //$("#resultsTable").visualize();
            });

            function updateTeams(search) {
                if (window.XMLHttpRequest) {
                    xmlHttp = new XMLHttpRequest();
                }

                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                        $("#tableBody").html(xmlHttp.responseText);
                        $("#resultsTable").trigger("update");
                        //$('.visualize').trigger('visualizeRefresh');
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
