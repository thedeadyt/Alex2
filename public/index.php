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
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
<section class="py-16 px-6 md:px-20 max-w-5xl mx-auto" id="content">
    
</section>
    <?php
include __DIR__ . '/../includes/footer.php';
?>
<?php if (!isset($_COOKIE['accept_cookie'])): ?>
  <div x-data="{ showBanner: true }" 
       x-show="showBanner" 
       class="fixed bottom-4 left-4 right-4 bg-white border border-gray-300 p-4 rounded-lg shadow-lg max-w-3xl mx-auto z-50">
    <p class="text-sm text-gray-700">
      Ce site utilise des cookies pour améliorer votre expérience. En continuant, vous acceptez notre
      <a href="<?= BASE_URL ?>/pages/Confidentialité.php" class="text-green-600 underline hover:text-green-800">politique de confidentialité</a>.
    </p>
    <div class="mt-2 flex justify-end space-x-2">
      <button @click="showBanner = false" class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded">Refuser</button>
      <button @click="
          showBanner = false;
          document.cookie = 'accept_cookie=1;path=/;max-age=' + 60*60*24*365;
        " 
        class="px-4 py-2 text-sm bg-green-600 text-white hover:bg-green-700 rounded">Accepter</button>
    </div>
  </div>
<?php endif; ?>
</body>
</html>


