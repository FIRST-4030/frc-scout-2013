<?php
session_start();
if (isset($_SESSION['UserID'])) {
    header('location: options?error=' . urlencode("You're logged in!"));
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>FIRST Scout: Login</title>
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
        <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="/css/style.css" rel="stylesheet" type="text/css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->

        <!-- These work! -->
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>        
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap-tooltip.js"></script>
    </head>
    <body>

        <script type="text/javascript">
            $(document).ready(function() {
                window.scrollTo(0, 1);
            });
        </script>

        <div class="container">
            <!--<a href="/index.php">--><img src="/images/ram-logo.png" alt="FIRST Scout"><!--</a>-->
            <br>
            <p class="title" style="margin-bottom: 20px;">FIRST Scout <b>beta</b>: Login</p>
            <div class="alert alert-warning" id="inputError">
                <button type="button" class="close" onclick="$('.alert').hide();">&times;</button>
                <strong id='alertError'><?php if (isset($_GET['error'])) echo stripcslashes($_GET['error']); ?></strong>
            </div>
            <input type="text" name="team_id" value="Team ID" onblur="if (this.value === '')
                    this.value = 'Team ID';" onfocus="if (this.value === 'Team ID')
                    this.value = '';" id="teamID" /><br> 
            <input type="text" name="user_id" value="Your name" onblur="if (this.value === '')
                    this.value = 'Your name';" onfocus="if (this.value === 'Your name')
                    this.value = '';" id="userID" /><br>
            <input type="password" name="team_password" value="akjsdfha3323rs" onblur="if (this.value === '')
                    this.value = 'akjsdfha3323rs';" onfocus="if (this.value === 'akjsdfha3323rs')
                    this.value = '';" id="teamPassword" /><br><br>
            <button class="btn" type="submit" style="height: 30px; width: 220px" onclick="sendData();" id='SubmitButton'>Log In</button><p style="margin-top: 5px; margin-bottom: 5px; font-weight: bold">or</p>
            <button class="btn btn-success" style="height: 30px; width: 220px" onclick="window.location = 'create.php';">Create an account</button><br /><br />
            <p style="color: #be3b3b">Comments, questions, concerns, bugs? Talk to Sam in team 4030's pit (at the Seattle regional) or <a href="#" onclick="reportError();" style="">click here</a>.</p>
            <div id="reportError">
                <textarea id="error_submit" placeholder="Enter any information." style="width: 190px; height: 100px"></textarea>
                <br />
                <button class="btn btn-success" onclick="submitFeedback();">Submit</button>
                <br /><br />
            </div>
            <a href="#" onclick="pwdreset();">Forgot your password?</a>
            <div id="resetPane">
                Name: <input type="text" id="name" /><br />
                Email: <input type="email" id="email" /><br />
                Team ID: <input type="text" id="team_id" /><br />
                Team Number: <input type="number" id="team_number" /><br />
                New Password: <input type="password" id="new_password" /><br />
                <button id="resetSubmit" onclick="resetPass();" class="btn">Submit</button>
            </div>
            <br /><br />
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#inputError').hide();
                $("#resetPane").hide();
                $("#reportError").hide();
                //$("#submitButton").popover({title: "Need an account?", content: "Don't have an accout? <a href='create.php'>Click here</a> to get one!", placement: 'left'});
                //$("#submitButton").popover('show');
                if (document.getElementById('alertError').innerHTML !== "") {
                    $('#inputError').show();
                }
            });

            var errors = "";
            function checkInputs() {
                errors = "Please correct the following errors:";
                if ($("#teamID").val() === "") {
                    errors += "<br />&bull; Enter your Team ID.";
                }
                else if ($("#userID").val() === "") {
                    errors += "<br />&bull; Enter your User ID.";
                }
                else if ($("#teamPassword").val() === "") {
                    errors += "<br />&bull; Enter your team password.";
                } else {
                    return true;
                }
                return false;
            }

            function sendData() {
                if (checkInputs()) {
                    var invisibleForm = document.getElementById('sendForm');
                    invisibleForm.innerHTML += "<input type='text' name='team_id' value='" + $('#teamID').val() + "'</input>";
                    invisibleForm.innerHTML += "<input type='text' name='user_id' value='" + $('#userID').val() + "'></input>";
                    invisibleForm.innerHTML += "<input type='password' name='team_password' value='" + $('#teamPassword').val() + "'></input>";
                    invisibleForm.submit();
                } else {
                    document.getElementById('alertError').innerHTML = errors;
                    $("#inputError").show();
                }
            }

            function resetPass() {
                if (window.XMLHttpRequest) {
                    xmlHttp = new XMLHttpRequest();
                }

                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
                        alert(xmlHttp.responseText);
                        $("#resetPane").hide();
                    }
                };

                var sendData = "email=" + $("#email").val() + "&team_number=" + $("#team_number").val() + "&name=" + $("#name").val() + "&new_password=" + $("#new_password").val() + "&team_id=" + $("#team_id").val();
                xmlHttp.open("POST", "includes/passwordreset.php", true);
                xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlHttp.send(sendData);
            }

            function pwdreset() {
                $("#resetPane").toggle();
            }

            function reportError() {
                $("#reportError").toggle();
            }

            function submitFeedback() {
                if (window.XMLHttpRequest) {
                    xmlHttp = new XMLHttpRequest();
                }

                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
                        $('#alertError').html(xmlHttp.responseText);
                        $('#inputError').show();
                        if (xmlHttp.responseText === "Submitted successfully!") {
                            $("#reportError").hide();
                        }
                    }
                };

                var sendData = "error=" + encodeURI($("#error_submit").val());
                xmlHttp.open("POST", "includes/reporterror.php", true);
                xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlHttp.send(sendData);
            }
        </script>
        <form id="sendForm" action="/login.php" class="invisible_form" method="post"></form>
    </body>
</html>
