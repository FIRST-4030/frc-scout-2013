<!DOCTYPE html>
<html>    
    <head>
        <title>Autonomous Recording</title>
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
        <script type="test/javascript" src="../includes/Cookies.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxcheckbox.js"></script>
        <script type="text/javascript" src="../functions/Cookies.js"></script>
        <link href='../css/custom.css' rel="stylesheet" type="text/css">

    </head>
    <body>
        <div class="container">
            <p class="title">Autonomous Mode</p>
            <div id="usedKinect" style="margin-left: auto; margin-right: auto; margin-top: 5px; margin-bottom: 5px; font-family: Ubuntu, Arial, sans-serif; font-size: 18px">Used Kinect</div>
            <p><i>Record points for each goal</i></p>
            <input type="button" onclick="update(0, false);" id="SixPointPlus" value="+6" class="input_forms" />
            <input type="button" onclick="update(0, true);" id="SixPointMinus" value="&mdash;" class="input_forms" /> 
            <span id="autoSixPoint" class="autonomousIndividual">0</span>
            <br><br>
            <input type="button" onclick="update(1, false);" id="FourPointPlus" value="+4" class="input_forms" />
            <input type="button" onclick="update(1, true);" id="FourPointMinus" value="&mdash;" class="input_forms" /> 
            <span id="autoFourPoint" class="autonomousIndividual">0</span>

            <br><br>
            <input type="button" onclick="update(2, false);" id="TwoPointPlus" value="+2" class="input_forms" />
            <input type="button" onclick="update(2, true);" id="TwoPointMinus" value="&mdash;" class="input_forms" /> 
            <span id="autoTwoPoint" class="autonomousIndividual">0</span>
            
            <br><br>
            <input type="button" onclick="update(3, false);" id="MissedPointPlus" value="Missed" class="input_forms" />
            <input type="button" onclick="update(3, true);" id="MissedPointMinus" value="&mdash;" class="input_forms" /> 
            <span id="autoMissedPoints" class="autonomousIndividual">0</span>
            
            <br>
            <p style="font-weight: bold">Total Points: <span id="totalPoints">0</span></p>

            <input type="button" class="centered" id="NextPageButton" value="Continue to Teleoperated &rarr;">
            <br>
            <p id="id" />
        </div>
        <script type="text/javascript">
            var autonomousPoints = [0, 0, 0, 0];

            $(document).ready(function() {
                //get rid of the title bar if it's a mobile device
                window.scrollTo(0, 1)

                $("#SixPointPlus").jqxRepeatButton({delay: 100, width: '100', height: '50', theme: 'custom'});
                $("#SixPointMinus").jqxRepeatButton({delay: 100, width: '50', height: '50', theme: 'custom'});
                $("#FourPointPlus").jqxRepeatButton({delay: 100, width: '100', height: '50', theme: 'custom'});
                $("#FourPointMinus").jqxRepeatButton({delay: 100, width: '50', height: '50', theme: 'custom'});
                $("#TwoPointPlus").jqxRepeatButton({delay: 100, width: '100', height: '50', theme: 'custom'});
                $("#TwoPointMinus").jqxRepeatButton({delay: 100, width: '50', height: '50', theme: 'custom'});
                $("#MissedPointPlus").jqxRepeatButton({delay: 100, width: '100', height: '50', theme: 'custom'});
                $("#MissedPointMinus").jqxRepeatButton({delay: 100, width: '50', height: '50', theme: 'custom'});
                $("#NextPageButton").jqxButton({width: '252px', height: '50px', theme: 'custom'});
                $("#usedKinect").jqxCheckBox({width: 150, height: 20, theme: 'theme'});

                $("#NextPageButton").on("click", function() {
                    window.location = "teleop.php";
                });
            });
                

            function update(index, negative) {
                if (autonomousPoints[index] > 0) {
                    autonomousPoints[index] += 1 * negative ? (-1) : (1);
                } else if (!negative) {
                    autonomousPoints[index]++;
                }
                updateIndividualTotals();
                updateTotals();
            }

            function updateIndividualTotals() {
                document.getElementById('autoSixPoint').innerHTML = autonomousPoints[0];
                document.getElementById('autoFourPoint').innerHTML = autonomousPoints[1];
                document.getElementById('autoTwoPoint').innerHTML = autonomousPoints[2];
                document.getElementById('autoMissedPoints').innerHTML = autonomousPoints[3];
            }

            function updateTotals() {
                document.getElementById('totalPoints').innerHTML = (autonomousPoints[0] * 6) + (autonomousPoints[1] * 4) + (autonomousPoints[2] * 2);
            }
                
        </script>
    </body>
</html>