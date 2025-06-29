<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Projets sticky superposés - fix scroll</title>
<link rel='stylesheet' type='text/css' media='screen' href='../asset/css/NosProjets.css'>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
<?php
include_once '../../includes/header.php';
?>

<div class="p-10 max-w-xl mx-auto">
  <h1 class="text-4xl font-bold mb-8">Nos Projets</h1>

  <div x-data="{
    projets: [
      { titre: 'Projet 1', couleur: 'bg-blue-600' },
      { titre: 'Projet 2', couleur: 'bg-green-500' },
      { titre: 'Projet 3', couleur: 'bg-purple-700' },
      { titre: 'Projet 4', couleur: 'bg-orange-500' }
    ]
  }" 
    class="pb-[20px]"  <!-- padding bottom important pour scroller -->
  
    <template x-for="(projet, i) in projets" :key="i">
      <div
        :class="projet.couleur + ' projet sticky-top'"
        :style="{ zIndex: 1000 + i }"
      >
        <h2 class="text-3xl font-bold mb-4" x-text="projet.titre"></h2>
        <p>Description détaillée du <span x-text="projet.titre"></span></p>
      </div>
    </template>
  </div>
</div>

<?php
include_once '../../includes/footer.php';
?>
</body>
</html>
