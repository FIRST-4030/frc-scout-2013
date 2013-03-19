<!DOCTYPE html>
<!-- TODO
- title
- attempts (int)
- level reached (slider?)
- style (corner/inside/face) (slider?)
- disks dropped (int)
- next button
-->

<html>
    <head>
        <title>Climb and Disk Drop</title>
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->

        <!-- css -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link href="../jqwidgets/jqwidgets/styles/jqx.base.css" rel="stylesheet" type="text/css" />

        <!--jqwidgets and bootstrap -->
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>        
        <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../jqwidgets/scripts/gettheme.js"></script>
        <script type="text/javascript" src="../jqwidgets/scripts/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxcore.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxbuttons.js"></script>
        <script type="text/javascript" src="../jqwidgets/jqwidgets/jqxinput.js"></script>
    </head>
    <body>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#AttemptsPlus").jqxRepeatButton({delay: 100, width: '150', height: '50', theme: 'custom'});
                $("#AttemptsMinus").jqxRepeatButton({delay: 100, width: '50', height: '50', theme: 'custom'});
                $("#DisksDroppedPlus").jqxRepeatButton({delay: 100, width: '150', height: '50', theme: 'custom'});
                $("#DisksDroppedMinus").jqxRepeatButton({delay: 100, width: '50', height: '50', theme: 'custom'}); 
            });
        </script>
        <div class="container">
            <p class="title">Climb and Disk Drop</p>
            <p class="small_title"><i>Record attempts and disks dropped:</i></p>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(0, false)">Attempts</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(0, true)">&mdash;</button>
            <span id="attempts" class="autonomousIndividual">0</span>
            <br />
            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(1, false)">Disks Dropped</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(1, true)">&mdash;</button>
            <span id="disksDropped" class="autonomousIndividual">0</span>

            <br />
            <p class="small_title">Level Reached</p>
            <div class="btn-group levelReached" data-toggle="buttons-radio">
                <button class="btn active btn-danger">0</button>
                <button class="btn">1</button>
                <button class="btn">2</button>
                <button class="btn">3</button>
            </div>
            <p class="small_title">Climbing Style</p>
            <div class="btn-group climbStyle" data-toggle="buttons-radio">
                <button class="btn active btn-danger">n/a</button>
                <button class="btn">Corner</button>
                <button class="btn">Inside</button>
                <button class="btn">Face</button>
            </div>
            <br /><br />
            <button style="margin-top: 10px" class=" btn btn-large" onclick="sendData()">Continue to final comments &rarr;</button>
            <br/><br />
        </div>
        <script type="text/javascript">
            var climbing = [0, 0];
            function update(index, negative) {
                if (climbing[index] > 0) {
                    climbing[index] += 1 * negative ? (-1) : (1);
                } else if (!negative) {
                    climbing[index]++;
                }
                updateIndividualTotals();
            }
            
            function updateIndividualTotals() {
                document.getElementById('Attempts').innerHTML = climbing[0];
                document.getElementById('DisksDropped').innerHTML = climbing[1];

            }
            
            function sendData() {
                var climbStyle = 0;
                switch($(".climbStyle .active").text()) {
                    case "n/a": climbStyle = 0; break;
                    case "Corner": climbStyle = 1; break;
                    case "Inside": climbStyle = 2; break;
                    case "Face" : climbStyle = 3; break;         
                }
                var invisibleForm = document.getElementById('sendForm');
                invisibleForm.innerHTML += "<input type='number' name='climb_attempts' value='" + climbing[0] + "'</input>";
                invisibleForm.innerHTML += "<input type='number' name='climb_disks_dropped' value='" + climbing[1] + "'</input>";
                invisibleForm.innerHTML += "<input type='number' name='climb_level_reached' value='" + $(".levelReached .active").text() + "'</input>";
                invisibleForm.innerHTML += "<input type='number' name='climb_climb_style' value='" + climbStyle + "'</input>";
                invisibleForm.submit();
            }
        </script>
        <form id="sendForm" action="../processdata.php" class="invisible_form" method="post"></form>
    </body>
</html>

