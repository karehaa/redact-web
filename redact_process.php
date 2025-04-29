<?php
session_start();

$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;
$operation = isset($_POST['operation']) ? $_POST['operation'] : null;
$output_type = isset($_POST['output_type']) ? $_POST['output_type'] : null;
$chosenFile = isset($_FILES['file']) ? $_FILES['file'] : null;

if (!isset($chosenFile) || $chosenFile['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['error_message'] = "Failed to Upload File! Try again.";
    session_write_close();
    header('Location: error-page.php');
    exit;
}

$file_name = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : null;
$file_path_in_tmp = isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : null;
$file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
$allowed_extension = ['html', 'txt'];
$is_valid_extension = in_array($file_extension, $allowed_extension);

if ($is_valid_extension == false) {
    $_SESSION['error_message'] = "Invalid Extension!";
    session_write_close();
    header("Location: error-page.php");
    exit;
}

$upload_dir = __DIR__ . '/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$moved_file_path = $upload_dir . basename($file_name);
if (!move_uploaded_file($file_path_in_tmp, $moved_file_path)) {
    $error_info = error_get_last();
    $_SESSION['error_message'] = "Failed to move uploaded file. Error details: " . print_r($error_info, true);
    session_write_close();
    header('Location: error-page.php');
    exit;
}

$file_connection = fopen($moved_file_path, 'r');
if (!$file_connection) {
    $_SESSION['error_message'] = "File Uploaded but is failed to be open!";
    session_write_close();
    header('Location: error-page.php');
    exit;
}

$content = '';

while (!feof($file_connection)) {
    $line = fgets($file_connection);

    if ($line === false) {
        break;
    }

    if ($operation === "search") {
        if (strpos($line, $keyword) !== false) {
            $content .= $line;
        }
    } elseif ($operation == "redact") {
        $line = str_replace($keyword, "*****", $line);
        $content .= $line;
    }
}
fclose($file_connection);

if ($output_type === 'overwrite') {
    $output_file_path = $moved_file_path;
} elseif ($output_type === 'new') {
    if ($operation === 'search') {
        $output_file_path = $upload_dir . "search_result_" . pathinfo($file_name, PATHINFO_FILENAME) . '.' . $file_extension;
    } elseif ($operation === 'redact') {
        $output_file_path = $upload_dir . pathinfo($file_name, PATHINFO_FILENAME) . '-new.' . $file_extension;
    } else {
        $_SESSION['error_message'] = "Invalid operation.";
        session_write_close();
        header('Location: error-page.php');
        exit;
    }
} else {
    $_SESSION['error_message'] = "Invalid output type.";
    session_write_close();
    header('Location: error-page.php');
    exit;
}


file_put_contents($output_file_path, $content);

$_SESSION['success_message'] = "File successfully processed!";
$_SESSION['download_link'] = str_replace(__DIR__ . '/', '', $output_file_path);
session_write_close();
header('Location: success-page.php');
exit;
