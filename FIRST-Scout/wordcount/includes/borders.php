<?
require 'constants.php';
if (isset($_COOKIE['alliance'])) {
    $alliance = $_COOKIE['alliance'];
    if ($alliance == "RED") {
        $color = COLOR_RED;
    } else if ($alliance == "BLUE") {
        $color = COLOR_BLUE;
    }
    echo "<style type='text/css'>";
    echo ".container { 
            border-top: 8px solid $color; 
            border-bottom: 8px solid $color;
        }";
    echo "</style>";
}
?>