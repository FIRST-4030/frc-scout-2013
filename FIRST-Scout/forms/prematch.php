<!DOCTYPE html>
<html>    
    <head>
        <title>Pre-match Information</title>
        <? include 'includes/form-headers.html'; ?>
    </head>
    <body>
        <div class="container">
            <p class="title" id ="title" style="margin-bottom: 10px;">Pre-match Information</p>
            <div class="alert alert-warning" id="inputError">
                <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                <strong id='alertError'></strong>
            </div>
            <button id="robotPresent" onclick="updateCheckbox(0)" class="btn btn-success active" data-toggle="button" style="width: 225px">Present</button>
            <br />
            <input id="location" onblur="if (this.value === '')
                            this.value = 'Location';" onfocus="if (this.value === 'Location')
                            this.value = '';" name="location" type="text" style="margin-bottom: 2px; margin-top: 5px; width: 215px" value="Seattle" /><br />
            Team  &nbsp;|&nbsp;  Match <br /><input id="teamNumber" onblur="if (this.value === '')
                            this.value = 'Team Number';" onfocus="if (this.value === 'Team Number')
                            this.value = '';"  type="number" style="width: 100px"/>
            <input id="matchNumber" onblur="if (this.value === '')
                            this.value = 'Match Number';" onfocus="if (this.value === 'Match Number')
                            this.value = '';"  type="number" style="width: 100px"/>  
            <br />
            <div class="btn-group" data-toggle="buttons-radio" style="margin-top: 10px; margin-bottom: 10px">
                <button id="redAlliance" onclick="updateAlliance(true)" class="btn btn-danger active">Red Alliance</button>
                <button id="blueAlliance" onclick="updateAlliance(false)" class="btn btn-primary">Blue Alliance</button>
            </div>
            <br />
            <button class="btn" style="margin-top: 10px" onclick="sendData()">Continue to Autonomous &rarr;</button>
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
                        errors = "Please correct the following errors:";
                        if ($("#location").val() === "") {
                            errors += "<br />&bull; Enter a location.";
                        }
                        if ($("#teamNumber").val() === "") {
                            errors += "<br />&bull; Enter a team number.";
                        }
                        if ($("#matchNumber").val() === "") {
                            errors += "<br />&bull; Enter a match number.";
                        } else {
                            return true;
                        }
                        return false;
                    }

                    function sendData() {
                        if (checkInputs()) {
                            var invisibleForm = document.getElementById('sendForm');
                            invisibleForm.innerHTML += "<input type='text' name='next_page' value='" + "forms/autonomous.php" + "'</input>";
                            invisibleForm.innerHTML += "<input type='text' name='prematch_team_present' value='" + present + "'></input>";
                            invisibleForm.innerHTML += "<input type='text' name='prematch_location' value='" + $("#location").val() + "'></input>";
                            invisibleForm.innerHTML += "<input type='number' name='prematch_team_number' value='" + $("#teamNumber").val() + "'></input>";
                            invisibleForm.innerHTML += "<input type='number' name='prematch_match_number' value='" + $("#matchNumber").val() + "'></input>";
                            invisibleForm.innerHTML += "<input type='text' name='prematch_red_alliance' value='" + redAlliance + "'></input>";
                            invisibleForm.submit();
                        } else {
                            document.getElementById('alertError').innerHTML = errors;
                            $("#inputError").show();
                        }
                    }

        </script>
        <form id="sendForm" action="entry.php" class="invisible_form" method="post"></form>
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

