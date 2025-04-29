<?php
session_start();

//kalo success message ato link nya kosong maka throw error dan ke error page
if (!isset($_SESSION['success_message']) || !isset($_SESSION['download_link'])) {
    $_SESSION['error_message'] = "Something went wrong! Missing success data.";
    header('Location: error-page.php');
    exit;
}

$success_message = $_SESSION['success_message'];
$download_link = $_SESSION['download_link'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="container text-center">
        <div class="card shadow-sm p-4">
            <div class="card-body">
                <h1 class="text-success mb-3"><i class="bi bi-check-circle-fill"></i> Success!</h1>
                <p class="fs-5"><?php echo htmlspecialchars($success_message); ?></p>

                <a href="<?php echo htmlspecialchars($download_link); ?>" class="btn btn-outline-primary my-3" download>
                    <i class="bi bi-download"></i> Download Processed File
                </a>

                <form action="clear_uploads.php" method="post">
                    <button type="submit" class="btn btn-secondary">Back to Home</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>

</html>

<?php
session_unset();
session_destroy();
?>