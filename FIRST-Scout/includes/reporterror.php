<?php
if(isset($_POST['error']) && !empty($_POST['error'])) {
    $error = $_POST['error'];
    mail("terabyte128@gmail.com", "Feedback from FIRST Scout", "User left feedback\r\n$error", "From: 'Scout Bot' <scout@ingrahamrobotics.org>");
    echo "Submitted successfully!";
}
else {
    echo "There was nothing to submit!";
}
?>
