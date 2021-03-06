<!DOCTYPE html>
<html>    
    <head>
        <title>Match Results</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>

        <!-- These work! -->
        <link href="../bootstrap2/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>        
        <script type="text/javascript" src="../bootstrap2/js/bootstrap.min.js"></script>
        <? include 'includes/borders.php'; ?>

    </head>
    <body>
        <div class="container">
            <p class="title" id ="title" style="margin-bottom: 10px;">Match Results: <b><?php echo $scoutedTeamNumber ?></b></p>
            <button id="deadRobot" onclick="updateDead();" class="btn btn-warning" data-toggle="button" style="margin-top: 0px; margin-bottom: 5px">Dead Robot</button><br />
            <div class="btn-group" data-toggle="buttons-radio" style="margin-bottom: 10px">
                <button class="btn btn-danger active" onclick="update(0);">Lose</button>
                <button class="btn btn-success" onclick="update(1);">Win</button>
                <button class="btn btn-warning" onclick="update(2);">Tie</button>
            </div>
            <br />
            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="updateFouls(false);">Fouls</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="updateFouls(true);">&mdash;</button>
            <span id="foulsIndicator" class="autonomousIndividual">0</span>

            <br />
            <button class="btn plus_minus_buttons" style="height: 50px; width: 100px" onclick="updateTechnicalFouls(false);">Technical Fouls</button>
            <button class="btn plus_minus_buttons" style="height: 50px; width: 50px" onclick="updateTechnicalFouls(true);">&mdash;</button>
            <span id="technicalFoulsIndicator" class="autonomousIndividual">0</span>

            <p class="small_title">Comments:</p>
            <textarea id="comments" rows="5"></textarea>
            <br />
            <button class="btn btn-large" style="margin-bottom: 10px" onclick="sendData();
                    ;">Finish &rarr;</button>
            <br />

        </div>
        <script type="text/javascript">
                $(document).ready(function() {
                    window.scrollTo(0, 1);
                });
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
                    var invisibleForm = document.getElementById('sendForm');
                    invisibleForm.innerHTML += "<input type='text' name='next_page' value='" + "options" + "'</input>";
                    invisibleForm.innerHTML += "<input type='number' name='results_match_outcome' value='" + loseWinTie + "'</input>";
                    invisibleForm.innerHTML += "<input type='number' name='results_fouls' value='" + fouls + "'</input>";
                    invisibleForm.innerHTML += "<input type='number' name='results_technical_fouls' value='" + technicalFouls + "'</input>";
                    invisibleForm.innerHTML += "<input type='text' name='results_dead_robot' value='" + deadRobot + "'></input>";
                    invisibleForm.innerHTML += "<textarea name='results_comments'>" + $("#comments").val() + "</textarea>";
                    invisibleForm.submit();
                }
        </script>
        <form id="sendForm" action="entry.php" class="invisible_form" method="post"></form>
    </body>
</html>
