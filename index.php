<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redaction Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="container">
        <div class="card shadow-sm p-4">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Redaction Tool</h2>

                <form action="redact_process.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="keyword" class="form-label">Keyword to Search</label>
                        <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Enter keyword" required>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Choose File</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".html, .txt" required>
                        <div class="form-text">Accepted formats: .html, .txt</div>
                    </div>

                    <div class="mb-3">
                        <label for="operation" class="form-label">Operation</label>
                        <select class="form-select" id="operation" name="operation" required>
                            <option value="search">Search</option>
                            <option value="redact">Redact</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="output_type" class="form-label">Output Type</label>
                        <select class="form-select" id="output_type" name="output_type" required>
                            <option value="overwrite">Overwrite</option>
                            <option value="new">New File</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>