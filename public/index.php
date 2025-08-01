<?php
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Accueil | &lt;alex²/&gt;</title>
    <link rel="icon" href="./Alex2logo.png" type="image/x-icon">
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
  <?php
  include __DIR__ . '/../includes/header.php';
  ?>
    <section id="content">

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
