<? session_start(); ?>
<html>
    <head>
        <title>Review Match</title>
        <?php
        include '../includes/form-headers.html';
        require '../includes/constants.php';
        ?>
    </head>
    <body>
        <div class="container">
            <p class="title">Review Match</p>
<button class="btn btn-success" onclick="window.location='/options'">Go home </button><br />
            <?php
            #Grab the match ID to get information and then delete it as to not get confused
            if (isset($_SESSION['MATCH_ID']) || isset($_GET['match'])) {
                if (isset($_SESSION['MATCH_ID'])) {
                    $matchID = $_SESSION['MATCH_ID'];
                    unset($_SESSION['MATCH_ID']);
                } else if (isset($_GET['match'])) {
                    $matchID = $_GET['match'];
                }
                try {
                    $db = new PDO(DSN, DB_USER, DB_PASSWD);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $ex) {
                    die("Unable to connect to DB\n " . $ex->getMessage() . "<br>" . DSN);
                }
                $getMatchInfo = $db->prepare("SELECT * FROM scout_recording WHERE uid=?");
                $getMatchInfo->execute(array($matchID));
                $matchInfo = $getMatchInfo->fetch(PDO::FETCH_ASSOC);
                print_r($matchInfo);
            } else {
                header('location: /options?error=' . urlencode("You must scout a match first!"));
            }
            
            foreach ($matchInfo as $value) {
                echo "<p>" . $value . "</p>";
            }
            ?>
            
           
        </div>
    </body>
</html>
