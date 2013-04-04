<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    header("location: index.php?error=" . urlencode("If you would be so kind as to login first."));
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title id="pageTitle">Data Entry</title>
        <? include 'includes/form-headers.html'; ?>
    </head>
    <body>
        <p class="invisible_form" id="location"><? echo $_SESSION['Location']; ?></p>
        <div class="container" id="outsideContainer">
            <div class="title"><span id="pageHeader" style="margin-bottom: 10px;"></span><span id="teamNumberFeedback"></span></div>           
            <div class="alert alert-warning" id="inputError">
                <button type="button" class="close" onclick="$('.alert').hide();">&times;</button>
                <strong id='alertError'><?php if (isset($_GET['error'])) echo stripcslashes($_GET['error']); ?></strong>
            </div>
            <div id="container"></div>
        </div>
        <script type="text/javascript">
                    $(document).ready(function() {
                        $("#inputError").hide();
                        nextPage("prematch.php");
                        window.scrollTo(0, 1);
                    });

                    function nextPage(page) {
                        $("#container").load("ajax-forms/" + page, function() {
                            prepare();
                            $("#NextPageButton").button("reset");
                        });
                    }

                    function processResponse(response, textStatus) {
                        console.log(response);
                        var responseData = JSON.parse(response);
                        console.log("hooray, it worked!");
                        if (responseData.length > 1) {
                            var errorString = "The following errors were encountered:<br />";
                            for (var i = 0; i < responseData.length - 1; i++) {
                                errorString += responseData[i] + "<br />";
                            }
                            $("#alertError").html(errorString);
                            $("#inputError").show();
                            console.log("errors occured: " + responseData);
                        } else {
                            console.log("Next page: " + responseData[0]);
                            if (responseData[0] === "FINISHED") {
                                var lastPage = true;
                                window.location = "../options/single-match-review.php";
                            } else {
                                nextPage(responseData[0]);
                            }
                        }
                    }

                    $(window).bind('beforeunload', function() {
                        if (!lastPage) {
                            return 'You have unsaved data on this page. I would recommend against leaving yet.';
                        }
                    });

        </script>
    </body>
</html>
