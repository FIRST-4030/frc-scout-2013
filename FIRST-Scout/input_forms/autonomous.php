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

    </head>
    <body>
        <script type="text/javascript">
            /*
             * TODO: add individual point variables for each score of different
             * points and subtract them dynamically
             */
            $(document).ready(function() {
                var pointsScored6 = 0;
                var pointsScored4 = 0;
                var pointsScored2 = 0;


                $("#SixPointPlus").jqxRepeatButton({delay: 0, width: '100', height: '50', theme: 'theme'});
                $("#SixPointMinus").jqxRepeatButton({delay: 0, width: '50', height: '50', theme: 'theme'});
                $("#FourPointPlus").jqxRepeatButton({delay: 0, width: '100', height: '50', theme: 'theme'});
                $("#FourPointMinus").jqxRepeatButton({delay: 0, width: '50', height: '50', theme: 'theme'});
                $("#TwoPointPlus").jqxRepeatButton({delay: 0, width: '100', height: '50', theme: 'theme'});
                $("#TwoPointMinus").jqxRepeatButton({delay: 0, width: '50', height: '50', theme: 'theme'});
                $("#NextPageButton").jqxButton({width: '252px', height: '50px', theme: 'theme'});
                $("#usedKinect").jqxCheckBox({ width: 120, height: 25, theme: 'theme'});
                
                $("#SixPointPlus").on("click", function() {
                    pointsScored6++;
                    updateTotals(pointsScored6, pointsScored4, pointsScored2);
                });
                $("#SixPointMinus").on("click", function() {
                    if (pointsScored6 >= 0) {
                        pointsScored6--;
                        updateTotals(pointsScored6, pointsScored4, pointsScored2);
                    }
                });

                $("#FourPointPlus").on("click", function() {
                    pointsScored4++;
                    updateTotals(pointsScored6, pointsScored4, pointsScored2);

                });
                $("#FourPointMinus").on("click", function() {
                    if (pointsScored4 >= 0) {
                        pointsScored4--;
                        updateTotals(pointsScored6, pointsScored4, pointsScored2);

                    }
                });

                $("#TwoPointPlus").on("click", function() {
                    pointsScored2++;
                    updateTotals(pointsScored6, pointsScored4, pointsScored2);
                });
                $("#TwoPointMinus").on("click", function() {
                    if (pointsScored2 >= 0) {
                        pointsScored2--;
                        updateTotals(pointsScored6, pointsScored4, pointsScored2);
                    }
                });
                $("#NextPageButton").on("click", function() {
                    window.location = "teleop.php";
                });
            });

            function updateTotals(ps6, ps4, ps2) {
                document.getElementById('totalPoints').innerHTML = (ps6 * 6) + (ps4 * 4) + (ps2 * 2);
            }
        </script>

        <div class="container">
            <p class="title">Autonomous Mode</p>
            <p><i>Record points for each goal</i></p>
            6 Point Goal: <input type="button" id="SixPointPlus" value="Add" class="input_forms" />
            <input type="button" id="SixPointMinus" value="&mdash;" class="input_forms" /> <br><br>
            4 Point Goal: <input type="button" id="FourPointPlus" value="Add" class="input_forms" />
            <input type="button" id="FourPointMinus" value="&mdash;" class="input_forms" /> <br><br>
            2 Point Goal: <input type="button" id="TwoPointPlus" value="Add" class="input_forms" />
            <input type="button" id="TwoPointMinus" value="&mdash;" class="input_forms" /> <br>
            <p style="font-weight: bold">Total Points: <span id="totalPoints"></span></p>
            <div id="usedKinect">Used Kinect</div>
        <input type="button" class="centered" id="NextPageButton" value="Continue to Teleoperated &rarr;">
        <br><br>
    </div>
</body>
</html>