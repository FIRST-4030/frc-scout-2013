<!DOCTYPE html>
<html>
    <head>
        <title>FIRST Scout</title>
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="twelvecol">
                    <p class="title">FIRST Scout: Login</p>
                    <?php if(isset($_GET('error'))) {
                       echo '<p>' . $_GET('error') . '</p>'; 
                    }?>
                    <form method="post" action="login/submit.php">
                        <input type="text" name="team_number" placeholder="Team Number"><br> 
                        <input type="email" name="user_email" placeholder="Email Address"><br>
                        <input type="password" name="user_password" placeholder="Password"><br>
                        <input type="submit" value="Log In" style="margin-top: 5px">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
