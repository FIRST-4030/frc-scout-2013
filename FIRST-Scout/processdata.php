<?php

$postData = $_POST;
if ($_POST['prematch_team_number']) {
    $teamNumber = $_POST['prematch_team_number'];
    setcookie("TeamNumber", $teamNumber);
}

if($_POST['results_fouls']) {
    setcookie("TeamNumber", "", time() - 3600);
}

header('location:' . $_POST['next_page']);
print_r($postData);
?>
