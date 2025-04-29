<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redaction Website</title>
</head>
<body>
    <form action="redact_process.php" method="post" enctype="multipart/form-data">
        <input type="text" name="keyword">
        <input type="file" name="file">
        <select name="operation">
            <option value="search">Search</option>
            <option value="redact">Redact</option>
        </select>
        <select name="output_type">
            <option value="overwrite">Overwrite</option>
            <option value="new">New File</option>
        </select>
    </form>
</body>
</html>