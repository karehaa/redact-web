<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERROR!</title>
</head>

<body>
    <h3>Something went wrong!</h1>
        <p>
            <?php
            session_start();
            echo $_SESSION['error_message'];
            ?>
        </p>
        <form action="clear_uploads.php" method="post">
            <button type="submit">Back to Home</button>
        </form>
</body>

</html>