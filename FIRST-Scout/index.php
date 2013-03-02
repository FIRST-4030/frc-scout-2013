<!DOCTYPE html>
<html>
    <head>
        <title>FIRST Scout: Login</title>
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
        
        <!-- These work! -->
        <script type="text/javascript" src="jqwidgets/scripts/gettheme.js"></script>
        <link rel="stylesheet" href="jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
        <script type="text/javascript" src="jqwidgets/scripts/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="jqwidgets/jqwidgets/jqxcore.js"></script>
        <script type="text/javascript" src="jqwidgets/jqwidgets/jqxbuttons.js"></script>
        <script type="text/javascript" src="jqwidgets/jqwidgets/jqxinput.js"></script>
    </head>
    <body>
        
        <script type="text/javascript">
            $(document).ready(function() {
               $("#SubmitButton").jqxButton({ width: '160px', height: '30px', theme: 'theme'});
               $("#teamNumber").jqxInput({width: '160px', height: '30px', theme: 'theme', placeHolder: 'Team Number'});
               $("#emailAddress").jqxInput({width: '160px', height: '30px', theme: 'theme', placeHolder: 'Email Address'});
               $("#password").jqxInput({width: '160px', height: '30px', theme: 'theme', placeHolder: 'Password'});

            });
        </script>
        
        <div class="container">
            <a href="/index.php"><img src="/images/ram-logo.png" alt="FIRST Scout"></a>
            <br>
            <? echo stripcslashes($_GET['error']); ?>
            <p class="title">FIRST Scout: Login</p>
            <form class="form_entry" method="post" action="submit.php">
                <input type="text" name="team_number" id="teamNumber" class="form_widgets" /><br> 
                <input type="email" name="user_email" id="emailAddress" class="form_widgets" /><br>
                <input type="password" name="user_password" id="password" class="form_widgets" /><br>
                <input type="submit" value="Log In" id='SubmitButton' class="form_widgets" />
            </form>
        </div>
    </body>
</html>
