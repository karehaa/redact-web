<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redaction Website</title>
</head>
<body>
    <form action="redact_process.php" method="post" enctype="multipart/form-data">
        <p>Input the Keyword you want to search:</p>
        <input type="text" name="keyword"> <br>

        <p>Input the file you want to use:</p>
        <input type="file" name="file" accept=".html, .txt"> <br>

        <p>Input the Operation you want to use:</p>
        <select name="operation">
            <option value="search">Search</option>
            <option value="redact">Redact</option>
        </select> <br>

        <p>Input the Output Type you want it to be:</p>
        <select name="output_type">
            <option value="overwrite">Overwrite</option>
            <option value="new">New File</option>
        </select> <br> <br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>