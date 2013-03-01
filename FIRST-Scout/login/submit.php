<?php
    $teamNum = $_POST['team_number']; 
    $userEmail = $_POST['user_email'];
    $userPass = $_POST['user_password'];
    
    $teamNum = intval($teamNum);
    
    if($teamNum == 0) {
        header('location: /index.php?error=' . urlencode("NullPointerException: team number not valid."));
    }
    
    echo 'team number: ' . $teamNum . '<br>';
    echo 'user email: ' . $userEmail . '<br>';
    echo 'user password: ' . $userPass . '<br>';
?>