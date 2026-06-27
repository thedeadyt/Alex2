<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

$nbProjets = $pdo->query("SELECT COUNT(*) FROM projets")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Développeur Web à Tarbes (65) | Création de Site Sur Mesure | Alex²</title>
    <link rel="icon" href="<?= BASE_URL ?>Alex2logo.png" type="image/x-icon">
    <link rel="preload" href="<?= BASE_URL ?>asset/fonts/Bounded-Regular.ttf" as="font" type="font/ttf" crossorigin>
    <link rel="preload" href="<?= BASE_URL ?>asset/fonts/Bounded-Black.ttf" as="font" type="font/ttf" crossorigin>
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/variables.css?v=10">
    <style>
      @font-face {
        font-family: 'Bounded';
        src: url('<?= BASE_URL ?>asset/fonts/Bounded-Regular.ttf') format('truetype');
        font-weight: 100 500; font-style: normal; font-display: swap;
      }
      @font-face {
        font-family: 'Bounded';
        src: url('<?= BASE_URL ?>asset/fonts/Bounded-Black.ttf') format('truetype');
        font-weight: 600 900; font-style: normal; font-display: swap;
      }
      :root {
        --font-bounded: 'Bounded', sans-serif;
        --font-tinos: 'Tinos', serif;
        --font-heading: 'Bounded', sans-serif;
        --font-base: 'Tinos', serif;
      }
    </style>
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/index.css?v=6">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-EFTK5TK4MM"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-EFTK5TK4MM');
    </script>

    <meta name="description" content="Développeur web à Tarbes (65). Alex², duo de développeurs spécialisés en création de sites internet sur mesure, backend PHP, APIs REST et hébergement dans les Hautes-Pyrénées.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://alex2.dev/developpeur-web-tarbes">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Développeur Web à Tarbes (65) | Alex²">
    <meta property="og:description" content="Développeur web à Tarbes : création de sites sur mesure, backend PHP et APIs REST. Devis gratuit sous 24h.">
    <meta property="og:url" content="https://alex2.dev/developpeur-web-tarbes">
    <meta property="og:image" content="https://alex2.dev/asset/img/Alex2_logo.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Développeur Web à Tarbes (65) | Alex²">
    <meta name="twitter:description" content="Développeur web à Tarbes : création de sites sur mesure, backend PHP et APIs REST.">
    <meta name="twitter:image" content="https://alex2.dev/asset/img/Alex2_logo.png">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ProfessionalService",
      "name": "Alex² - Développeur Web Tarbes",
      "image": "https://alex2.dev/Alex2logo.png",
      "url": "https://alex2.dev/developpeur-web-tarbes",
      "telephone": ["+33768882766", "+33686825714"],
      "priceRange": "€€",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "8 Rue Georges Lassalle",
        "addressLocality": "Tarbes",
        "postalCode": "65000",
        "addressCountry": "FR"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 43.2330,
        "longitude": 0.0660
      },
      "sameAs": [
        "https://www.instagram.com/alex2.dev",
        "https://www.linkedin.com/company/alex2",
        "https://github.com/Alex2-dev"
      ],
      "description": "Développeur web à Tarbes (65). Création de sites internet sur mesure, backend PHP, APIs REST et hébergement.",
      "areaServed": {
        "@type": "City",
        "name": "Tarbes"
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
        "opens": "09:00",
        "closes": "18:00"
      }
    }
    </script>
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">
<?php include __DIR__ . '/../../includes/header.php'; ?>

