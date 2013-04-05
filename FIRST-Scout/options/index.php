<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    header("location: /index.php?error=" . urlencode("You must log in first!"));
}
?>
<!DOCTYPE html>
<html>
    <style type="text/css">
        .container {
            /* blue */
            background-color:#5261ff;
            /* red */
            background-color:#ff3838;
        }
    </style>
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
        <script type="text/javascript" src="../tablesorter/jquery.tablesorter.min.js"></script> 
        <link href="../tablesorter/themes/blue/style_foo.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container">
            <p class="title">Welcome back to FIRST Scout!</p>
            <div class="alert alert-warning" id="inputError">
                <button type="button" class="close" onclick="$('.alert').hide();">&times;</button>
                <strong id='alertError'><?php if (isset($_GET['error'])) echo stripcslashes($_GET['error']); ?></strong>
            </div>
            <p class="small_title" style="margin-bottom: 10px;">You are logged in as <b><? echo $_SESSION['UserID'] ?></b> for team <b><? echo $_SESSION["TeamNumber"] ?></b> in <b><? echo $_SESSION['Location'] ?></b></p>
            <button class="btn btn-large btn-success homepage_buttons" onclick="goToPage('/entry-ajax.php');">Scout a new team</button>
            <br />
            <button class="btn btn-large btn-info homepage_buttons" onclick="goToPage('team-averages.php');">See team averages</button>
            <br />
            <button class="btn btn-large btn-info homepage_buttons" onclick="goToPage('results.php');">See match results</button>
            <br />
            <button class="btn btn-large btn-warning homepage_buttons" onclick="goToPage('/login.php?intent=logout');">Log out</button>
            <br />
            <div id='comment_feed_load' style='margin: 5px; padding: 5px'>
                <p class='small_title'>Comments made about your team's matches:</p>
                <table id='comment_feed_table' class='tablesorter table-hover'>
                    <thead>
                    <th>Date</th>
                    <th>Match</th>
                    <th>Location</th>
                    <th>Comments</th>
                    </thead>
                    <tbody id='comments_feed'>

                    </tbody>
                </table>
            </div>
            <br />
            <p style="color: #be3b3b">Comments, questions, concerns, bugs?<br />Talk to Sam in team 4030's pit (at the Spokane, WA regional) or <a href="#" onclick="$('#reportError').toggle()" style=""><span style="color: #be3b3b">click here</span></a>.</p>

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
                        $("#alertError").html($("#alertError").html() + "Please <b>do not</b> enter practice match data, it will interfere with the real data!");
                        $("#reportError").hide();
                        loadComments();
                        $("#comment_feed_table").tablesorter();
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

                    function loadComments() {
                        $.ajax({
                            url: 'get-comments.php',
                            success: function(response, textStatus, jqXHR) {
                                var comments = JSON.parse(response);
                                for (var i = 0; i < comments.length; i++) {
                                    $("#comments_feed").append('<tr>');
                                    $("#comments_feed").append('<td>' + comments[i].timestamp.substring(0, 10) + '</td>');
                                    $("#comments_feed").append('<td><a href="single-match-review.php?redir&match=' + comments[i].match_id + '">' + comments[i].match_number + '</a></td>');
                                    $("#comments_feed").append('<td>' + comments[i].location + '</td>');
                                    $("#comments_feed").append('<td>' + comments[i].comments.replace("\\", "") + '</td>');
                                    $("#comments_feed").append('</tr>');
                                }
                                $("#comment_feed_table").trigger("update");
                            }
                        });
                    }
        </script>
    </body>
</html>