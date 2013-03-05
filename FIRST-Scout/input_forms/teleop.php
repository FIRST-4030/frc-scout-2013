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
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxdropdownlist.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxcheckbox.js"></script>

        <link href='../css/custom.css' rel="stylesheet" type="text/css">
    </head>

    <body>
        <!--
        TODO:
        - disks scored on high, med, low (same as auto) DONE
        - range capability (less than half, center, full court) DONE
        - shooting aim (1-10) 
        - disk pickup ability (boolean)
        - robot speed (1-10)
        - robot maneuverability (1-10)
        - goals blocked (number)
        -->

        <script type="text/javascript">
            $(document).ready(function() {
                var pointsScored6 = 0;
                var pointsScored4 = 0;
                var pointsScored2 = 0;


                $("#SixPointPlus").jqxRepeatButton({delay: 0, width: '100', height: '50', theme: 'custom'});
                $("#SixPointMinus").jqxRepeatButton({delay: 0, width: '50', height: '50', theme: 'custom'});
                $("#FourPointPlus").jqxRepeatButton({delay: 0, width: '100', height: '50', theme: 'custom'});
                $("#FourPointMinus").jqxRepeatButton({delay: 0, width: '50', height: '50', theme: 'custom'});
                $("#TwoPointPlus").jqxRepeatButton({delay: 0, width: '100', height: '50', theme: 'custom'});
                $("#TwoPointMinus").jqxRepeatButton({delay: 0, width: '50', height: '50', theme: 'custom'});
                $("#NextPageButton").jqxButton({width: '252px', height: '50px', theme: 'custom'});
                $("#usedKinect").jqxCheckBox({width: 100, height: 30, theme: 'theme'});
                var options = ["Less than half court", "Half court", "Full Court"];
                $("#shootingRange").jqxDropDownList({ source: options, width: '205', height: '25', theme: 'theme', selectedIndex: 0 });

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
            });
            
            function updateTotals(ps6, ps4, ps2) {
                document.getElementById('totalPoints').innerHTML = (ps6 * 6) + (ps4 * 4) + (ps2 * 2);
            }
        </script>
        <div class="container">
            <p class="title">Teleop Recording</p>
            <p><i>Record points for each goal</i></p>
            6 Point Goal: <input type="button" id="SixPointPlus" value="Add" class="input_forms" />
            <input type="button" id="SixPointMinus" value="&mdash;" class="input_forms" /> <br><br>
            4 Point Goal: <input type="button" id="FourPointPlus" value="Add" class="input_forms" />
            <input type="button" id="FourPointMinus" value="&mdash;" class="input_forms" /> <br><br>
            2 Point Goal: <input type="button" id="TwoPointPlus" value="Add" class="input_forms" />
            <input type="button" id="TwoPointMinus" value="&mdash;" class="input_forms" /> <br>
            <p style="font-weight: bold">Total Points: <span id="totalPoints"></span></p>
            <p style="margin-bottom: 2px"><i>Shooting range</i></p>
            <div id="shootingRange" style="margin-left: auto; margin-right: auto; margin-top: 5px"></div>
        </div>
    </body>
</html>