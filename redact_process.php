<?php
//mulai session buat nanti store error/sucess message & download link
session_start();

//initial variable yang bakal dipakai
$keyword = $_POST['keyword'] ?? null;
$operation = $_POST['operation'] ?? null;
$output_type = $_POST['output_type'] ?? null;
$chosenFile = $_FILES['file'] ?? null;

//kalo misalnya file nya kosong/error
if (!$chosenFile || $chosenFile['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['error_message'] = "Failed to Upload File! Try again.";
    session_write_close();
    header('Location: error-page.php');
    exit;
}

//deklarasi variable yang bakal dipake juga
$file_name = $chosenFile['name'] ?? null;
$file_path_in_tmp = $chosenFile['tmp_name'] ?? null;
$file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
$allowed_extension = ['html', 'txt'];

//kalo misalnya file extension nya ga sesuai bakal error (cuma boleh .html & .txt)
if (!in_array($file_extension, $allowed_extension)) {
    $_SESSION['error_message'] = "Invalid Extension!";
    session_write_close();
    header('Location: error-page.php');
    exit;
}

//buat directory untuk store file baru nya
$upload_dir = __DIR__ . '/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

//buat unique filename buat file baru nya
$unique_filename = pathinfo($file_name, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $file_extension;
$moved_file_path = $upload_dir . $unique_filename;

//kalo gagal mindahin file nya ke directory baru bakal throw error
if (!move_uploaded_file($file_path_in_tmp, $moved_file_path)) {
    $_SESSION['error_message'] = "Failed to move uploaded file.";
    session_write_close();
    header('Location: error-page.php');
    exit;
}

//inisialisasi connection ke file yang dikirim user (permission nya cuman read jadi 'r')
$file_connection = fopen($moved_file_path, 'r');

//kalo gagal bikin koneksi throw error
if (!$file_connection) {
    $_SESSION['error_message'] = "File uploaded but failed to open.";
    session_write_close();
    header('Location: error-page.php');
    exit;
}

//inisialisasi variable yang bakal diisi konten dari search/redact
$content = '';

//selama belum sampe ke line terakhir tetap jalan (feof (file-end-of-file))
while (!feof($file_connection)) {
    //ngambil tiap baris dari file nya
    $line = fgets($file_connection);

    //kalo kosong/false langsung berhenti
    if ($line === false) {
        break;
    }

    //kalo search cari keyword di baris nya, kalo ada maka append ke variable konten nya
    if ($operation === 'search') {
        if (strpos($line, $keyword) !== false) {
            $content .= $line;
        }
    }

    //kalo operasi nya redact maka cari keyword di baris nya dan ganti jadi *****
    elseif ($operation === 'redact') {
        $content .= str_replace($keyword, '*****', $line);
    }
}

//tutup koneksi
fclose($file_connection);

// kalo output type nya overwrite maka output_file_path nya adalah path file yang tadi dipindahin
if ($output_type === 'overwrite') {
    $output_file_path = $moved_file_path;
}

// kalo output type nya new maka cek lagi ini operasi nya tadi search atau redact
elseif ($output_type === 'new') {

    //kalo redact maka bikin directory file nya gini
    if ($operation === 'search') {
        $output_file_path = $upload_dir . "search_result_" . pathinfo($unique_filename, PATHINFO_FILENAME) . '.' . $file_extension;
    }

    //kalo redact gini
    elseif ($operation === 'redact') {
        $output_file_path = $upload_dir . pathinfo($unique_filename, PATHINFO_FILENAME) . '-new.' . $file_extension;
    }

    //tapi kalo ternyata ada yang problem, throw error
    else {
        $_SESSION['error_message'] = "Invalid operation.";
        session_write_close();
        header('Location: error-page.php');
        exit;
    }
}

//ini nge-throw error kalo output nya aneh
else {
    $_SESSION['error_message'] = "Invalid output type.";
    session_write_close();
    header('Location: error-page.php');
    exit;
}

//kalo gagal masukin konten ke file baru nya, throw error
if (file_put_contents($output_file_path, $content) === false) {
    $_SESSION['error_message'] = "Failed to save output file.";
    session_write_close();
    header('Location: error-page.php');
    exit;
}

//save success message & download link
$_SESSION['success_message'] = "File successfully processed!";
$_SESSION['download_link'] = str_replace(__DIR__ . '/', '', $output_file_path);
session_write_close();
header('Location: success-page.php');
exit;
