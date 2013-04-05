<button id="robotPresent" onclick="updateCheckbox(0);" class="btn btn-success active" data-toggle="button" style="width: 225px">Present</button>
<br /><br />
Scouted Team Number: <br />
<input onkeyup="$('#teamNumberFeedback').text(': ' + $('#teamNumber').val())" id="teamNumber" onblur="if (this.value === '')
            this.value = 'Team Number';" onfocus="if (this.value === 'Team Number')
            this.value = '';"  type="number" style="width: 100px"/><br />
Match Number: <br />
<input id="matchNumber" onblur="if (this.value === '')
            this.value = 'Match Number';" onfocus="if (this.value === 'Match Number')
            this.value = '';"  type="number" style="width: 100px"/>  
<br />
<div class="btn-group" id="alliance" data-toggle="buttons-radio" style="margin-top: 10px; margin-bottom: 10px">
    <button id="redAlliance" onclick="updateAlliance(true);" class="btn btn-danger">Red Alliance</button>
    <button id="blueAlliance" onclick="updateAlliance(false);" class="btn btn-primary">Blue Alliance</button>
</div>
<br />
<button class="btn" style="margin-top: 10px" id="NextPageButton" onclick="sendData();">Continue to Autonomous &rarr;</button>
<br /><br />
</div>

<script type="text/javascript">
    var present = true;
    var deadRobot = false;
    var redAlliance;
    function prepare() {
        $("#inputError").hide();
        $("#pageHeader").text("Pre-Match Information");
    }

    function updateCheckbox(num) {
        num === 0 ? present = !present : deadRobot = !deadRobot;
    }

    function updateAlliance(red) {
        if (red) {
            redAlliance = true;
            $("#outsideContainer").css("border-top", "5px solid #bd362f");
            $("#outsideContainer").css("border-bottom", "5px solid #bd362f");

        } else {
            redAlliance = false;
            $("#outsideContainer").css("border-top", "5px solid #006dcc");
            $("#outsideContainer").css("border-bottom", "5px solid #006dcc");
        }
    }

    var errors = "";
    function checkInputs() {
        var error = false;
        errors = "Please correct the following errors:";
        if ($("#teamNumber").val() === "") {
            errors += "<br />&bull; Enter a team number.";
            error = true;
        }
        if ($("#matchNumber").val() === "") {
            errors += "<br />&bull; Enter a match number.";
            error = true;
        }
        if ((!$("#blueAlliance").hasClass("active")) && (!$("#redAlliance").hasClass("active"))) {
            errors += "<br />&bull; Specify an alliance.";
            error = true;
        }

        return error;
    }

    function updateTeamNumber(team) {
        $("#teamNumberFeedback").html(" :<b>" + team + "</b>");
    }

    function sendData() {
        var valid = !checkInputs();
        if (valid) {
            $("#NextPageButton").button("loading");
            $.ajax({
                url: 'ajax-forms/submit-ajax.php',
                type: "POST",
                data: {'prematch_team_present': present,
                    'prematch_location': $("#location").text(),
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
            console.log(errors);
        }
    }

</script>
<form id="sendForm" action="entry.php" class="invisible_form" method="post"></form>
</body>
</html>
