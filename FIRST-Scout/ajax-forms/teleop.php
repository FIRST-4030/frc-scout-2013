<button id="frisbeePickup" onclick="updateCanPickupFrisbees();" class="btn btn-success" data-toggle="button" style="margin-top: 3px; margin-bottom: 8px;">Can pick up Frisbees?</button>
<button id="canBlock" onclick="updateCanBlock();" class="btn btn-success" data-toggle="button" style="margin-top: 3px; margin-bottom: 8px;">Can block?</button>
<p><i>Record points for each goal</i></p>

<button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(0, false);">+3</button>
<button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(0, true);">&mdash;</button>
<span id="teleopThreePoint" class="autonomousIndividual">0</span>
<br />
<button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(1, false);">+2</button>
<button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(1, true);">&mdash;</button>
<span id="teleopTwoPoint" class="autonomousIndividual">0</span>
<br />
<button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(2, false);">+1</button>
<button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(2, true);">&mdash;</button>
<span id="teleopOnePoint" class="autonomousIndividual">0</span>
<br />
<button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(3, false);">Missed</button>
<button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(3, true);">&mdash;</button>
<span id="teleopMissedPoints" class="autonomousIndividual">0</span>
<br />
<button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(4, false);">Pyramid Goal</button>
<button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(4, true);">&mdash;</button>
<span id="teleopPyramidPoints" class="autonomousIndividual">0</span>
<br />
<p style="font-weight: bold; margin-top: 5px">Total Points: <span id="totalPoints">0</span></p>

<p style="margin-bottom:2px;"><i>Shooting range:</i></p>
<div class="btn-group" data-toggle="buttons-radio">
    <button class="btn btn-danger active" onclick="updateRange(0);">Under half court</button>
    <button class="btn btn-warning" onclick="updateRange(1);">Half court</button>
    <button class="btn btn-success" onclick="updateRange(2);">Full court</button>
</div>


<p style="margin-bottom: 2px; margin-top: 10px;" class="small_title"><i>Robot speed</i></p>
<p style="margin-bottom: 1px">Slow &mdash; Average &mdash; Fast</p>
<div class="btn-group robotSpeed" data-toggle="buttons-radio">
    <button class="btn btn-small active">1</button>
    <button class="btn btn-small">2</button>
    <button class="btn btn-small">3</button>
    <span>Fast</span>
</div>

<br /><br />
<button class="btn btn-large" id="NextPageButton" onclick="sendData();">Continue to Climbing &rarr;</button>
<br /><br />
<script type="text/javascript">
    
    function prepare() {
        $("#pageHeader").text("Teleoperated");
    }


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

    var range = 0;
    function updateRange(newRange) {
        range = newRange;
    }

    var canPickupFrisbees = false;

    function updateCanPickupFrisbees() {
        canPickupFrisbees = !canPickupFrisbees;
    }

    var canBlock = false;
    function updateCanBlock() {
        canBlock = !canBlock;
    }

    function updateIndividualTotals() {
        document.getElementById('teleopThreePoint').innerHTML = teleopPoints[0];
        document.getElementById('teleopTwoPoint').innerHTML = teleopPoints[1];
        document.getElementById('teleopOnePoint').innerHTML = teleopPoints[2];
        document.getElementById('teleopMissedPoints').innerHTML = teleopPoints[3];
        document.getElementById('teleopPyramidPoints').innerHTML = teleopPoints[4];
    }

    function updateTotals() {
        document.getElementById('totalPoints').innerHTML = (teleopPoints[0] * 3) + (teleopPoints[1] * 2) + (teleopPoints[2] * 1) + (teleopPoints[4] * 5);
    }

    function sendData() {
        $("#NextPageButton").button("loading");
        $.ajax({
            url: 'ajax-forms/submit-ajax.php',
            type: "POST",
            data: {'teleop_can_pickup_frisbees': canPickupFrisbees,
                'teleop_top_goals': teleopPoints[0],
                'teleop_middle_goals': teleopPoints[1],
                'teleop_bottom_goals': teleopPoints[2],
                'teleop_missed_goals': teleopPoints[3],
                'teleop_blocked_goals': canBlock,
                'teleop_pyramid_goals': teleopPoints[4],
                'teleop_shooting_range': range,
                'teleop_robot_speed': $(".robotSpeed .active").text()},
            success: function(response, textStatus, jqXHR) {
                processResponse(response, textStatus);
            }
        });
    }
</script>
