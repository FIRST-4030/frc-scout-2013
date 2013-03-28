<?php
$email = $_POST['email'];
$teamNumber = $_POST['team_number'];
$name = $_POST['name'];
$newPass = $_POST['new_password'];
$teamID = $_POST['team_id'];

if(!empty($email) && !empty($teamNumber) && !empty($name) && !empty($newPass) && !empty($teamID)) {
    mail("terabyte128@gmail.com", "Password reset requested on FIRST Scout", "Team $teamNumber requested a password reset:\r\n
            User: $name\r\n
            Team ID: $teamID\r\n
            Email: $email\r\n
            New password: $newPass", "From: 'Scout Bot' <scout@ingrahamrobotics.org>");
    echo "You should get a response relatively soon.";
} else {
    echo "You must've forgotten to fill out some fields.";
}
?>
