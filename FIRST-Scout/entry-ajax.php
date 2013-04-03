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
        <div class="container">
            <div class="alert alert-warning" id="inputError">
                <button type="button" class="close" onclick="$('.alert').hide();">&times;</button>
                <strong id='alertError'><?php if (isset($_GET['error'])) echo stripcslashes($_GET['error']); ?></strong>
            </div>
            <div id="container"></div>
        </div>
        <script type="text/javascript">
                    $(document).ready(function() {
                        $("#container").load("ajax-forms/prematch.php");
                        $("#inputError").hide();
                    });

                    function setTeamColor() {
                        $color;
                    }

                    function nextPage(page) {
                        $("#container").load("ajax-forms/" + page);
                    }

                    function processResponse(response, textStatus) {
                        console.log(response);
                        var responseData = JSON.parse(response);
                        console.log("hooray, it worked!");
                        console.log("response: " + responseData.nextPage);
                        if (responseData.length > 1) {
                            var errorString = "The following errors were encountered:<br />";
                            for (var i = 0; i < responseData.length - 1; i++) {
                                errorString += responseData[i] + "<br />";
                            }
                            $("#alertError").html(errorString);
                            $("#inputError").show();
                            console.log("errors occured: " + responseData);

                        } else {
                            //nextPage(responseData.nextPage);
                        }
                    }
        </script>
    </body>
</html>
