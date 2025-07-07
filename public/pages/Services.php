<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../../includes/header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Service | &lt;alex²/&gt;</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ✅ Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/asset/icons/favicon.ico.ico">
    <!-- ✅ Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body style="background-color: var(--color-white); color: var(--color-black);">
<div
  x-data="{
    services: [
      {
        name: 'create_site',
        lines: [
          '<Alex²/> ➜ run create_site',
          '> Création de sites vitrines, e-commerce & blogs',
          '> Avec ou sans identité visuelle (logo, charte)',
          '> Responsive, rapide, moderne',
          '> Statut : DISPONIBLE',
        ],
      },
      {
        name: 'seo_boost',
        lines: [
          '<Alex²/> ➜ run seo_boost',
          '> Audit SEO technique & sémantique',
          '> Optimisation des balises, performance, accessibilité',
          '> Suivi de positionnement Google',
          '> Statut : DISPONIBLE',
        ],
      },
      {
        name: 'redesign',
        lines: [
          '<Alex²/> ➜ run redesign',
          '> Refonte graphique et technique',
          '> Amélioration UX / UI',
          '> Migration sans perte de contenu',
          '> Statut : DISPONIBLE',
        ],
      },
      {
        name: 'maintenance',
        lines: [
          '<Alex²/> ➜ run maintenance',
          '> Sauvegardes automatiques & monitoring',
          '> Mises à jour CMS / plugins',
          '> Support technique réactif',
          '> Statut : DISPONIBLE',
        ],
      },
      {
        name: 'custom_dev',
        lines: [
          '<Alex²/> ➜ run custom_dev',
          '> Fonctions & outils adaptés à vos besoins',
          '> Intégration API, CRM, bases de données',
          '> Interfaces administrables',
          '> Statut : DISPONIBLE',
        ],
      },
    ]
  }"
>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto p-4" id="content">

    <template x-for="(service, idx) in services" :key="idx">
    <div
      x-data="typingService(service.lines)"
      x-init="init()"
      class="bg-black text-green-400 font-mono rounded-lg shadow-xl"
      style="min-height: 10rem;"
    >
      <!-- Couleur de la barre du haut (fond et texte) -->
      <div class="flex items-center px-3 py-1.5 rounded-t-lg" style="background-color: var( --color-hover-1);">
        <!-- Boutons rouges, jaunes, verts -->
        <div class="flex space-x-1.5 mr-3">
          <!-- Couleur bouton rouge -->
          <span class="w-3 h-3 bg-red-500 rounded-full"></span>
          <!-- Couleur bouton jaune -->
          <span class="w-3 h-3 bg-yellow-400 rounded-full"></span>
          <!-- Couleur bouton vert -->
          <span class="w-3 h-3 bg-green-500 rounded-full"></span>
        </div>
        <!-- Couleur texte du titre -->
        <span class="text-sm" style="color: var( --color-hover-4);" x-text="service.name + ' - terminal'"></span>
      </div>

      <!-- Contenu tapé ligne par ligne -->
      <div class="p-4 text-sm space-y-1 min-h-[7rem]">
        <template x-for="(line, i) in shownLines" :key="i">
          <div
            x-text="line"
            :style="i === 0 || line.includes('DISPONIBLE') 
                      ? 'color: var(--color-hover-3)' 
                      : 'color: var(--color-green)'"
          ></div>
        </template>
      </div>

    </div>
    </template>

  </div>
  <?php
  include __DIR__ . '/../../includes/footer.php';
  ?>
  <script>
    function typingService(lines) {
      return {
        lines,
        shownLines: [],
        currentLineText: '',
        lineIndex: 0,
        charIndex: 0,

        typeNextChar() {
          if (this.lineIndex >= this.lines.length) return;

          let currentLine = this.lines[this.lineIndex];

          if (this.charIndex < currentLine.length) {
            this.currentLineText += currentLine.charAt(this.charIndex);
            this.charIndex++;

            if (this.shownLines.length <= this.lineIndex) {
              this.shownLines.push(this.currentLineText);
            } else {
              this.shownLines[this.lineIndex] = this.currentLineText;
            }

            setTimeout(() => this.typeNextChar(), 50);
          } else {
            this.lineIndex++;
            this.charIndex = 0;
            this.currentLineText = '';
            setTimeout(() => this.typeNextChar(), 400);
          }
        },

        init() {
          this.typeNextChar();
        }
      }
    }
  </script>
</body>
</html>

