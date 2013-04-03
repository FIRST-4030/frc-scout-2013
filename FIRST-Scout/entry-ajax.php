<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title id="pageTitle">Data Entry</title>
        <? include 'includes/form-headers.html'; ?>
    </head>
    <body>
        <button class="btn" onclick="load()">load</button>
        <div class="container">
            <div id="holder"></div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#holder").load("ajax-forms/prematch.php");

            });

            function load() {
                $("#holder").load("ajax-forms/teleop.php");
            }
        </script>
    </body>
</html>
