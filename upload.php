<?php
session_start();

if (empty($_SESSION['friend_login'])) {
    header('Location: index.php');
    exit;
}

$uploadDir = __DIR__ . '/uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['message'] = 'Please choose a valid image to upload.';
    header('Location: index.php#gallery');
    exit;
}

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $_FILES['photo']['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowedTypes, true)) {
    $_SESSION['message'] = 'Only JPG, PNG, GIF, and WebP images are allowed.';
    header('Location: index.php#gallery');
    exit;
}

if ($_FILES['photo']['size'] > 5 * 1024 * 1024) {
    $_SESSION['message'] = 'Please choose an image smaller than 5MB.';
    header('Location: index.php#gallery');
    exit;
}

$extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
if ($extension === '') {
    $extension = 'bin';
}

$finalName = bin2hex(random_bytes(8)) . '.' . $extension;
$targetPath = $uploadDir . '/' . $finalName;

if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
    $_SESSION['message'] = 'Upload failed. Please try again.';
    header('Location: index.php#gallery');
    exit;
}

$_SESSION['message'] = 'Your picture is now in the gallery!';
header('Location: index.php#gallery');
exit;
