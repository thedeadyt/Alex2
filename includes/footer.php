<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
  <!-- ✅ Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- ✅ Alpine.js -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body style="background-color: var(--color-bg);">

  <!-- ✅ FOOTER -->
<div class="pt-10 pb-6 px-6" x-data="{ open: false }" style="background-color: var(--color-black)">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">
    
    <!-- Navigation -->
    <div>
      <h3 class="text-xl mb-4 text-center" style="color: var(--color-white); font-family: var(--font-base);">Navigation</h3>
      <ul class="space-y-2 text-center">
        <li><a href="<?= BASE_URL ?>/index.php" style="color: var(--color-white); font-family: var(--font-base);" class="hover:underline">Accueil</a></li>
        <li><a href="<?= BASE_URL ?>/pages/NosProjets.php" style="color: var(--color-white); font-family: var(--font-base);" class="hover:underline">Projets réalisés</a></li>
        <li><a href="<?= BASE_URL ?>/pages/Services.php" style="color: var(--color-white); font-family: var(--font-base);" class="hover:underline">Nos services</a></li>
        <li><a href="<?= BASE_URL ?>/pages/Apropos.php" style="color: var(--color-white); font-family: var(--font-base);" class="hover:underline">À propos</a></li>
        <li><a href="#<?= BASE_URL ?>/pages/Contact.php" style="color: var(--color-white); font-family: var(--font-base);" class="hover:underline">Contact</a></li>
      </ul>
    </div>

    <!-- Mentions légales -->
    <div>
      <h3 class="text-xl mb-4 flex items-center justify-between md:block text-center" style="color: var(--color-white); font-family: var(--font-base);">
        Mentions légales
        <button @click="open = !open" class="md:hidden text-gray-400">
          <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
          </svg>
          <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
          </svg>
        </button>
      </h3>
      <ul class="space-y-2 md:block text-center" x-show="open || window.innerWidth >= 768" x-transition>
        <li><a href="/mentions-legales.html" style="color: var(--color-white); font-family: var(--font-base);" class="hover:underline">Mentions légales</a></li>
        <li><a href="/confidentialite.html" style="color: var(--color-white); font-family: var(--font-base);" class="hover:underline">Politique de confidentialité</a></li>
      </ul>
    </div>

    <!-- Réseaux sociaux -->
    <div>
      <h3 class="text-xl mb-4 text-center" style="color: var(--color-white); font-family: var(--font-base);">Suivez-nous</h3>
      <div class="flex flex-col space-y-3 items-center">
        <a href="https://www.linkedin.com/in/alex-alex-597150372" target="_blank" class="flex items-center space-x-2 hover:underline">
          <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24">
            <path d="M4.98 3.5C4.98 4.88 3.87 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1 4.98 2.12 4.98 3.5zM0 24h5V8H0v16zM7.5 8h4.78v2.16h.07c.66-1.26 2.28-2.59 4.7-2.59 5.03 0 5.95 3.3 5.95 7.59V24h-5v-6.67c0-1.59-.03-3.64-2.22-3.64-2.23 0-2.57 1.73-2.57 3.51V24h-5V8z"/>
          </svg>
          <span style="color: var(--color-white); font-family: var(--font-base);">@alex2-dev</span>
        </a>
        <a href="https://www.instagram.com/alex2.dev" target="_blank" class="flex items-center space-x-2 hover:underline">
          <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24">
            <path d="M12 2.2c3.2 0 3.584.012 4.85.07 1.366.062 2.633.348 3.608 1.323.975.975 1.26 2.242 1.323 3.608.058 1.266.07 1.65.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.348 2.633-1.323 3.608-.975.975-2.242 1.26-3.608 1.323-1.266.058-1.65.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.348-3.608-1.323-.975-.975-1.26-2.242-1.323-3.608C2.212 15.584 2.2 15.2 2.2 12s.012-3.584.07-4.85c.062-1.366.348-2.633 1.323-3.608C4.568 2.618 5.835 2.333 7.2 2.27 8.466 2.212 8.85 2.2 12 2.2zm0-2.2C8.7 0 8.3.012 7.05.07 5.667.13 4.3.415 3.125 1.59 1.95 2.765 1.665 4.133 1.605 5.515.547 6.766.535 7.167.535 12s.012 5.233.07 6.485c.062 1.382.347 2.75 1.52 3.925 1.175 1.175 2.542 1.46 3.925 1.52C8.3 23.988 8.7 24 12 24s3.7-.012 4.95-.07c1.383-.062 2.75-.347 3.925-1.52 1.175-1.175 1.46-2.542 1.52-3.925.058-1.252.07-1.652.07-6.485s-.012-5.233-.07-6.485c-.062-1.382-.347-2.75-1.52-3.925C19.7.415 18.333.13 16.95.07 15.7.012 15.3 0 12 0zM12 5.838A6.163 6.163 0 1 0 18.162 12 6.163 6.163 0 0 0 12 5.838zm0 10.2A4.038 4.038 0 1 1 16.038 12 4.038 4.038 0 0 1 12 16.038zM18.406 4.594a1.44 1.44 0 1 0 1.44 1.44 1.44 1.44 0 0 0-1.44-1.44z"/>
          </svg>
          <span style="color: var(--color-white); font-family: var(--font-base);">@alex2-dev</span>
        </a>
        <a href="https://github.com/alex2-dev" target="_blank" class="flex items-center space-x-2 hover:underline">
          <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24">
            <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.385-1.333-1.754-1.333-1.754-1.09-.744.083-.729.083-.729 1.205.084 1.84 1.237 1.84 1.237 1.07 1.835 2.807 1.305 3.492.998.108-.775.418-1.305.762-1.605-2.665-.305-5.467-1.334-5.467-5.933 0-1.31.468-2.38 1.235-3.22-.123-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23a11.49 11.49 0 0 1 3-.405 11.5 11.5 0 0 1 3 .405c2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.24 2.873.118 3.176.77.84 1.233 1.91 1.233 3.22 0 4.61-2.807 5.625-5.48 5.922.43.37.823 1.1.823 2.22 0 1.604-.014 2.896-.014 3.286 0 .322.217.694.825.576C20.565 22.092 24 17.592 24 12.297 24 5.67 18.63.297 12 .297z"/>
          </svg>
          <span style="color: var(--color-white); font-family: var(--font-base);">@alex2-dev</span>
        </a>
      </div>
    </div>
  </div>

  <div class="mt-10 text-center text-sm text-gray-400">
    &copy; 2025 <span class="font-semibold text-white">&lt;Alex²/&gt;</span>. Tous droits réservés.
  </div>
</div>

</body>
</html>
