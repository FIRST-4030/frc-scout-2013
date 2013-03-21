<!DOCTYPE html>
<html>
    <head>
        <?php
        $error = $_GET['error'];
        $errorMessage = "";
        switch ($error) {
            case 400:
                $errorMessage = "Error 400: Bad Request.";
                break;
            case 401:
                $errorMessage = "Error 401: Authorization required.";
                break;
            case 403:
                $errorMessage = "Error 403: Forbidden.";
                break;
            case 404:
                $errorMessage = "Error 404: Page not found.";
                break;
            case 500:
                $errorMessage = "Error 500: Internal server error.";
                break;
            case 42:
                $errorMessage = "Congratulations. You have won the game of Life.";
                break;
            case "":
                $errorMessage = "Somehow you've reached the error page in error. Now how did that happen?";
                break;
                
        }
        if (isset($_POST['error_submit'])) {
            $userMessage = stripslashes($_POST['error_submit']);
            if ($userMessage != "") {
                mail("terabyte128@gmail.com", "Error $error was encountered on FIRST Scout", "A user encountered error $error and left this message:\r\n\r\ns$userMessage", "From: scout@ingrahamrobotics.org");
                $errorMessage = "Error reported successfully, thanks!";
            } else {
                $errorMessage = "You didn't enter any information!";
            }
        }
        if ($errorMessage === "") {
            $errorMessage = "Error $error: Unknown error, what did you do?";
        }
        ?>
        <title><? echo $errorMessage ?></title>
        <?php include 'includes/form-headers.html'; ?>
    </head>
    <body>
        <div class='container'>
            <a href="/options"><img src="/images/ram-logo.png" alt="FIRST Scout"></a>
            <div class="alert alert-warning" id="inputError">
                <strong id='alertError'><?php echo $errorMessage ?></strong>
            </div>
            <p class="title">Aw, snap! You've encountered an error!</p>
            <p class='small_title'><strong>What to do now?</strong></p>
            <button class='btn btn-large btn-info homepage_buttons' onclick='window.location = "/options"'>Return home</button>
            <br />
            <button class='btn btn-large btn-success homepage_buttons' onclick='history.go(-1)'>Go back</button>
            <br />
            <button class='btn btn-large btn-danger homepage_buttons' id="sendAnError" onclick='showError()'>Report this error</button>
            <form action="/errordoc.php?error=<? echo $error ?>" id="errorForm" method="post">
                <textarea name="error_submit" placeholder="Enter any information." style="width: 190px; height: 100px"></textarea>
                <br />
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
        <script type="text/javascript">
                $(document).ready(function() {
                    $("#errorForm").hide();
                });

                function showError() {
                    var errorForm = $("#errorForm");
                    if (errorForm.is(":visible")) {
                        errorForm.hide();
                    } else {
                        errorForm.show();
                    }
                }
        </script>
    </body>
</html>
