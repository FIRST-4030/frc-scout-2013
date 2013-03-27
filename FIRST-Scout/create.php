<?php
session_start();
if(isset($_SESSION['TeamID'])) {
    header('location: options?error=' . urlencode("Not only do you already have an accout, but you're logged in!"));
}
require 'includes/constants.php';
if (isset($_POST['team_id'])) {
    $teamID = $_POST['team_id'];
    $teamPassword = $_POST['team_password'];
    $teamNumber = $_POST['team_number'];
    $adminEmail = $_POST['team_email'];
    $errorMessage = "Please correct the following errors:<br />";
    if (empty($teamID)) {
        $errorMessage .= "&bull; Enter a Team ID.<br />";
    }
    if (empty($teamPassword)) {
        $errorMessage .= "&bull; Enter a team password.<br />";
    }
    if (empty($teamNumber)) {
        $errorMessage .= "&bull; Enter a team number.<br />";
    }
    if (empty($adminEmail)) {
        $errorMessage .= "&bull; Enter an admin email.<br />";
    }
    if (substr_count($errorMessage, "&bull;") > 0) {
        header('location:?error=' . urlencode($errorMessage));
    }

    require 'includes/constants.php';

    $db = mysqli_connect("localhost", DB_USER, DB_PASSWD, "stevenz9_robotics_scout");
    if (mysqli_connect_errno()) {
        echo('Failed to connect to database: ' . mysqli_connect_error());
    }

    $query = "INSERT INTO `scout_login` (team_id, team_password, team_number, team_admin_email) VALUES ('$teamID', md5('$teamPassword'), '$teamNumber', '$adminEmail')";
    if (mysqli_query($db, $query)) {
        header('location: index.php?error=' . urlencode("Accout created successfully! Please login now."));
        mail($adminEmail, "Your account has been created!", "FIRST Scout account created:\r\nTeam ID: $teamID\r\nTeam Password: $teamPassword\r\nTeam Number: $teamNumber\r\nAdmin email: $adminEmail", "From: 'Scout Bot' <scout@ingrahamrobotics.org>");
    } else {
        header('location: create.php?error=' . urlencode("Username not unique! Please try again."));
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Create Account</title>
        <? include "includes/form-headers.html"; ?>
    </head>
    <body>
        <div class="container">
            <? echo $check['team_number']; ?>
            <p class="title">Create Account</p>
            <p style="width: 700px; text-align: left; margin-left:  auto; margin-right: auto">FIRST Scout accounts are shared, team-wide. Each team has a shared <b>Team ID</b> and a shared <b>team password.</b> 
                Your Team ID can be your team number, but it doesn't have to. It is what you will use to login. <br /><br />
                When logging in, a scout will enter a <b>User ID</b> in addition to the <b>Team ID</b> and <b>team password.</b>
                The <b>User ID</b> is not stored as part of your team's information - it is simply used so that you can track who
                scouted what match.<br /><br/> 
                The account's <b>admin email</b> should be the email address of whoever is head of scouting for your team. It would only be used in case we need to contact you about something, it is never shared.
                <br /><br /></p>
            <div class="alert alert-warning" id="inputError">
                <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                <strong id='alertError'><?php if (isset($_GET['error'])) echo ($_GET['error']); ?></strong>
            </div>
            <p><strong>Ready to get started?</strong></p>
            <form method="post" action="create.php">
                Team ID:<br /><input type="text" name="team_id" placeholder="i.e. NullPointerException" value="<? $teamID ?>" /><br />
                Team Password:<br /><input type="password" name="team_password" placeholder="i.e. p@s$w0Rd" /><br />
                Team Number:<br /><input type="number" name="team_number" placeholder="i.e. 4030" /><br />
                Admin email:<br /><input type="email" name="team_email" placeholder="i.e. scout@ingrahamrobotics.org"><br /><br />
                <button class="btn btn-success" type="submit">Submit</button>
            </form>
        </div>
        <script type="text/javascript">
                    $(document).ready(function() {
                        $('#inputError').hide();

                        if (document.getElementById('alertError').innerHTML !== "") {
                            $('#inputError').show();
                        }
                    });
        </script>
    </body>
</html>