<?php session_start(); 
if(!isset($_SESSION['TeamNumber'])) {
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
            <p class="title">Welcome to FIRST Scout!</p>
            <p class="small_title" style="margin-bottom: 10px;">Your are logged in as <b><? echo $_SESSION['UserID'] ?></b> for team <b><? echo $_SESSION["TeamNumber"] ?></b></p>
            <button class="btn btn-large btn-success homepage_buttons" onclick="goToPage('/forms/prematch.php')">Scout a new team</button>
            <br />
            <button class="btn btn-large btn-info homepage_buttons">See results</button>
            <br />
            <button class="btn btn-large btn-warning homepage_buttons" onclick="goToPage('/login.php?intent=logout')">Log out</button>

        </div>
        <script type="text/javascript">
                function goToPage(page) {
                    window.location = page;
                }
        </script>
    </body>
</html>