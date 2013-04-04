<p class="small_title">
    <i>Record pyramid goals:</i>
</p>
<!--
<button class="btn plus_minus_buttons" style="height: 50px; width: 100px"
        onclick="update(0, false);">Attempts</button>
<button class="btn plus_minus_buttons" style="height: 50px; width: 50px"
        onclick="update(0, true);">&mdash;</button>
<span id="attempts" class="autonomousIndividual">0</span>
<br />
-->
<button class="btn plus_minus_buttons" style="height: 50px; width: 100px"
        onclick="update(1, false);">Pyramid Goals</button>
<button class="btn plus_minus_buttons" style="height: 50px; width: 50px"
        onclick="update(1, true);">&mdash;</button>
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
<br />
<br />
<button style="margin-top: 10px" id="NextPageButton" class=" btn btn-large" onclick="sendData();">Continue to final comments &rarr;</button>
<br/>
<br />
</div>
<script type="text/javascript">
    var climbing = [0, 0];

    function prepare() {
        $("#pageHeader").text("Climb and Disk Goals");
    }

    function update(index, negative) {
        if (climbing[index] > 0) {
            climbing[index] += 1 * negative ? (-1) : (1);
        }
        else if (!negative) {
            climbing[index]++;
        }
        updateIndividualTotals();
    }

    function updateIndividualTotals() {
        document.getElementById('disksDropped').innerHTML = climbing[1];

    }

    function sendData() {
        var climbStyle = 0;
        switch ($(".climbStyle .active").text()) {
            case "n/a":
                climbStyle = 0;
                break;
            case "Corner":
                climbStyle = 1;
                break;
            case "Inside":
                climbStyle = 2;
                break;
            case "Face":
                climbStyle = 3;
                break;
        }
        $("#NextPageButton").button("loading");
        $.ajax({
            url: 'ajax-forms/submit-ajax.php',
            type: "POST",
            data: {'climb_pyramid_goals': climbing[1],
                'climb_level_reached': $(".levelReached .active").text(),
                'climb_climb_style': climbStyle},
            success: function(response, textStatus, jqXHR) {
                processResponse(response, textStatus);
            }
        });
    }
</script>
<form id="sendForm" action="entry.php" class="invisible_form"
      method="post"></form>