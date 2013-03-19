<!DOCTYPE html>
<html>
    <head>
        <title>FIRST Scout: Login</title>
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
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
            <? echo stripcslashes($_GET['error']); ?>
            <p class="title" style="margin-bottom: 20px;">FIRST Scout: Login</p>
            <form class="form_entry" method="post" action="login.php?intent=login">
                <input type="number" name="team_number" placeholder="Team Number" id="teamNumber" /><br> 
                <input type="text" name="user_id" placeholder="User ID" id="emailAddress" /><br>
                <input type="password" name="user_password" placeholder="Password" id="password" /><br><br>
                <button class="btn" type="submit" id='SubmitButton'>Log In</button>
            </form>
        </div>
        <br />
        <p><a href='/input_forms/'>Go to forms &rarr;</a></p>
    </body>
</html>
