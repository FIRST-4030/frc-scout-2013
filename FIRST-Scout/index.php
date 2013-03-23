<?php
session_start();
if(isset($_SESSION['UserID'])) {
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
            <p class="title" style="margin-bottom: 20px;">FIRST Scout: Login</p>
            <div class="alert alert-warning" id="inputError">
                <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                <strong id='alertError'><?php if (isset($_GET['error'])) echo stripcslashes($_GET['error']); ?></strong>
            </div>
            <input type="text" name="team_id" placeholder="Team ID" id="teamID" /><br> 
            <input type="text" name="user_id" placeholder="User ID" id="userID" /><br>
            <input type="password" name="team_password" placeholder="Password" id="teamPassword" /><br><br>
            <button class="btn" type="submit" onclick="sendData()" id='SubmitButton'>Log In</button>
            <br /><br />
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#inputError').hide();

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
                if ($("#userID").val() === "") {
                    errors += "<br />&bull; Enter your User ID.";
                }
                if ($("#teamPassword").val() === "") {
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
        </script>
        <form id="sendForm" action="/login.php?intent=login" class="invisible_form" method="post"></form>
    </body>
</html>
