<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERROR!</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="container text-center">
        <div class="card shadow-sm p-4">
            <div class="card-body">
                <h3 class="card-title text-danger mb-3">Something went wrong!</h3>

                <p class="text-muted">
                    <?php
                    session_start();
                    // kalo error message nya ada di display, kalo ternyata error nya aneh maka throw Unknown error.
                    echo isset($_SESSION['error_message']) ? htmlspecialchars($_SESSION['error_message']) : "Unknown error.";
                    ?>
                </p>

                <form action="clear_uploads.php" method="post" class="d-inline-block mt-3">
                    <button type="submit" class="btn btn-primary">Back to Home</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>