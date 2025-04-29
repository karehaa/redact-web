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
    <a href="index.php">Back</a>
</body>
</html>