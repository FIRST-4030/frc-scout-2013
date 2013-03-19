<!DOCTYPE html>
<html>
    <head>
        <title>FIRST Scout: Home</title>
        <!-- These work! -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>        
        <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <p class="title">Welcome to FIRST Scout!</p>
            <p class="small_title" style="margin-bottom: 10px;">Your are logged in as <b><?echo $_COOKIE['FIRSTScoutLoggedInUserID']?></b> for team <b><?echo $_COOKIE["FIRSTScoutLoggedInTeam"]?></b></p>
            <a href="/forms/prematch.php"><button class="btn btn-large btn-success">Scout a new team</button></a>
            <button class="btn btn-large btn-info">See results</button>
        </div>
    </body>
</html>