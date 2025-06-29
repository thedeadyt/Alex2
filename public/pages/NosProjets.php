<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Projets sticky superposés - fix scroll</title>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
  .projet {
    height: 400px;
    border-radius: 1rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    color: white;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
  }
  .sticky-top {
    position: sticky;
    top: 20px;
  }
</style>
</head>
<body class="bg-gray-100 p-10 max-w-xl mx-auto">

<div x-data="{
  projets: [
    { titre: 'Projet 1', couleur: 'bg-blue-600' },
    { titre: 'Projet 2', couleur: 'bg-green-500' },
    { titre: 'Projet 3', couleur: 'bg-purple-700' },
    { titre: 'Projet 4', couleur: 'bg-orange-500' }
  ]
}" 
  class="pb-[460px]"  <!-- padding bottom important pour scroller -->
>
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

</body>
</html>
