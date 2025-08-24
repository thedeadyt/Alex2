<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>&lt;Alex²/&gt;</title>
  <link rel="icon" href="<?= BASE_URL ?>/Alex2logo.png" type="image/x-icon">
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
  <style>
    body {
      margin: 0;
      height: 100vh;
      background-color: var(--color-white);
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: var(--font-heading);
      color: var(--color-black);
    }

    .container {
      font-size: 3rem;
      font-weight: bold;
    }

    .cursor {
      display: inline-block;
      animation: blink 1s infinite;
    }

    @keyframes blink {
      0%, 50%, 100% { opacity: 1; }
      25%, 75% { opacity: 0; }
    }
  </style>
</head>
<body>
  <div class="container">
    &lt;<span id="text"></span><span class="cursor">|</span>&gt;
  </div>

  <script>
    const textElement = document.getElementById('text');
    const text = "Alex²/";
    let index = 0;

    function typeWriter() {
      if (index < text.length) {
        textElement.textContent += text.charAt(index);
        index++;
        setTimeout(typeWriter, 250);
      } else {
      setTimeout(() => {
        window.location.href = "<?= BASE_URL ?>/";
      }, 1000);
      }
    }

    setTimeout(typeWriter, 500);
  </script>

</body>
</html>