<main id="content">
  <!-- Hero -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-5xl mx-auto">
      <div class="text-center mb-12">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-base font-black mb-6" style="background: #dcfce7; color: #166534; font-family: var(--font-bounded);">
          Développeur Web · Tarbes (65)
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight leading-tight mb-6" style="font-family: var(--font-bounded); color: var(--color-black);">
          Votre <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">développeur web</span> à Tarbes
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed" style="font-family: var(--font-tinos);">
          Vous cherchez un <strong>développeur web à Tarbes</strong> pour créer votre site internet ? Alex² est un duo de développeurs basé à Tarbes, spécialisé dans la création de sites web sur mesure, performants et optimisés pour le référencement.
        </p>
      </div>

      <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
        <a href="<?= BASE_URL ?>contact" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl font-black text-xl text-white transition-all duration-300 hover:-translate-y-1" style="background: linear-gradient(135deg, #51845C, #2563EB); font-family: var(--font-bounded); box-shadow: 0 4px 15px rgba(81,132,92,0.3);">
          Demander un devis gratuit
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
        </a>
        <a href="<?= BASE_URL ?>nos-realisations" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl font-black text-xl transition-all duration-300 border-2 hover:-translate-y-1" style="color: var(--color-black); border-color: #e5e7eb; font-family: var(--font-bounded);">
          Voir nos projets
        </a>
      </div>
    </div>
  </section>

  <!-- Pourquoi choisir un développeur web à Tarbes -->
  <section class="py-20 px-6" style="background: var(--color-gray-50);">
    <div class="max-w-5xl mx-auto">
      <h2 class="text-3xl md:text-4xl font-black mb-8 text-center" style="font-family: var(--font-bounded); color: var(--color-black);">
        Pourquoi choisir un développeur web local à Tarbes ?
      </h2>
      <p class="text-lg text-gray-600 max-w-3xl mx-auto text-center mb-12" style="font-family: var(--font-tinos);">
        Faire appel à un <strong>développeur web à Tarbes</strong> plutôt qu'à une agence parisienne ou une plateforme en ligne, c'est choisir la proximité, la réactivité et un accompagnement personnalisé pour votre projet digital.
      </p>

      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: #dcfce7;">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
          </div>
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Proximité</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Basés à Tarbes, nous vous rencontrons en personne pour comprendre vos besoins. Échanges directs, pas d'intermédiaire.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: #dbeafe;">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
          </div>
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Code sur mesure</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Pas de template WordPress. Chaque site est développé à la main en PHP, React et MySQL pour des performances optimales et un design unique.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: #dcfce7;">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
          </div>
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Réactivité</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Réponse garantie sous 24h. Nous sommes disponibles et réactifs, du premier contact à la mise en ligne et au-delà.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Nos compétences -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-5xl mx-auto">
      <h2 class="text-3xl md:text-4xl font-black mb-8 text-center" style="font-family: var(--font-bounded); color: var(--color-black);">
        Nos services de développement web à Tarbes
      </h2>
      <div class="grid md:grid-cols-2 gap-8">
        <div class="p-6 rounded-2xl border-2 border-gray-100">
          <h3 class="text-xl font-black mb-2" style="font-family: var(--font-bounded);">Sites vitrines & portfolios</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">Présentez votre activité avec un site moderne, rapide et optimisé pour Google. Idéal pour artisans, commerçants et professions libérales de Tarbes.</p>
        </div>
        <div class="p-6 rounded-2xl border-2 border-gray-100">
          <h3 class="text-xl font-black mb-2" style="font-family: var(--font-bounded);">Applications web sur mesure</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">Besoin d'un outil métier, d'un espace client ou d'un tableau de bord ? Nous développons des applications web robustes en PHP et React.</p>
        </div>
        <div class="p-6 rounded-2xl border-2 border-gray-100">
          <h3 class="text-xl font-black mb-2" style="font-family: var(--font-bounded);">APIs REST & intégrations</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">Connectez vos outils entre eux grâce à des APIs performantes. Automatisation, synchronisation de données et intégrations tierces.</p>
        </div>
        <div class="p-6 rounded-2xl border-2 border-gray-100">
          <h3 class="text-xl font-black mb-2" style="font-family: var(--font-bounded);">SEO & référencement local</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">Chaque site est optimisé pour apparaître dans les résultats de recherche à Tarbes et dans les Hautes-Pyrénées. Balisage sémantique, performance et contenu ciblé.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Chiffres -->
  <section class="py-16 px-6" style="background: var(--color-gray-50);">
    <div class="max-w-4xl mx-auto">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        <div>
          <div class="text-4xl font-black mb-1" style="font-family: var(--font-bounded); color: #51845C;"><?= $nbProjets ?>+</div>
          <div class="text-sm text-gray-500" style="font-family: var(--font-tinos);">Projets livrés</div>
        </div>
        <div>
          <div class="text-4xl font-black mb-1" style="font-family: var(--font-bounded); color: #2563EB;">100%</div>
          <div class="text-sm text-gray-500" style="font-family: var(--font-tinos);">Sur mesure</div>
        </div>
        <div>
          <div class="text-4xl font-black mb-1" style="font-family: var(--font-bounded); color: #51845C;">24h</div>
          <div class="text-sm text-gray-500" style="font-family: var(--font-tinos);">Temps de réponse</div>
        </div>
        <div>
          <div class="text-4xl font-black mb-1" style="font-family: var(--font-bounded); color: #2563EB;">65</div>
          <div class="text-sm text-gray-500" style="font-family: var(--font-tinos);">Hautes-Pyrénées</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Zone d'intervention -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-3xl md:text-4xl font-black mb-6" style="font-family: var(--font-bounded); color: var(--color-black);">
        Développeur web dans tout le 65
      </h2>
      <p class="text-lg text-gray-600 mb-8 max-w-3xl mx-auto" style="font-family: var(--font-tinos);">
        Bien que basés à <strong>Tarbes</strong>, nous intervenons dans toutes les <strong>Hautes-Pyrénées</strong> : Lourdes, Bagnères-de-Bigorre, Lannemezan, Vic-en-Bigorre, Argelès-Gazost et au-delà. Nous travaillons aussi à distance pour des clients dans toute la France.
      </p>
      <div class="flex flex-wrap justify-center gap-3">
        <span class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" style="font-family: var(--font-tinos);">Tarbes</span>
        <a href="<?= BASE_URL ?>developpeur-web-lourdes" class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors no-underline" style="font-family: var(--font-tinos);">Lourdes</a>
        <span class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" style="font-family: var(--font-tinos);">Bagnères-de-Bigorre</span>
        <span class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" style="font-family: var(--font-tinos);">Lannemezan</span>
        <span class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" style="font-family: var(--font-tinos);">Vic-en-Bigorre</span>
        <span class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" style="font-family: var(--font-tinos);">Argelès-Gazost</span>
        <span class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" style="font-family: var(--font-tinos);">Hautes-Pyrénées</span>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/../../includes/cta.php'; ?>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
</body>
</html>
