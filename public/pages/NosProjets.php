<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../../includes/header.php';
// ... le reste
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Projets sticky superposés - fix scroll</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
<link rel='stylesheet' type='text/css' media='screen' href='<?= BASE_URL ?>/asset/css/NosProjets.css'>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body>
  <div class="bg-gray-100 p-10 mx-auto" style="max-width: 1200px;" x-data="projetsData()">

    <h1 class="text-4xl font-bold mb-8">Nos Projets</h1>

    <div class="pb-[460px]"><!-- padding bottom important pour scroller -->

      <template x-for="(projet, i) in projets" :key="i">
        <div
          :class="projet.couleur + ' projet sticky-top relative flex flex-col justify-between'"
          :style="{ zIndex: 1000 + i }"
        >
          <!-- En haut à droite: année + type + image -->
          <div class="flex justify-end items-start space-x-4 mb-4">
            <div class="text-right">
              <div class="text-sm font-semibold" x-text="projet.annee"></div>
              <div class="text-xs" x-text="projet.type"></div>
            </div>
            <img :src="projet.image" alt="Image projet" class="w-20 h-20 object-cover rounded" />
          </div>

          <!-- Nom projet / entreprise -->
          <h2 class="text-2xl font-bold mb-2" style="color: var(--color-white); font-family: var(--font-heading);"x-text="projet.nom"></h2>

          <!-- Description -->
          <p class="mb-4" style="color: var(--color-white); font-family: var(--font-base);" x-text="projet.description"></p>

          <!-- Features (avec pictos) -->
          <ul class="flex space-x-6 mb-6"style="color: var(--color-white); font-family: var(--font-base);">
            <template x-for="feature in projet.features" :key="feature.name">
              <li class="flex items-center space-x-2">
                <span x-html="feature.icon" class="w-5 h-5"></span>
                <span x-text="feature.name"></span>
              </li>
            </template>
          </ul>

          <!-- Bouton semi-transparent en bas -->
          <button
            @click="openPopup(i)"
            class="w-full py-2 rounded font-semibold"
            style="background-color: var(--btn-bg); color:var(--color-white); transition: background-color 0.3s;"
            @mouseenter="$el.style.backgroundColor = 'var(--btn-hover-bg)'"
            @mouseleave="$el.style.backgroundColor = 'var(--btn-bg)'"
          >
            Plus d'infos
          </button>
        </div>
      </template>
    </div>

    <!-- Pop-up détails -->
    <div
      x-show="popupOpen"
      x-transition
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1100]"
      style="backdrop-filter: blur(5px);"
    >
      <div class="bg-white rounded-lg w-[700px] p-6 relative shadow-xl">
        <!-- Bouton fermeture -->
        <button
          @click="closePopup()"
          class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl font-bold"
          aria-label="Fermer"
        >
          &times;
        </button>

        <!-- Contenu pop-up -->
        <h3 class="text-3xl mb-2"style="color: var(--color-black); font-family: var(--font-base);" x-text="popupProjet.nom"></h3>
        <p class="mb-4" style="color: var(--color-black); font-family: var(--font-base);" x-text="popupProjet.descriptionDetail"></p>

        <!-- Bouton vers projet -->
        <a
          :href="popupProjet.lien"
          target="_blank"
          rel="noopener noreferrer"
          class="block mt-6 w-full text-center py-3 rounded transition"
          style="
            background-color: var(--color-black);
            color: var(--color-white);
          "
          @mouseenter="$el.style.backgroundColor = 'var(--color-black)'"
          @mouseleave="$el.style.backgroundColor = 'var(--color-black)'"
        >
          Voir le projet
        </a>
      </div>
    </div>


<script>
  function projetsData() {
    return {
      projets: [
        {
          annee: '2023',
          type: 'Dev Web / SEO',
          image: 'https://placehold.co/300x200/png',
          nom: 'Entreprise XYZ',
          description: 'Projet de refonte complète du site web avec optimisation SEO.',
          descriptionDetail: 'Description plus détaillée du projet XYZ, objectifs, challenges, solutions mises en place.',
          features: [
            { name: 'Développement', icon: '💻' },
            { name: 'SEO', icon: '🔍' },
            { name: 'Design', icon: '🎨' }
          ],
          lien: 'https://placehold.co/300x200/png',
          couleur: 'bg-blue-600 text-white'
        },
        {
          annee: '2022',
          type: 'Application Mobile',
          image: 'https://placehold.co/300x200/png',
          nom: 'Startup ABC',
          description: 'Application mobile native iOS et Android.',
          descriptionDetail: 'Détails approfondis sur l\'application mobile développée pour ABC.',
          features: [
            { name: 'iOS', icon: '📱' },
            { name: 'Android', icon: '🤖' }
          ],
          lien: 'https://placehold.co/300x200/png',
          couleur: 'bg-green-500 text-white'
        }
        // Ajoute d'autres projets ici
      ],
      popupOpen: false,
      popupProjet: {},
      openPopup(index) {
        this.popupProjet = this.projets[index];
        this.popupOpen = true;
      },
      closePopup() {
        this.popupOpen = false;
      }
    }
  }
</script>

</body>
</html>
