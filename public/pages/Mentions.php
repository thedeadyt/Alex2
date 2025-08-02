<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mentions légales | &lt;alex²/&gt;</title>
  <link rel="icon" href="<?= BASE_URL ?>/Alex2logo.png" type="image/x-icon">
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- React & ReactDOM -->
  <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">
  <?php
  include __DIR__ . '/../../includes/header.php';
  ?>
  <section class="py-16 px-6 md:px-20 max-w-5xl mx-auto" id="content">
    <h1 class="text-4xl font-bold mb-8 text-center">
        <span style="color: var(--color-green);">&lt;alex²/&gt;</span> — Mentions légales
    </h1>

    <div class="space-y-6 text-base leading-relaxed">

      <div x-data="{ open: false }" class="border-l-4 pl-4" :style="{ borderColor: 'var(--color-green)' }">
        <h2 @click="open = !open" class="text-xl font-semibold cursor-pointer" :class="open ? 'text-[var(--color-accent-2)]' : 'hover:text-[var(--color-accent-2)]'">1. Éditeur du site</h2>
        <div x-show="open" x-transition>
          <p class="mt-2">
            Le site <strong style="color: var(--color-green);">&lt;alex²/&gt;</strong> est édité par :
          </p>
          <ul class="list-disc list-inside mt-2">
            <li>Nom de la société : &lt;alex²/&gt;</li>
            <li>Adresse : 123 Rue Exemple, 75000 Paris, France</li>
            <li>Responsable de la publication : Alexis [Nom de famille]</li>
            <li>Email : <a href="mailto:contact.alex2.dev@gmail.com" class="text-[var(--color-green)] underline">contact.alex2.dev@gmail.com</a></li>
            <li>Téléphone : +33 1 23 45 67 89</li>
            <li>SIRET : 123 456 789 00000</li>
          </ul>
        </div>
      </div>

      <div x-data="{ open: false }" class="border-l-4 pl-4" :style="{ borderColor: 'var(--color-green)' }">
        <h2 @click="open = !open" class="text-xl font-semibold cursor-pointer" :class="open ? 'text-[var(--color-accent-2)]' : 'hover:text-[var(--color-accent-2)]'">2. Hébergement</h2>
        <div x-show="open" x-transition>
          <p class="mt-2">
            Le site est hébergé par :
          </p>
          <ul class="list-disc list-inside mt-2">
            <li>Nom de l’hébergeur : OVH</li>
            <li>Adresse : 2 Rue Kellermann, 59100 Roubaix, France</li>
            <li>Téléphone : 1007</li>
          </ul>
        </div>
      </div>

      <div x-data="{ open: false }" class="border-l-4 pl-4" :style="{ borderColor: 'var(--color-green)' }">
        <h2 @click="open = !open" class="text-xl font-semibold cursor-pointer" :class="open ? 'text-[var(--color-accent-2)]' : 'hover:text-[var(--color-accent-2)]'">3. Propriété intellectuelle</h2>
        <div x-show="open" x-transition>
          <p class="mt-2">
            L’ensemble des contenus (textes, images, vidéos, logos, etc.) présents sur ce site sont la propriété exclusive de &lt;alex²/&gt;, sauf mentions contraires. Toute reproduction, distribution ou modification est interdite sans autorisation préalable.
          </p>
        </div>
      </div>

      <div x-data="{ open: false }" class="border-l-4 pl-4" :style="{ borderColor: 'var(--color-green)' }">
        <h2 @click="open = !open" class="text-xl font-semibold cursor-pointer" :class="open ? 'text-[var(--color-accent-2)]' : 'hover:text-[var(--color-accent-2)]'">4. Données personnelles</h2>
        <div x-show="open" x-transition>
          <p class="mt-2">
            Ce site ne collecte pas de données personnelles autres que celles strictement nécessaires au fonctionnement et à la navigation, conformément à notre <a href="<?= BASE_URL ?>/politique-confidentialite" class="text-[var(--color-green)] underline">politique de confidentialité</a>.
          </p>
        </div>
      </div>

      <div x-data="{ open: false }" class="border-l-4 pl-4" :style="{ borderColor: 'var(--color-green)' }">
        <h2 @click="open = !open" class="text-xl font-semibold cursor-pointer" :class="open ? 'text-[var(--color-accent-2)]' : 'hover:text-[var(--color-accent-2)]'">5. Responsabilité</h2>
        <div x-show="open" x-transition>
          <p class="mt-2">
            &lt;alex²/&gt; s’efforce d’assurer l’exactitude et la mise à jour des informations présentes sur ce site, mais ne peut garantir leur exhaustivité. L’utilisateur utilise ces informations sous sa responsabilité exclusive.
          </p>
        </div>
      </div>

      <div x-data="{ open: false }" class="border-l-4 pl-4" :style="{ borderColor: 'var(--color-green)' }">
        <h2 @click="open = !open" class="text-xl font-semibold cursor-pointer" :class="open ? 'text-[var(--color-accent-2)]' : 'hover:text-[var(--color-accent-2)]'">6. Contact</h2>
        <div x-show="open" x-transition>
          <p class="mt-2">
            Pour toute question relative aux présentes mentions légales, vous pouvez nous écrire à : <a href="mailto:contact.alex2.dev@gmail.com" class="text-[var(--color-green)] underline">contact.alex2.dev@gmail.com</a>.
          </p>
        </div>
      </div>

    </div>
  </section>
  <?php
include __DIR__ . '/../../includes/footer.php';
?>
</body>
</html>

