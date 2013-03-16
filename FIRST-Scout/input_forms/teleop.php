<!DOCTYPE html>
<html>    
    <head>
        <title>Teleoperated Recording</title>
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
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxscrollbar.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxlistbox.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxslider.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxcheckbox.js"></script>

        <link href='../css/custom.css' rel="stylesheet" type="text/css">
    </head>

    <body>
        <!--
        TODO:
        - disks scored on high, med, low (same as auto) DONE
        - range capability (less than half, center, full court) DONE & FIXED
        - shooting aim (1-10) NOT NECESSARY - using attempted goals
        - disk pickup ability (boolean) DONE
        - robot speed (1-10) DONE more or less ~
        - robot maneuverability (1-10) DONE more or less ~
        - goals blocked (number) DONE
        - shots missed DONE
        -->

        <div class="container">
            <p class="title">Teleoperated Mode</p>
            <div id="PickupDisks" style="margin-left: auto; margin-right: auto; margin-top: 5px; margin-bottom: 5px; font-family: Ubuntu, Arial, sans-serif; font-size: 18px">Can pick up frisbees</div>
            <p><i>Record points for each goal</i></p>
            <input type="button" onclick="update(0, false);" id="ThreePointPlus" value="+3" class="input_forms" />
            <input type="button" onclick="update(0, true);" id="ThreePointMinus" value="&mdash;" class="input_forms" /> 
            <span id="teleopThreePoint" class="autonomousIndividual">0</span>
            <br><br>
            <input type="button" onclick="update(1, false);" id="TwoPointPlus" value="+2" class="input_forms" />
            <input type="button" onclick="update(1, true);" id="TwoPointMinus" value="&mdash;" class="input_forms" /> 
            <span id="teleopTwoPoint" class="autonomousIndividual">0</span>

            <br><br>
            <input type="button" onclick="update(2, false);" id="OnePointPlus" value="+1" class="input_forms" />
            <input type="button" onclick="update(2, true);" id="OnePointMinus" value="&mdash;" class="input_forms" /> 
            <span id="teleopOnePoint" class="autonomousIndividual">0</span>

            <br><br>
            <input type="button" onclick="update(3, false);" id="MissedPointPlus" value="Missed" class="input_forms" />
            <input type="button" onclick="update(3, true);" id="MissedPointMinus" value="&mdash;" class="input_forms" />
            <span id="teleopMissedPoints" class="autonomousIndividual">0</span>

            <br><br>
            <input type="button" onclick="update(4, false);" id="GoalsBlockedPlus" value="Blocked" class="input_forms" />
            <input type="button" onclick="update(4, true);" id="GoalsBlockedMinus" value="&mdash;" class="input_forms" />
            <span id="teleopBlockedPoints" class="autonomousIndividual">0</span>

            <p style="font-weight: bold">Total Points: <span id="totalPoints">0</span></p>

            <p style="margin-bottom: 2px"><i>Shooting range:</i><span id="shootingRangeFeedback"> Less than half court</span></p>
            <div id="ShootingRange" style="margin-left: auto; margin-right: auto; margin-top: 5px"></div>

            <p style="margin-bottom: 2px"><i>Robot speed:</i><span id="robotSpeedFeedback"> 0</span></p>
            <div id="RobotSpeed" style="margin-left: auto; margin-right: auto; margin-top: 5px"></div>

            <p style="margin-bottom: 2px"><i>Robot maneuverability:</i><span id="RobotManeuverabilityFeedback"> 0</span></p>
            <div id="RobotManeuverability" style="margin-left: auto; margin-right: auto; margin-top: 5px"></div>
            <br />
            <input type="button" class="centered" id="NextPageButton" value="Continue to Climbing &rarr;">
            <br /><br />
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                window.scrollTo(0, 1);
                $("#PickupDisks").jqxCheckBox({width: 200, height: 20, theme: 'theme'});
                $("#ShootingRange").jqxSlider({min: 0, max: 2, ticksFrequency: 1,  value: 0, step: 1, theme: 'theme', mode: 'fixed', width: '200'});
                $("#RobotSpeed").jqxSlider({min: 0, max: 9, ticksFrequency: 1,  value: 0, step: 1, theme: 'theme', mode: 'fixed', width: '200'});
                $("#RobotManeuverability").jqxSlider({min: 0, max: 9, ticksFrequency: 1,  value: 0, step: 1, theme: 'theme', mode: 'fixed', width: '200'});
                $("#ThreePointPlus").jqxRepeatButton({delay: 100, width: '100', height: '50', theme: 'custom'});
                $("#ThreePointMinus").jqxRepeatButton({delay: 100, width: '50', height: '50', theme: 'custom'});
                $("#TwoPointPlus").jqxRepeatButton({delay: 100, width: '100', height: '50', theme: 'custom'});
                $("#TwoPointMinus").jqxRepeatButton({delay: 100, width: '50', height: '50', theme: 'custom'});
                $("#OnePointPlus").jqxRepeatButton({delay: 100, width: '100', height: '50', theme: 'custom'});
                $("#OnePointMinus").jqxRepeatButton({delay: 100, width: '50', height: '50', theme: 'custom'});
                $("#MissedPointPlus").jqxRepeatButton({delay: 100, width: '100', height: '50', theme: 'custom'});
                $("#MissedPointMinus").jqxRepeatButton({delay: 100, width: '50', height: '50', theme: 'custom'});
                $("#GoalsBlockedPlus").jqxRepeatButton({delay: 100, width: '100', height: '50', theme: 'custom'});
                $("#GoalsBlockedMinus").jqxRepeatButton({delay: 100, width: '50', height: '50', theme: 'custom'});
                $("#NextPageButton").jqxButton({width: '252px', height: '50px', theme: 'custom'});
                $("#usedKinect").jqxCheckBox({width: 100, height: 30, theme: 'theme'});
                
                $("#NextPageButton").on("click", function() {
                window.location = "climbing.php";
                });       
                
                var options = ["Less than half court", "Half court", "Full court"];
                $('#ShootingRange').on('change', function (event) {
                    document.getElementById('shootingRangeFeedback').innerHTML = " " + options[$('#ShootingRange').jqxSlider('value').toString(16)];
                });
                
                $('#RobotSpeed').on('change', function (event) {
                    document.getElementById('robotSpeedFeedback').innerHTML = " " + $('#RobotSpeed').jqxSlider('value').toString(16);
                });
                
                $('#RobotManeuverability').on('change', function (event) {
                    document.getElementById('RobotManeuverabilityFeedback').innerHTML = " " + $('#RobotManeuverability').jqxSlider('value').toString(16);
                });
            });
            
            var teleopPoints = [0, 0, 0, 0, 0];
            function update(index, negative) {
                if (teleopPoints[index] > 0) {
                    teleopPoints[index] += 1 * negative ? (-1) : (1);
                } else if (!negative) {
                    teleopPoints[index]++;
                }
                updateIndividualTotals();
                updateTotals();
            }

            function updateIndividualTotals() {
                document.getElementById('teleopThreePoint').innerHTML = teleopPoints[0];
                document.getElementById('teleopTwoPoint').innerHTML = teleopPoints[1];
                document.getElementById('teleopOnePoint').innerHTML = teleopPoints[2];
                document.getElementById('teleopMissedPoints').innerHTML = teleopPoints[3];
                document.getElementById('teleopBlockedPoints').innerHTML = teleopPoints[4];
            }

            function updateTotals() {
                document.getElementById('totalPoints').innerHTML = (teleopPoints[0] * 3) + (teleopPoints[1] * 2) + (teleopPoints[2] * 1);
            }
            
        </script>
         <form id="sendForm" action="../processdata.php" class="invisible_form" method="post"></div>
   </body>
</html>