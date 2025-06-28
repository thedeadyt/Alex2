<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- ✅ Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ✅ Alpine.js CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <div
  x-data="{
    scrollY: 0,
    projets: [
      {titre: 'Projet 1', couleur: 'bg-blue-600'},
      {titre: 'Projet 2', couleur: 'bg-green-500'},
      {titre: 'Projet 3', couleur: 'bg-purple-700'},
      {titre: 'Projet 4', couleur: 'bg-orange-500'}
    ],
    visibleIndexes: new Set(),

    updateVisibleIndexes() {
      this.visibleIndexes.clear();
      this.projets.forEach((_, i) => {
        if (this.scrollY >= i * 400) this.visibleIndexes.add(i);
      });
    }
  }"
  x-init="
    window.addEventListener('scroll', () => {
      scrollY = window.scrollY;
      updateVisibleIndexes();
    });
    updateVisibleIndexes();
  "
  class="bg-gray-100 min-h-[300vh] p-10 max-w-xl mx-auto"
>
  <template x-for="(projet, i) in projets" :key="i">
    <div
      :class="projet.couleur + ' text-white rounded-2xl shadow-xl p-6 flex flex-col justify-center items-center transition-all duration-700 ease-out'"
      :style="{
        position: 'sticky',
        top: '20px',
        zIndex: 1000 + i,
        transform: visibleIndexes.has(i) ? 'translateY(0)' : 'translateY(20px)',
        opacity: visibleIndexes.has(i) ? 1 : 0
      }"
      style="height: 400px; margin-bottom: 2rem;"
    >
      <h2 class="text-3xl font-bold mb-2" x-text="projet.titre"></h2>
      <p class="text-lg">Description du <span x-text="projet.titre"></span></p>
    </div>
  </template>
</div>



</body>
</html>