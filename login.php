<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === 'power pops' && $password === 'cutecrew') {
    $_SESSION['friend_login'] = true;
    $_SESSION['message'] = 'Welcome, friend! Your gallery is open.';
} else {
    $_SESSION['message'] = 'Oops! Please try the friendly login details again.';
}

header('Location: index.php#gallery');
exit;
