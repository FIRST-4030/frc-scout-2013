<p class="title" id ="title" style="margin-bottom: 10px;">Pre-match Information</p>
<button id="robotPresent" onclick="updateCheckbox(0);" class="btn btn-success active" data-toggle="button" style="width: 225px">Present</button>
<br />
Scouted Team Number: <br />
<input id="teamNumber" onblur="if (this.value === '')
            this.value = 'Team Number';" onfocus="if (this.value === 'Team Number')
            this.value = '';"  type="number" style="width: 100px"/><br />
Match Number: <br />
<input id="matchNumber" onblur="if (this.value === '')
            this.value = 'Match Number';" onfocus="if (this.value === 'Match Number')
            this.value = '';"  type="number" style="width: 100px"/>  
<br />
<div class="btn-group" data-toggle="buttons-radio" style="margin-top: 10px; margin-bottom: 10px">
    <button id="redAlliance" onclick="updateAlliance(true);" class="btn btn-danger active">Red Alliance</button>
    <button id="blueAlliance" onclick="updateAlliance(false);" class="btn btn-primary">Blue Alliance</button>
</div>
<br />
<button class="btn" style="margin-top: 10px" onclick="sendData();">Continue to Autonomous &rarr;</button>
<br /><br />
</div>

<script type="text/javascript">
    var present = true;
    var deadRobot = false;
    var redAlliance = true;

    $(document).ready(function() {
        window.scrollTo(0, 1);
        $("#inputError").hide();
    });

    function updateCheckbox(num) {
        num === 0 ? present = !present : deadRobot = !deadRobot;
    }

    function updateAlliance(red) {
        if (red) {
            if (!redAlliance) {
                redAlliance = !redAlliance;
            }
        } else {
            if (redAlliance) {
                redAlliance = !redAlliance;
            }
        }
    }

    var errors = "";
    function checkInputs() {
        var error = false;
        errors = "Please correct the following errors:";
        if ($("#location").val() === "") {
            errors += "<br />&bull; Enter a location.";
            error = true;
        }
        if ($("#teamNumber").val() === "") {
            errors += "<br />&bull; Enter a team number.";
            error = true;
        }
        if ($("#matchNumber").val() === "") {
            errors += "<br />&bull; Enter a match time.";
            error = true;
        }
        return error;
    }
    
    function sendData() {
        if (!checkInputs) {
            $.ajax({
                url: 'ajax-forms/submit-ajax.php',
                type: "POST",
                data: {'prematch_team_present': present,
                    'prematch_location': $("#location").val(),
                    'prematch_team_number': $("#teamNumber").val(),
                    'prematch_match_number': $("#matchNumber").val(),
                    'prematch_red_alliance': redAlliance
                },
                success: function(response, textStatus, jqXHR) {
                    processResponse(response, textStatus);
                }
            });
        } else {
        $("#inputError").show();
        $("#alertError").html(errors);
        }
    }

</script>
<form id="sendForm" action="entry.php" class="invisible_form" method="post"></form>
</body>
</html>
