<?php
session_start();

if (!isset($_SESSION['success_message']) || !isset($_SESSION['download_link'])) {
    $error_info = error_get_last();
    $_SESSION['error_message'] = "Failed to move uploaded file. Error details: " . print_r($error_info, true);
    header('Location: error-page.php');
    exit;
}

$success_message = $_SESSION['success_message'];
$download_link = $_SESSION['download_link'];

session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success!</title>
</head>

<body>
    <h1>Success!</h1>
    <p><?php echo htmlspecialchars($success_message); ?></p>

    <p>
        <a href="<?php echo htmlspecialchars($download_link); ?>" download>
            Click here to download the processed file
        </a>
    </p>

    <form action="clear_uploads.php" method="post">
        <button type="submit">Back to Home</button>
    </form>
</body>

</html>