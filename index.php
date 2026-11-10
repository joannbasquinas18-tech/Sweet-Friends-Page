<?php
session_start();

$uploadDir = __DIR__ . '/uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$images = [];
if ($handle = opendir($uploadDir)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }

        $fullPath = $uploadDir . '/' . $entry;
        if (is_file($fullPath)) {
            $ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
                $images[] = $entry;
            }
        }
    }
    closedir($handle);
}
sort($images);

$loggedIn = !empty($_SESSION['friend_login']);
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Friends Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="background">
        <span class="sparkle s1">✿</span>
        <span class="sparkle s2">❀</span>
        <span class="sparkle s3">♡</span>
        <span class="cloud cloud-one"></span>
        <span class="cloud cloud-two"></span>
    </div>

    <main class="page">
        <section class="hero">
            <div class="hero-card">
                <p class="eyebrow">For Kym and Anj</p>
                <h1>Sweet little space for us</h1>
                <p id="hero-text" class="hero-text"></p>
                <div class="buttons">
                    <a class="btn primary" href="#login">Open the login</a>
                </div>
            </div>

            <div class="illustration" aria-hidden="true">
                <div class="sun"></div>
                <div class="cupcake"></div>
                <div class="heart h1">♡</div>
                <div class="heart h2">♡</div>
            </div>
        </section>

        <section class="login-section" id="login">
            <div class="login-card">
                <?php if (!empty($message)): ?>
                    <div class="message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>

                <?php if (!$loggedIn): ?>
                    <p class="eyebrow">Friends only</p>
                    <h2>Welcome, sweet friends</h2>
                    <form action="login.php" method="post" class="login-form">
                        <input type="text" name="username" placeholder="Friend name" required>
                        <input type="password" name="password" placeholder="Secret word" required>
                        <button type="submit">Enter the cozy room</button>
                    </form>
                <?php else: ?>
                    <div class="welcome-row">
                        <div>
                            <p class="eyebrow">You’re in</p>
                            <h2>Upload a picture</h2>
                            <p>Share your favorite moments with each other.</p>
                        </div>
                        <a class="btn secondary" href="login.php?logout=1">Log out</a>
                    </div>
                    <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form">
                        <input type="file" name="photo" accept="image/*" required>
                        <button type="submit">Add to gallery</button>
                    </form>
                <?php endif; ?>
            </div>
        </section>

        <section class="gallery-shell" id="gallery">
            <div class="gallery-card">
                <div class="gallery-head">
                    <h2>Photo gallery</h2>
                    <span><?= count($images) ?> picture<?= count($images) === 1 ? '' : 's' ?></span>
                </div>

                <?php if (empty($images)): ?>
                    <p class="empty">No pictures yet — Kym and Anj, be the first to add one!</p>
                <?php else: ?>
                    <div class="gallery-grid">
                        <?php foreach ($images as $image): ?>
                            <figure class="gallery-item">
                                <img src="uploads/<?= rawurlencode($image) ?>" alt="Uploaded picture">
                            </figure>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </main>

    <script src="script.js"></script>
</body>
</html>
