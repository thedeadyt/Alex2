<!-- CTA Section — Modern Terminal Style -->
<section class="relative overflow-hidden py-24 px-6" style="background: #0a0a0a;">
  <!-- Grid background -->
  <div class="absolute inset-0 opacity-[0.04]" style="background-image: linear-gradient(rgba(81,132,92,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(81,132,92,.5) 1px, transparent 1px); background-size: 40px 40px;"></div>
  <!-- Glow orbs -->
  <div class="absolute top-0 left-1/4 w-72 h-72 rounded-full opacity-20 blur-3xl pointer-events-none" style="background: radial-gradient(circle, #51845C, transparent);"></div>
  <div class="absolute bottom-0 right-1/4 w-72 h-72 rounded-full opacity-15 blur-3xl pointer-events-none" style="background: radial-gradient(circle, #2563EB, transparent);"></div>

  <div class="relative max-w-4xl mx-auto text-center">
    <!-- Terminal prompt badge -->
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-8" style="background: rgba(81,132,92,0.1); border: 1px solid rgba(81,132,92,0.25);">
      <span class="w-2 h-2 rounded-full animate-pulse" style="background: #51845C; box-shadow: 0 0 8px #51845C;"></span>
      <code class="text-sm" style="color: #51845C; font-family: monospace;">~/projet$ ready_to_start</code>
    </div>

    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 leading-tight" style="font-family: var(--font-bounded);">
      Transformons votre idée<br>
      <span class="bg-gradient-to-r from-green-400 to-blue-500 bg-clip-text text-transparent">en réalité.</span>
    </h2>
    <p class="text-xl text-gray-400 max-w-2xl mx-auto mb-10" style="font-family: var(--font-tinos);">
      Un café, une idée, un site. Devis gratuit sous 48h — à Tarbes, Lourdes ou en visio.
    </p>

    <!-- CTA buttons -->
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
      <a href="<?= BASE_URL ?>contact" class="group inline-flex items-center gap-3 px-8 py-4 rounded-xl font-black text-xl text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl" style="background: linear-gradient(135deg, #51845C 0%, #2563EB 100%); font-family: var(--font-bounded); box-shadow: 0 8px 32px rgba(81,132,92,0.3);">
        Démarrer un projet
        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
      </a>
      <a href="<?= BASE_URL ?>nos-realisations" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-black text-xl transition-all duration-300 hover:-translate-y-1" style="color: #e5e7eb; border: 1px solid rgba(255,255,255,0.15); font-family: var(--font-bounded); background: rgba(255,255,255,0.03);">
        Voir nos projets
      </a>
    </div>

    <!-- Trust badges -->
    <div class="flex flex-wrap justify-center gap-8 text-gray-500" style="font-family: var(--font-tinos);">
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4" style="color: #51845C;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        <span class="text-sm">Devis gratuit</span>
      </div>
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4" style="color: #51845C;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        <span class="text-sm">100% sur mesure</span>
      </div>
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4" style="color: #51845C;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        <span class="text-sm">Réponse sous 24h</span>
      </div>
    </div>
  </div>
</section>
