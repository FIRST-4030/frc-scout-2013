<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header('location: ../index.php?error=' . urlencode("Please login first!"));
}
?>
<html>
    <head>
        <?
        require '../includes/constants.php';
        include '../includes/form-headers.html';
        ?>
        <title>Team Results</title>
        <script type="text/javascript" src="../tablesorter/jquery.tablesorter.min.js"></script> 
        <link href="../tablesorter/themes/blue/style.css" rel="text/stylesheet" />
    </head>
    <body>


        <div class="container">
            <table id="resultTable" class="tablesorter table">
                <thead>
                    <tr>
                        <td>Date/Time</td>
                        <td>Scout</td>
                        <td>Team Number</td>
                        <td>Match Number</td>
                        <td>Present</td>
                        <td>Dead Robot</td>
                        <td>Alliance</td>
                        <td>Location</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                <?
//            try {
//                $db = new PDO(DSN, DB_USER, DB_PASSWD);
//                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            } catch (PDOException $ex) {
//                die("Unable to connect to DB\n " . $ex->getMessage() . "<br>" . DSN);
//            }
//            $getMatchInfo = $db->prepare("SELECT * FROM scout_recording");
//            $getMatchInfo->execute();
//            while ($row = $getMatchInfo->fetch(PDO::FETCH_ASSOC)) {
//                foreach ($row as $key->$value) {
//                    echo $key . ": " . $value;
//                }
//                echo '<br>';
//            }

                $db = mysqli_connect("localhost", DB_USER, DB_PASSWD, "stevenz9_robotics_scout");
                if (mysqli_connect_errno()) {
                    die('Failed to connect to database: ' . mysqli_connect_error());
                }

                $result = mysqli_query($db, "SELECT * FROM scout_recording");

                while ($row = mysqli_fetch_array($result)) {
                    print_r($row);
                    echo "<br>";
                }
                ?>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
               $("#resultTable").tablesorter(); 
            });  
        </script>
    </body>
</html>