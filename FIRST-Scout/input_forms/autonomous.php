<!DOCTYPE html>
<html>    
    <head>
        <title>FIRST Scout: Login</title>
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
    </head>
    <body>
        <script type="text/javascript">
            $(document).ready(function() {
                var pointsScored = 0;
         
                $("#SixPointPlus").jqxRepeatButton({delay: 0, width: '100', height: '50', theme: 'theme'});
                $("#SixPointMinus").jqxRepeatButton({delay: 0, width: '40', height: '50', theme: 'theme'});
                $("#FourPointPlus").jqxRepeatButton({delay: 0, width: '100', height: '50', theme: 'theme'});
                $("#FourPointMinus").jqxRepeatButton({delay: 0, width: '40', height: '50', theme: 'theme'});
                $("#TwoPointPlus").jqxRepeatButton({delay: 0, width: '100', height: '50', theme: 'theme'});
                $("#TwoPointMinus").jqxRepeatButton({delay: 0, width: '40', height: '50', theme: 'theme'});
                $("#NextPageButton").jqxButton({ width: '220px', height: '30px', theme: 'theme'});
                
                $("#SixPointPlus").on("click", function() {
                    pointsScored += 6;
                    document.getElementById('totalPoints').innerHTML = "Total points scored: " + pointsScored;
                })
                $("#SixPointMinus").on("click", function() {
                    if(pointsScored - 6 >= 0) {
                        pointsScored -= 6;
                    }
                    document.getElementById('totalPoints').innerHTML = "Total points scored: " + pointsScored;
                });
                
                $("#FourPointPlus").on("click", function() {
                    pointsScored += 4;
                    document.getElementById('totalPoints').innerHTML = "Total points scored: " + pointsScored;
                })
                $("#FourPointMinus").on("click", function() {
                    if(pointsScored - 4 >= 0) {
                        pointsScored -= 4;
                    }
                    document.getElementById('totalPoints').innerHTML = "Total points scored: " + pointsScored;
                });
                
                $("#TwoPointPlus").on("click", function() {
                    pointsScored += 2;
                    document.getElementById('totalPoints').innerHTML = "Total points scored: " + pointsScored;
                })
                $("#TwoPointMinus").on("click", function() {
                    if(pointsScored - 2 >= 0) {
                        pointsScored -= 2;
                    }
                    document.getElementById('totalPoints').innerHTML = "Total points scored: " + pointsScored;
                });
            });
        </script>

        <div class="container">
            <p class="title">Autonomous Mode</p>
            <p><i>Record points for each goal</i></p>
            6 Point Goal: <input type="button" id="SixPointPlus" value="Add" class="input_forms" />
            <input type="button" id="SixPointMinus" value="-" class="input_forms" /> <br><br>
            4 Point Goal: <input type="button" id="FourPointPlus" value="Add" class="input_forms" />
            <input type="button" id="FourPointMinus" value="-" class="input_forms" /> <br><br>
            2 Point Goal: <input type="button" id="TwoPointPlus" value="Add" class="input_forms" />
            <input type="button" id="TwoPointMinus" value="-" class="input_forms" /> <br>
            <p id="totalPoints" style="font-weight: bold"></p>
            <input type="button" id="NextPageButton" value="Continue to Teleoperated &rarr;">
            <br><br>
        </div>
    </body>
</html>