<button id="deadRobot" onclick="updateDead();" class="btn btn-warning" data-toggle="button" style="margin-top: 0px; margin-bottom: 5px">Dead Robot</button><br />
<div class="btn-group" data-toggle="buttons-radio" style="margin-bottom: 10px">
    <button class="btn btn-danger active" onclick="update(0);">Lose</button>
    <button class="btn btn-success" onclick="update(1);">Win</button>
    <button class="btn btn-warning" onclick="update(2);">Tie</button>
</div>
<br />
<button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="updateTechnicalFouls(false);">Technical Fouls</button>
<button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="updateTechnicalFouls(true);">&mdash;</button>
<span id="technicalFoulsIndicator" class="autonomousIndividual">0</span>

<p class="small_title">Comments:</p>
<textarea id="comments" rows="5"></textarea>
<br />
<button class="btn btn-large" id="NextPageButton" style="margin-bottom: 10px" onclick="sendData()">Finish &rarr;</button>
<br />

</div>
<script type="text/javascript">
    function prepare() {
        $("#pageHeader").text("Match Outcome");
    }

    var fouls = 0;
    var loseWinTie = 0;
    function updateFouls(negative) {
        if (fouls > 0) {
            fouls += 1 * negative ? (-1) : (1);
        } else if (!negative) {
            fouls++;
        }
        document.getElementById('foulsIndicator').innerHTML = fouls;
    }

    var technicalFouls = 0;
    function updateTechnicalFouls(negative) {
        if (technicalFouls > 0) {
            technicalFouls += 1 * negative ? (-1) : (1);
        } else if (!negative) {
            technicalFouls++;
        }
        document.getElementById('technicalFoulsIndicator').innerHTML = technicalFouls;
    }

    function update(nVal) {
        loseWinTie = nVal;
    }

    var deadRobot = false;
    function updateDead() {
        deadRobot = !deadRobot;
    }

    function sendData() {
        $("#NextPageButton").button("loading");
        $.ajax({
            url: 'ajax-forms/submit-ajax.php',
            type: "POST",
            data: {'results_match_outcome': loseWinTie,
                'results_technical_fouls': technicalFouls,
                'results_dead_robot': deadRobot,
                'results_comments': $("#comments").val()},
            success: function(response, textStatus, jqXHR) {
                processResponse(response, textStatus);
            }
        });
    }
</script>
