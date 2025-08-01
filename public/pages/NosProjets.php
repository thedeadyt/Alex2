<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
// Récupération des projets depuis la BDD
$projets = [];
$stmt = $pdo->query("SELECT * FROM projets");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Ici pas de features, tu peux adapter si besoin
    $projets[] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Projets | &lt;alex²/&gt;</title>
<link rel="icon" href="<?= BASE_URL ?>/Alex2logo.png" type="image/x-icon">
<link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
<link rel='stylesheet' type='text/css' media='screen' href='<?= BASE_URL ?>/asset/css/NosProjets.css'>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body style="background-color: var(--color-white); color: var(--color-black);">
  <?php
  include __DIR__ . '/../../includes/header.php';
  ?>
  <div class="p-10 mx-auto" style="max-width: 1200px;" x-data="projetsData()" id="content">
    <h1 class="text-4xl font-bold mb-8">Nos Projets</h1>

    <div class="pb-[160px]">
      <template x-for="(projet, i) in projets" :key="i">
        <div
          class="bg-[var(--color-black)] text-[var(--color-white)] projet sticky-top relative flex flex-col justify-between p-6 rounded mb-10 shadow-lg"
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
          <h2 class="text-2xl font-bold mb-2" style="font-family: var(--font-heading);" x-text="projet.nom"></h2>

          <!-- Description courte -->
          <p class="mb-4" style="font-family: var(--font-base);" x-text="projet.description_courte"></p>

          <!-- Bouton -->
          <button
            @click="openPopup(i)"
            class="w-full py-2 rounded font-semibold border transition"
            style="
              border-color: var(--color-white);
              background-color: transparent;
              color: var(--color-white);
            "
            @mouseenter="$el.style.backgroundColor = 'var(--color-white)'; $el.style.color = 'var(--color-black)'"
            @mouseleave="$el.style.backgroundColor = 'transparent'; $el.style.color = 'var(--color-white)'"
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
      @click.outside="closePopup()"
    >
      <div class="bg-white rounded-lg w-[700px] p-6 relative shadow-xl" @click.stop>
        <!-- Bouton fermeture -->
        <button
          @click="closePopup()"
          class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl font-bold"
          aria-label="Fermer"
        >
          &times;
        </button>

        <!-- IMAGE EN GRAND -->
        <img :src="popupProjet.image" alt="Image grand projet" class="w-full h-auto rounded mb-4" />

        <!-- NOM DU PROJET -->
        <h3 class="text-3xl mb-2" style="color: var(--color-black); font-family: var(--font-base);" x-text="popupProjet.nom"></h3>

        <!-- DESCRIPTION DÉTAILLÉE -->
        <p class="mb-4" style="color: var(--color-black); font-family: var(--font-base);" x-text="popupProjet.description_detaillee"></p>

        <!-- Bouton vers projet -->
        <a
          :href="popupProjet.lien"
          target="_blank"
          rel="noopener noreferrer"
          class="block mt-6 w-full text-center py-3 rounded transition"
          style="background-color: var(--color-black); color: var(--color-white);"
        >
          Voir le projet
        </a>
      </div>
    </div>
  </div>

  <?php include __DIR__ . '/../../includes/footer.php'; ?>

  <script>
    function projetsData() {
      return {
        projets: <?= json_encode($projets, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
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
