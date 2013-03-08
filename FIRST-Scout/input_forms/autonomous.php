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
        <script type="text/javascript">

            $(document).ready(function() {
                window.scrollTo(0, 1);

                var autoPointsScored6 = 0;
                var autoPointsScored4 = 0;
                var autoPointsScored2 = 0;
                var autonomousPoints = new Array();

                $("#SixPointPlus").jqxRepeatButton({delay: 0, width: '100', height: '50', theme: 'custom'});
                $("#SixPointMinus").jqxRepeatButton({delay: 0, width: '50', height: '50', theme: 'custom'});
                $("#FourPointPlus").jqxRepeatButton({delay: 0, width: '100', height: '50', theme: 'custom'});
                $("#FourPointMinus").jqxRepeatButton({delay: 0, width: '50', height: '50', theme: 'custom'});
                $("#TwoPointPlus").jqxRepeatButton({delay: 0, width: '100', height: '50', theme: 'custom'});
                $("#TwoPointMinus").jqxRepeatButton({delay: 0, width: '50', height: '50', theme: 'custom'});
                $("#NextPageButton").jqxButton({width: '252px', height: '50px', theme: 'custom'});
                $("#usedKinect").jqxCheckBox({width: 150, height: 30, theme: 'theme'});

                $("#SixPointPlus").on("click", function() {
                    autoPointsScored6++;
                    updateTotals(autoPointsScored6, autoPointsScored4, autoPointsScored2);
                    updateIndividualTotals();
                });
          
          
                function onClick(buttonID) {
                    
                }
                        
                $("#SixPointMinus").on("click", function() {
                    if (autoPointsScored6 > 0) {
                        autoPointsScored6--;
                        updateTotals(autoPointsScored6, autoPointsScored4, autoPointsScored2);
                        updateIndividualTotals();
                    }
                });

                $("#FourPointPlus").on("click", function() {
                    autoPointsScored4++;
                    updateTotals(autoPointsScored6, autoPointsScored4, autoPointsScored2);
                    updateIndividualTotals();

                });
                $("#FourPointMinus").on("click", function() {
                    if (autoPointsScored4 > 0) {
                        autoPointsScored4--;
                        updateTotals(autoPointsScored6, autoPointsScored4, autoPointsScored2);
                        updateIndividualTotals();

                    }
                });

                $("#TwoPointPlus").on("click", function() {
                    autoPointsScored2++;
                    updateTotals(autoPointsScored6, autoPointsScored4, autoPointsScored2);
                    updateIndividualTotals();
                });
                $("#TwoPointMinus").on("click", function() {
                    if (autoPointsScored2 > 0) {
                        autoPointsScored2--;
                        updateTotals(autoPointsScored6, autoPointsScored4, autoPointsScored2);
                        updateIndividualTotals();
                    }
                });
                $("#NextPageButton").on("click", function() {
                    window.location = "teleop.php";
                });
                function updateIndividualTotals() {
                    document.getElementById('autoSixPoint').innerHTML = autoPointsScored6;
                    document.getElementById('autoFourPoint').innerHTML = autoPointsScored4;
                    document.getElementById('autoTwoPoint').innerHTML = autoPointsScored2;
                }
            });

            function updateTotals(ps6, ps4, ps2) {
                document.getElementById('totalPoints').innerHTML = (ps6 * 6) + (ps4 * 4) + (ps2 * 2);
            }
            
            function update(i, j) {
                document.getElementById('id').innerHTML = i;
            }

        </script>

        <div class="container">
            <p class="title">Autonomous Mode</p>
            <div id="usedKinect" style="margin-left: auto; margin-right: auto; margin-top: 5px; margin-bottom: 5px; font-family: Ubuntu, Arial, sans-serif; font-size: 18px">Used Kinect</div>
            <p><i>Record points for each goal</i></p>
            <input type="button" onclick="update('autoSixPoints', false)" id="SixPointPlus" value="+6" class="input_forms" />
            <input type="button" onclick="update('autoSixPoints', true)" id="SixPointMinus" value="&mdash;" class="input_forms" /> 
            <span id="autoSixPoint" class="autonomousIndividual">0</span>
            <br><br>
            <input type="button" onclick="update('autoFourPoints', false)" id="FourPointPlus" value="+4" class="input_forms" />
            <input type="button" onclick="update('autoFourPoints', true)" id="FourPointMinus" value="&mdash;" class="input_forms" /> 
            <span id="autoFourPoint" class="autonomousIndividual">0</span>

            <br><br>
            <input type="button" onclick="update('autoTwoPoints', false)" id="TwoPointPlus" value="+2" class="input_forms" />
            <input type="button" onclick="update('autoTwoPoints', true)" id="TwoPointMinus" value="&mdash;" class="input_forms" /> 
            <span id="autoTwoPoint" class="autonomousIndividual">0</span>

            <br>
            <p style="font-weight: bold">Total Points: <span id="totalPoints"></span></p>

            <input type="button" class="centered" id="NextPageButton" value="Continue to Teleoperated &rarr;">
            <br>
            <p id="id" />
        </div>
    </body>
</html>