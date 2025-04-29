<?php
session_start();

$upload_dir = __DIR__ . '/uploads/';

// Clear files inside uploads
if (is_dir($upload_dir)) {
    $files = glob($upload_dir . '*'); // get all file names
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file); // delete file
        }
    }
}

session_destroy(); // optional: clear session
header('Location: index.php'); // go back to upload form
exit;
