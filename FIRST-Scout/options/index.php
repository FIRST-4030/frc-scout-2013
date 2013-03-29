<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    header("location: /index.php?error=" . urlencode("You must log in first!"));
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>FIRST Scout: Home</title> 
        <!-- These work! -->
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>        
        <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <p class="title">Welcome back to FIRST Scout!</p>
            <div class="alert alert-warning" id="inputError">
                <button type="button" class="close" onclick="$('.alert').hide();">&times;</button>
                <strong id='alertError'><?php if (isset($_GET['error'])) echo stripcslashes($_GET['error']); ?></strong>
            </div>
            <p class="small_title" style="margin-bottom: 10px;">You are logged in as <b><? echo $_SESSION['UserID'] ?></b> for team <b><? echo $_SESSION["TeamNumber"] ?></b></p>
            <button class="btn btn-large btn-success homepage_buttons" onclick="goToPage('/entry.php');">Scout a new team</button>
            <br />
            <button class="btn btn-large btn-info homepage_buttons" onclick="goToPage('team-averages.php');">See team averages</button>
            <br />
            <button class="btn btn-large btn-info homepage_buttons" onclick="goToPage('results.php');">See match results</button>
            <br />
            <button class="btn btn-large btn-warning homepage_buttons" onclick="goToPage('/login.php?intent=logout');">Log out</button>
            <br /><br />
            <p style="color: #be3b3b">Comments, questions, concerns, bugs? Talk to Sam in team 4030's pit (at the Seattle regional) or <a href="#" onclick="$('#reportError').toggle()" style=""><span style="color: #be3b3b">click here</span></a>.</p>

            <div id="reportError">
                <textarea id="error_submit" placeholder="Enter any information." style="width: 190px; height: 100px"></textarea>
                <br />
                <button class="btn btn-success" id="submit_feedback" onclick="submitFeedback();" data-loading-text="Submitting...">Submit</button>
                <br /><br />
            </div>

        </div>
        <script type="text/javascript">
            function goToPage(page) {
                window.location = page;
            }

            function goToPageCheck(page) {
                var response = confirm("Are you sure? Once you begin you cannot go back!");
                if (response) {
                    window.location = page;
                }
            }

            $(document).ready(function() {
                if (document.getElementById('alertError').innerHTML !== "") {
                    $('#inputError').show();
                    $("#alertError").html($("#alertError").html() + "<br>");
                }
                $("#alertError").html($("#alertError").html() + "Please <b>do not</b> enter fake match data at this point, it will interfere with the real data!");
                //$("#inputError").hide();
                $("#reportError").hide();
            });

            function submitFeedback() {
                $("#submit_feedback").button('loading');
                if (window.XMLHttpRequest) {
                    xmlHttp = new XMLHttpRequest();
                }

                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
                        $('#alertError').html(xmlHttp.responseText);
                        $('#inputError').show();
                        $("#submit_feedback").button('reset');
                        if (xmlHttp.responseText === "Submitted successfully!") {
                            $("#reportError").hide();
                            $("#error_submit").html("");
                        }
                    }
                };

                var sendData = "error=" + encodeURI($("#error_submit").val());
                xmlHttp.open("POST", "../includes/reporterror.php", true);
                xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlHttp.send(sendData);
            }    
        </script>
    </body>
</html>