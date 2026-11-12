<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
session_start();
// Log errors instead of hiding them
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

date_default_timezone_set('Asia/Kolkata');

function upload_fail(string $msg) {
    echo json_encode(["op" => null, "error" => $msg]);
    exit;
}

$final_dest = 'temp';
if (is_dir($final_dest) == FALSE) {
    mkdir($final_dest, 0755, TRUE);
}

if (empty($_FILES['photo']) || ($_FILES['photo']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    upload_fail('No file uploaded');
}

$sm_file_tmp = $_FILES['photo']['tmp_name'];
if (!is_uploaded_file($sm_file_tmp)) {
    upload_fail('Invalid upload');
}

// 5 MB cap
if (($_FILES['photo']['size'] ?? 0) > 5 * 1024 * 1024) {
    upload_fail('File too large (max 5 MB)');
}

// MIME + extension whitelist (images only)
$allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$allowed_mime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$orig = (string)($_FILES['photo']['name'] ?? '');
$ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = $finfo ? finfo_file($finfo, $sm_file_tmp) : '';
if ($finfo) finfo_close($finfo);
if (!in_array($ext, $allowed_ext, true) || !in_array($mime, $allowed_mime, true)) {
    upload_fail('Only JPG/PNG/GIF/WebP images allowed');
}

// Randomized safe filename (no user input in path)
$filename = date('ymdHis') . '_' . bin2hex(random_bytes(8)) . '.' . $ext;

if (move_uploaded_file($sm_file_tmp, $final_dest . '/' . $filename)) {
    $_SESSION['sm_img'] = $filename;
    echo json_encode(["op" => $filename]);
} else {
    upload_fail('Upload failed');
}
