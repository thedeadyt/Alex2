<?php
require_once __DIR__ . '/../config/config.php';
include __DIR__ . '/../includes/header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body style="background-color: var(--color-white);">
    <section id="content">

    </section>
      <?php
  include __DIR__ . '/../includes/footer.php';
  ?>
</body>
</html>