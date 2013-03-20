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
        }
        if($errorMessage === "") {
            $errorMessage = "Error $error: Unknown error.";
        }
        ?>
        <title>Error <? echo $error ?></title>
        <?php include 'includes/form-headers.html'; ?>
    </head>
    <body>
        <div class='container'>
            <img src="/images/ram-logo.png" alt="FIRST Scout">
            <div class="alert alert-warning" id="inputError">
                <strong id='alertError'><?php echo $errorMessage ?></strong>
            </div>
            <p class="title">Aw, snap! You've encountered an error!</p>
            <p class='small_title'><strong>What to do now?</strong></p>
            <button class='btn btn-large btn-info homepage_buttons' onclick='window.location = "options"'>Return Home</button>
            <br />
            <button class='btn btn-large btn-success homepage_buttons' onclick='window.location = "index.php"'>Login</button>
            <br />
        </div>
    </body>
</html>
