<!DOCTYPE html>
<html>    
    <head>
        <title>Match Results</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=350px, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>

        <!-- These work! -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>        
        <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <p class="title" id ="title" style="margin-bottom: 10px;">Match Results</p>
            <div class="btn-group" data-toggle="buttons-radio" style="margin-bottom: 10px">
                <button class="btn btn-danger active" onclick="update(0)">Lose</button>
                <button class="btn btn-success" onclick="update(1)">Win</button>
                <button class="btn btn-warning" onclick="update(2)">Tie</button>
            </div>
            <br />
            <button class="btn" style="height: 50px; width: 100px" onclick="updateFouls(false)">Fouls</button>
            <button class="btn" style="height: 50px; width: 50px" onclick="updateFouls(true)">&mdash;</button>
            <span id="foulsIndicator" class="autonomousIndividual">0</span>

            <p class="small_title">Comments:</p>
            <textarea id="comments" rows="5"></textarea>
            <br />
            <button class="btn btn-large" style="margin-bottom: 10px" onclick="sendData()">Finish &rarr;</button>
            <br />
        </div>
        <script type="text/javascript">
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
                
            function update(nVal) {
                loseWinTie = nVal;
            }

            function sendData() {
                var invisibleForm = document.getElementById('sendForm');
                invisibleForm.innerHTML += "<input type='number' name='results_match_outcome' value='" + loseWinTie + "'</input>";
                invisibleForm.innerHTML += "<input type='number' name='results_fouls' value='" + fouls + "'</input>";
                invisibleForm.innerHTML += "<input type='text' name='results_comments' value='" + $("#comments").val() + "'</input>";
                invisibleForm.submit();
            }
        </script>
        <form id="sendForm" action="../processdata.php" class="invisible_form" method="post"></form>
    </body>
</html>