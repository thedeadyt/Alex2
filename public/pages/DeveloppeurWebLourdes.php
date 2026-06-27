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
    <title>Développeur Web à Lourdes (65) | Création de Site Sur Mesure | Alex²</title>
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

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-EFTK5TK4MM"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-EFTK5TK4MM');
    </script>

    <meta name="description" content="Développeur web à Lourdes (65). Alex², duo de développeurs créant des sites internet sur mesure, performants et optimisés SEO pour les entreprises de Lourdes et des Hautes-Pyrénées.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://alex2.dev/developpeur-web-lourdes">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Développeur Web à Lourdes (65) | Alex²">
    <meta property="og:description" content="Développeur web à Lourdes : création de sites sur mesure, backend PHP et APIs REST. Devis gratuit sous 24h.">
    <meta property="og:url" content="https://alex2.dev/developpeur-web-lourdes">
    <meta property="og:image" content="https://alex2.dev/asset/img/Alex2_logo.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Développeur Web à Lourdes (65) | Alex²">
    <meta name="twitter:description" content="Développeur web à Lourdes : création de sites sur mesure, backend PHP et APIs REST.">
    <meta name="twitter:image" content="https://alex2.dev/asset/img/Alex2_logo.png">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ProfessionalService",
      "name": "Alex² - Développeur Web Lourdes",
      "image": "https://alex2.dev/Alex2logo.png",
      "url": "https://alex2.dev/developpeur-web-lourdes",
      "telephone": ["+33768882766", "+33686825714"],
      "priceRange": "€€",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "8 Rue Charles Baudelaire",
        "addressLocality": "Lourdes",
        "postalCode": "65100",
        "addressCountry": "FR"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 43.0956,
        "longitude": 0.0475
      },
      "sameAs": [
        "https://www.instagram.com/alex2.dev",
        "https://www.linkedin.com/company/alex2",
        "https://github.com/Alex2-dev"
      ],
      "description": "Développeur web à Lourdes (65). Création de sites internet sur mesure, backend PHP, APIs REST et hébergement.",
      "areaServed": {
        "@type": "City",
        "name": "Lourdes"
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
          Développeur Web · Lourdes (65)
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight leading-tight mb-6" style="font-family: var(--font-bounded); color: var(--color-black);">
          Votre <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">développeur web</span> à Lourdes
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed" style="font-family: var(--font-tinos);">
          Vous cherchez un <strong>développeur web à Lourdes</strong> pour créer votre site internet ? Alex² est un duo de développeurs basé à Lourdes et Tarbes, spécialisé dans la création de sites web sur mesure pour les entreprises, commerces et associations de la cité mariale et des Hautes-Pyrénées.
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

  <!-- Pourquoi -->
  <section class="py-20 px-6" style="background: var(--color-gray-50);">
    <div class="max-w-5xl mx-auto">
      <h2 class="text-3xl md:text-4xl font-black mb-8 text-center" style="font-family: var(--font-bounded); color: var(--color-black);">
        Un développeur web à Lourdes qui comprend vos enjeux
      </h2>
      <p class="text-lg text-gray-600 max-w-3xl mx-auto text-center mb-12" style="font-family: var(--font-tinos);">
        Lourdes est une ville unique avec ses spécificités : tourisme religieux, hôtellerie, commerces saisonniers et associations. En tant que <strong>développeur web à Lourdes</strong>, nous comprenons ces enjeux et créons des sites adaptés à votre réalité locale.
      </p>

      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: #dcfce7;">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
          </div>
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Connaissance du terrain</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Basés à Lourdes, nous connaissons le tissu économique local. Hôtels, restaurants, boutiques de souvenirs, associations : nous créons des sites adaptés à chaque secteur.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: #dbeafe;">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
          </div>
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Sites multilingues</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Lourdes accueille des visiteurs du monde entier. Nous pouvons créer des sites multilingues pour toucher une clientèle internationale.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: #dcfce7;">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
          </div>
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Performance & sécurité</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Pas de template. Du code sur mesure, rapide et sécurisé en PHP, React et MySQL. Hébergement et maintenance inclus.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Services -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-5xl mx-auto">
      <h2 class="text-3xl md:text-4xl font-black mb-8 text-center" style="font-family: var(--font-bounded); color: var(--color-black);">
        Nos services de développement web à Lourdes
      </h2>
      <div class="grid md:grid-cols-2 gap-8">
        <div class="p-6 rounded-2xl border-2 border-gray-100">
          <h3 class="text-xl font-black mb-2" style="font-family: var(--font-bounded);">Sites vitrines & hôtellerie</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">Sites modernes pour hôtels, restaurants et commerces de Lourdes. Optimisés mobile, rapides et référencés sur Google.</p>
        </div>
        <div class="p-6 rounded-2xl border-2 border-gray-100">
          <h3 class="text-xl font-black mb-2" style="font-family: var(--font-bounded);">Applications web sur mesure</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">Outils de gestion, espaces clients, systèmes de réservation. Des solutions digitales adaptées à votre activité.</p>
        </div>
        <div class="p-6 rounded-2xl border-2 border-gray-100">
          <h3 class="text-xl font-black mb-2" style="font-family: var(--font-bounded);">APIs REST & automatisation</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">Connectez vos outils entre eux. Synchronisation, automatisation et intégrations pour gagner en efficacité.</p>
        </div>
        <div class="p-6 rounded-2xl border-2 border-gray-100">
          <h3 class="text-xl font-black mb-2" style="font-family: var(--font-bounded);">SEO & référencement local</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">Apparaissez en haut de Google quand quelqu'un cherche vos services à Lourdes. Optimisation technique et contenu ciblé.</p>
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
        Basés à <strong>Lourdes</strong> et <strong>Tarbes</strong>, nous intervenons dans toutes les Hautes-Pyrénées et au-delà, en présentiel ou à distance.
      </p>
      <div class="flex flex-wrap justify-center gap-3">
        <span class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" style="font-family: var(--font-tinos);">Lourdes</span>
        <a href="<?= BASE_URL ?>developpeur-web-tarbes" class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors no-underline" style="font-family: var(--font-tinos);">Tarbes</a>
        <span class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" style="font-family: var(--font-tinos);">Bagnères-de-Bigorre</span>
        <span class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" style="font-family: var(--font-tinos);">Argelès-Gazost</span>
        <span class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" style="font-family: var(--font-tinos);">Cauterets</span>
        <span class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" style="font-family: var(--font-tinos);">Hautes-Pyrénées</span>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/../../includes/cta.php'; ?>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
</body>
</html>
