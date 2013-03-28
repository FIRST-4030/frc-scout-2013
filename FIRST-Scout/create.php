<?php
session_start();
if (isset($_SESSION['UserID'])) {
    header('location: options?error=' . urlencode("Not only do you already have an accout, but you're logged in!"));
}

require 'includes/constants.php';
if (isset($_POST['team_id'])) {

    $teamID = preg_replace('/[^\w ]/', '', $_POST['team_id']);
    $teamPassword = $_POST['team_password'];
    $teamNumber = preg_replace('/[^\w ]/', '', $_POST['team_number']);
    $adminEmail = preg_replace('/[^\w@\.\-\+]/', '', $_POST['team_email']);

	try {
		$db = new PDO(DSN, DB_USER, DB_PASSWD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $ex) {
		die("Unable to connect to DB\n " . $ex->getMessage());
	}

	$success = false;
	try {
		$stmt = $db->prepare('INSERT INTO `scout_login` (team_id, team_password, team_number, team_admin_email) VALUES (?, md5(?), ?, ?)');
		$success = $stmt->execute(array($teamID, $teamPassword, $teamNumber, $adminEmail));
	} catch (PDOException $ex) {
		die("Unable to add team\n " . $ex->getMessage());
	}
	
	if ($success) {
		header('location: index.php?error=' . urlencode("Accout created successfully! Please login now."));
		mail($adminEmail, "Your account has been created!", "FIRST Scout account created:\r\nTeam ID: $teamID\r\nTeam Password: $teamPassword\r\nTeam Number: $teamNumber\r\nAdmin email: $adminEmail", "From: 'Scout Bot' <scout@ingrahamrobotics.org>");
	} else {
		header('location: create.php?error=' . urlencode("Your username was not unique!"));
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
            <form method="post" action="create.php" id="create">
                <span id="uname">Team ID:</span><br /><input type="text" name="team_id" id="team_id" placeholder="i.e. NullPointerException" onkeyup="checkID($('#team_id').val())" value="<? $teamID ?>" /><br />
                Team Password:<br /><input type="password" name="team_password" id="team_password" placeholder="i.e. p@s$w0Rd" /><br />
                Team Number:<br /><input type="number" name="team_number" id="team_number" placeholder="i.e. 4030" /><br />
                Admin email:<br /><input type="email" name="team_email" id="admin_email" placeholder="i.e. scout@ingrahamrobotics.org">
            </form>
            <button class="btn btn-success" onclick="submit()">Submit</button>
            <br /><br />
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#inputError').hide();

                if (document.getElementById('alertError').innerHTML !== "") {
                    $('#inputError').show();
                }
            });
                    
            function checkID(id) {
                if (window.XMLHttpRequest) {
                    xmlHttp = new XMLHttpRequest();
                }

                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                        var isInUse = xmlHttp.responseText;
                        if(isInUse === "true") {
                            $("#team_id").css("color", "red");
                            $("#uname").html("Team ID: <b><span style='color:red'>already in use!</span></b>")
                        } else {
                            $("#team_id").css("color", "green");
                            $("#uname").html("Team ID:")
                        }
                    }
                }
                xmlHttp.open("POST", "includes/verify.php", true);
                xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                var sendData = 'team_id=' + id;
                xmlHttp.send(sendData);
            }
            
            function checkInputs() {
                var returned = true;
                errors = "Please correct the following errors:";
                if ($("#team_id").val() === "") {
                    errors += "<br />&bull; Enter a Team ID.";
                    returned = false;
                }
                if ($("#team_password").val() === "") {
                    errors += "<br />&bull; Enter a team password.";
                    returned = false;
                }
                if ($("#team_number").val() === "") {
                    errors += "<br />&bull; Enter your team's number.";
                    returned = false;
                }
                if ($("#admin_email").val() === "") {
                    errors += "<br />&bull; Enter an email address.";
                    returned = false;
                }
                return returned;
            }
            
            function submit() {
                if(checkInputs()) {
                    $("#create").submit();               
                } else {
                    document.getElementById('alertError').innerHTML = errors;
                    $("#inputError").show();
                }
            }
        </script>
    </body>
</html>
