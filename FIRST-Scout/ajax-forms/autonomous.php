
<p class="title">Autonomous: <b><?php echo $scoutedTeamNumber ?></b></p>

<p><i>Record points for each goal</i></p>
<button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(0, false);">+6</button>
<button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(0, true);">&mdash;</button>
<span id="autoSixPoint" class="autonomousIndividual">0</span>
<br />
<button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(1, false);">+4</button>
<button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(1, true);">&mdash;</button>
<span id="autoFourPoint" class="autonomousIndividual">0</span>
<br />
<button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(2, false);">+2</button>
<button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(2, true);">&mdash;</button>
<span id="autoTwoPoint" class="autonomousIndividual">0</span>
<br />
<button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="update(3, false);">Missed</button>
<button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="update(3, true);">&mdash;</button>
<span id="autoMissedPoints" class="autonomousIndividual">0</span>
<br />
<p style="font-weight: bold; margin-top: 5px">Total Points: <span id="totalPoints">0</span></p>

<button class="btn btn-large" id="NextPageButton" onclick="sendData();">Continue to Teleoperated &rarr;</button>
<br /><br />
</div>
<script type="text/javascript">
    var autonomousPoints = [0, 0, 0, 0];
    var usedKinect = false;

    $(document).ready(function() {
        //get rid of the title bar if it's a mobile device
        window.scrollTo(0, 1);
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

    function sendData() {
        $.ajax({
            url: 'ajax-forms/submit-ajax.php',
            type: "POST",
            data: {'auto_top': autonomousPoints[0], 
                'auto_middle': autonomousPoints[1], 
                'auto_bottom': autonomousPoints[2], 
                'auto_missed': autonomousPoints[3]},
            success: function(response, textStatus, jqXHR) {
                processResponse(response, textStatus);
            }
        });
    }
</script>
