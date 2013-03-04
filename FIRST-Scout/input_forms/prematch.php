<!DOCTYPE html>
<html>    
    <head>
        <title>Pre-match Information</title>
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->

        <!-- These work! -->
        <script type="text/javascript" src="../jqwidgets/scripts/gettheme.js"></script>
        <link rel="stylesheet" href="../jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
        <script type="text/javascript" src="../jqwidgets/scripts/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxcore.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxbuttons.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxinput.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxnumberinput.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxradiobutton.js"></script>
        <link href='../css/custom.css' rel="stylesheet" type="text/css">

        <script type="text/javascript">
            $(document).ready(function() {
                $("#teamNumber").jqxInput({width: '100', height: '30', theme: 'custom', placeHolder: ' Team Number'});
                $("#matchNumber").jqxInput({width: '100', height: '30', theme: 'custom', placeHolder: ' Match Number'});
                
                $("#redAlliance").jqxRadioButton({ width: 100, height: 25, theme: 'custom', checked: 'true' });
                $("#blueAlliance").jqxRadioButton({ width: 100, height: 25, theme: 'custom' });
            });
        </script>
    </head>

    <body>
        <div class="container" id="jqxWidget">
            <p class="title">Pre-match Information</p>
            
            <input id="teamNumber" />
            <input id="matchNumber" />
            <p>Choose Alliance</p>
            <div id="redAlliance"><font color="red"><span>Red</span></font></div>
            <div id='blueAlliance'><font color='blue'><span>Blue</span></font></div>
        </div>
    </body>
</html>

