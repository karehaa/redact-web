<?php
session_start();

$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;
$operation = isset($_POST['operation']) ? $_POST['operation'] : null;
$output_type = isset($_POST['output_type']) ? $_POST['output_type'] : null;
$chosenFile = isset($_FILES['file']) ? $_FILES['file'] : null;
$file_name = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : null;
$file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
$allowed_extension = ['html', 'txt'];
$is_valid_extension = in_array($file_extension, $allowed_extension);

if ($is_valid_extension == false) {
    $_SESSION['error_message'] = "Invalid Extension!";
    session_write_close();
    header("Location: error-page.php");
    exit;
}