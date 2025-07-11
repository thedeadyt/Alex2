<?php
require_once __DIR__ . '/../config/config.php';
include __DIR__ . '/../includes/header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Accueil | &lt;alex²/&gt;</title>
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>

    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/favicon.ico">
    <link rel='stylesheet' type='text/css' media='screen' href='<?= BASE_URL ?>/asset/css/index.css'>

    <!-- Garder UNE SEULE inclusion d'Alpine.js avec defer -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <section class="py-16 px-6" style="background-color: var(--color-white); color: var(--color-black);">
      <div class="max-w-4xl mx-auto text-center space-y-6">
        <h1 class="text-4xl font-bold">Bienvenue chez &lt;Alex²/&gt;</h1>
        <p class="text-lg">
          Chez <strong>&lt;Alex²/&gt;</strong>, nous concevons des sites web modernes, performants et sur mesure.<br>
          Chaque projet est pensé pour répondre précisément à vos objectifs et s’adapter à votre audience.<br>
          Notre priorité : une approche rigoureuse, un accompagnement personnalisé et des résultats concrets. 
        </p>
        
        <div x-data="{ showMore: false }" class="space-y-4">
          <button @click="showMore = !showMore"
                  class="bg-white text-green-700 px-4 py-2 rounded-full font-semibold transition hover:bg-gray-100">
            <span x-text="showMore ? 'Masquer' : 'En savoir plus'"></span>
          </button>
          
          <div x-show="showMore" x-transition>
            <p class="text-base">
              Notre approche : écoute, créativité et excellence technique pour un résultat qui vous ressemble.
            </p>
          </div>
        </div>
      </div>
    </section>
    <section style="background-color: var(--color-white); color: var(--color-black); border-color: var(--color-black)">
      <div class="p-10 mx-auto" style="max-width: 1200px;" x-data="projetsData()" id="content">

          <div class="pb-[5px]"><!-- padding bottom important pour scroller -->

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
                <h2 class="text-2xl font-bold mb-2" style="color: var(--color-white); font-family: var(--font-heading);" x-text="projet.nom"></h2>

                <!-- Description -->
                <p class="mb-4" style="color: var(--color-white); font-family: var(--font-base);" x-text="projet.description"></p>

                <!-- Features (avec pictos) -->
                <ul class="flex space-x-6 mb-6" style="color: var(--color-white); font-family: var(--font-base);">
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
              <h3 class="text-3xl mb-2" style="color: var(--color-black); font-family: var(--font-base);" x-text="popupProjet.nom"></h3>
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
      </div>
    </section>

    <!-- Section Services modifiée pour rendre les bulles cliquables -->
    <section x-data="serviceBubbles()" class="py-10" style="background-color: var(--color-white); color: var(--color-black);">
      <div class="flex flex-wrap justify-center gap-8 max-w-4xl mx-auto">
        <template x-for="(service, index) in services" :key="index">
          <a
            :href="service.url"
            class="rounded-full w-36 h-36 flex items-center justify-center text-center p-4 shadow-lg transition-all duration-700 ease-in-out transform cursor-pointer"
            :class="service.visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
            style="background-color: var(--color-black); color: var(--color-white);"
            target="_blank" rel="noopener noreferrer"
            :data-index="index"
          >
            <span x-text="service.name"></span>
          </a>
        </template>
      </div>
    </section>

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
            // Ajoute d'autres projets ici si besoin
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

      function serviceBubbles() {
        return {
          services: [
            { name: 'Sites vitrines', visible: false, url: 'services.php#sites-vitrines' },
            { name: 'E-commerce', visible: false, url: 'services.php#e-commerce' },
            { name: 'Applications web', visible: false, url: 'services.php#applications-web' },
            { name: 'Maintenance & support', visible: false, url: 'services.php#maintenance-support' },
            { name: 'Conseil digital', visible: false, url: 'services.php#conseil-digital' },
          ],
          init() {
            const onScroll = () => {
              const bubbles = document.querySelectorAll('a[data-index]');
              bubbles.forEach((el) => {
                const rect = el.getBoundingClientRect();
                const index = parseInt(el.getAttribute('data-index'));
                if (rect.top < window.innerHeight - 50) {
                  this.services[index].visible = true;
                }
              });
            };
            window.addEventListener('scroll', onScroll);
            onScroll(); // check au chargement aussi
          }
        }
      }
    </script>

<?php
include __DIR__ . '/../includes/footer.php';
?>
</body>
</html>
