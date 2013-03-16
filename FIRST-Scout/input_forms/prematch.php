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
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxcore.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxbuttons.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxinput.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxnumberinput.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxradiobutton.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxscrollbar.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxlistbox.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxdropdownlist.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxcheckbox.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxslider.js"></script>

        <link href='../css/custom.css' rel="stylesheet" type="text/css">
    </head>

    <body>

        <div class="container">
            <p class="title" id ="title" style="margin-bottom: 1px">Pre-match Information</p>
            <div id="inputContainer">
                <div id="present" style="margin-left: auto; margin-right: auto; display: inline-block">Present</div>
                <div id="deadRobot" style="margin-left: auto; margin-right: auto; display: inline-block">Dead Robot</div><br />
                <input name="location" style="margin-bottom: 2px" id="Location" /><br />
                <input id="teamNumber" type="number" />
                <input id="matchNumber" type="number" />  
                <div style="margin-top: 10px" id="allianceChecker"><font color="red">Red Alliance</font></div>
                <div style="margin-left: auto; margin-right: auto" id="allianceSlider"></div>
                <input type="button" style="margin-top: 10px" onclick="sendData()" class="centered" id="NextPageButton" value="Continue to Autonomous &rarr;">
                <br /><br />
            </div>
        </div>

        <script type="text/javascript">
            
            
            $(document).ready(function() {
                window.scrollTo(0, 1);
                $("#Location").jqxInput({width: '205', height: '30', theme: 'custom', placeHolder: ' Location'});
                $("#teamNumber").jqxInput({width: '100', height: '30', theme: 'custom', placeHolder: ' Team Number'});
                $("#matchNumber").jqxInput({width: '100', height: '30', theme: 'custom', placeHolder: ' Match Number'});
                $("#allianceSlider").jqxSlider({min: 0, max: 1, ticksFrequency: 1, value: 0, step: 1, theme: 'theme', mode: 'fixed', width: '100'});
                $("#present").jqxCheckBox({width: 70, height: 25, theme: 'theme', checked: true});
                $("#deadRobot").jqxCheckBox({width: 80, height: 25, theme: 'theme', checked: false});
                $("#NextPageButton").jqxButton({width: '252px', height: '50px', theme: 'custom'});
                var options = ["<font color='red'>Red Alliance</font>", "<font color='blue'>Blue Alliance</font>"];
                $('#allianceSlider').on('change', function(event) {
                    document.getElementById('allianceChecker').innerHTML = options[$('#allianceSlider').jqxSlider('value').toString(16)];
                });

            });
            
            function updateCheckbox(num) {
                
            }
            
            function sendData() {
                $('#inputContainer').children(function() {
                   var val 
                });
                var location = $("#Location").val().toString();
                document.getElementById('test').innerHTML = location;
            }

        </script>
        <form id="sendForm" action="../processdata.php" class="invisible_form" method="post"></div>
</body>
</html>
<!--
keep this just in case we decide to use it
<p style="margin-bottom: 2px;" id="alliance">Alliance Partners:</p>
<input id="alliancePartner1" type="number" />
<input id="alliancePartner2" type="number" />
<p style="margin-bottom: 2px;" id="opposition">Opposing Alliance:</p>
<input id="opposition1" type="number" />
<input id="opposition2" type="number" />
<input id="opposition3" type="number" />-->

