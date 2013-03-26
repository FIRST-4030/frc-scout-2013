<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <?    
        if(!isset($_SESSION['TeamID'])) {
            header('location: ../index.php?error=' . urlencode("You must login first!"));
        }
        
        include '../includes/form-headers.html'; 
        ?>
        <title>Team Averages</title>
        <script type="text/javascript" src="../tablesorter/jquery.tablesorter.min.js"></script> 
        <link href="../tablesorter/themes/blue/style.css" rel="stylesheet" type="text/css"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div class='container'>
            <p class='title'>Team Averages</p>

            <table class='tablesorter' id='resultsTable'>
                <thead>
                <th>Team Number</th>
                <th>Autonomous Points</th>
                <th>Teleop Points</th>
                <th>Climb Points</th>
                </thead>
                <tbody id='resultsTableBody'>
                    
                </tbody>
            </table>
        </div>
        <script type='text/javascript'>
            $(document).ready(function() {
                $("#resultsTable").tablesorter();
            });
        </script>
    </body>
</html>
