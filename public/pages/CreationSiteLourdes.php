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
    <title>Création de Site Internet à Lourdes (65) | Agence Web | Alex²</title>
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

    <meta name="description" content="Création de site internet à Lourdes (65). Alex² conçoit des sites web sur mesure pour les hôtels, commerces, restaurants et associations de Lourdes. Devis gratuit.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://alex2.dev/creation-site-internet-lourdes">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Création de Site Internet à Lourdes (65) | Alex²">
    <meta property="og:description" content="Création de site internet à Lourdes : sites vitrines, applications web et solutions sur mesure pour les entreprises de Lourdes.">
    <meta property="og:url" content="https://alex2.dev/creation-site-internet-lourdes">
    <meta property="og:image" content="https://alex2.dev/asset/img/Alex2_logo.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Création de Site Internet à Lourdes (65) | Alex²">
    <meta name="twitter:description" content="Création de site internet à Lourdes : sites vitrines, applications web et solutions sur mesure.">
    <meta name="twitter:image" content="https://alex2.dev/asset/img/Alex2_logo.png">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ProfessionalService",
      "name": "Alex² - Création de site internet Lourdes",
      "image": "https://alex2.dev/Alex2logo.png",
      "url": "https://alex2.dev/creation-site-internet-lourdes",
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
      "description": "Création de site internet à Lourdes (65). Sites vitrines, applications web et solutions digitales pour les entreprises de Lourdes.",
      "areaServed": {
        "@type": "City",
        "name": "Lourdes"
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
        <span class="inline-flex items-center px-3 py-1 rounded-full text-base font-black mb-6" style="background: #dbeafe; color: #1e40af; font-family: var(--font-bounded);">
          Création de Site · Lourdes (65)
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight leading-tight mb-6" style="font-family: var(--font-bounded); color: var(--color-black);">
          <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">Création de site internet</span> à Lourdes
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed" style="font-family: var(--font-tinos);">
          Besoin d'un <strong>site internet à Lourdes</strong> ? Alex² est une agence web locale, basée à Lourdes et Tarbes. Nous créons des sites modernes, performants et optimisés pour attirer vos clients, que vous soyez hôtelier, commerçant, restaurateur ou association.
        </p>
      </div>

      <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
        <a href="<?= BASE_URL ?>contact" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl font-black text-xl text-white transition-all duration-300 hover:-translate-y-1" style="background: linear-gradient(135deg, #51845C, #2563EB); font-family: var(--font-bounded); box-shadow: 0 4px 15px rgba(81,132,92,0.3);">
          Obtenir un devis gratuit
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
        </a>
        <a href="<?= BASE_URL ?>nos-realisations" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl font-black text-xl transition-all duration-300 border-2 hover:-translate-y-1" style="color: var(--color-black); border-color: #e5e7eb; font-family: var(--font-bounded);">
          Nos réalisations
        </a>
      </div>
    </div>
  </section>

  <!-- Spécificités Lourdes -->
  <section class="py-20 px-6" style="background: var(--color-gray-50);">
    <div class="max-w-5xl mx-auto">
      <h2 class="text-3xl md:text-4xl font-black mb-4 text-center" style="font-family: var(--font-bounded); color: var(--color-black);">
        Des sites internet adaptés aux entreprises de Lourdes
      </h2>
      <p class="text-lg text-gray-600 max-w-3xl mx-auto text-center mb-12" style="font-family: var(--font-tinos);">
        Lourdes accueille des millions de visiteurs chaque année. Votre site internet doit être à la hauteur : rapide, multilingue et visible sur Google pour capter cette audience.
      </p>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Sites pour hôtels</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Présentez vos chambres, tarifs et disponibilités. Intégration de moteurs de réservation et galeries photos professionnelles.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Sites pour restaurants</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Menus en ligne, réservation de table, carte interactive. Un site qui donne envie et facilite la vie de vos clients.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Sites pour commerces</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Boutiques en ligne, vitrines digitales. Vendez vos produits locaux ou souvenirs à une clientèle internationale.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Sites pour associations</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Informez vos membres, gérez les inscriptions et communiquez sur vos événements avec un site clair et accessible.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Sites multilingues</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Touchez les pèlerins et touristes du monde entier. Sites en français, anglais, espagnol, italien et plus encore.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">SEO local Lourdes</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Apparaissez dans les premiers résultats Google quand les visiteurs cherchent vos services à Lourdes.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Pourquoi Alex² -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-5xl mx-auto">
      <h2 class="text-3xl md:text-4xl font-black mb-8 text-center" style="font-family: var(--font-bounded); color: var(--color-black);">
        Pourquoi choisir Alex² à Lourdes ?
      </h2>
      <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <div class="flex gap-4">
          <div class="w-10 h-10 rounded-lg flex-shrink-0 flex items-center justify-center" style="background: #dcfce7;">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
          </div>
          <div>
            <h3 class="font-black mb-1" style="font-family: var(--font-bounded);">Basés à Lourdes</h3>
            <p class="text-gray-600 text-sm" style="font-family: var(--font-tinos);">On se rencontre en personne. On connaît le marché lourdais, ses spécificités et ses opportunités.</p>
          </div>
        </div>
        <div class="flex gap-4">
          <div class="w-10 h-10 rounded-lg flex-shrink-0 flex items-center justify-center" style="background: #dcfce7;">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
          </div>
          <div>
            <h3 class="font-black mb-1" style="font-family: var(--font-bounded);">Code 100% sur mesure</h3>
            <p class="text-gray-600 text-sm" style="font-family: var(--font-tinos);">Pas de WordPress ni de template. Chaque site est unique, rapide et sécurisé.</p>
          </div>
        </div>
        <div class="flex gap-4">
          <div class="w-10 h-10 rounded-lg flex-shrink-0 flex items-center justify-center" style="background: #dcfce7;">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
          </div>
          <div>
            <h3 class="font-black mb-1" style="font-family: var(--font-bounded);">Référencement inclus</h3>
            <p class="text-gray-600 text-sm" style="font-family: var(--font-tinos);">Chaque site est optimisé pour Google dès sa création. Balisage, performance et contenu ciblé.</p>
          </div>
        </div>
        <div class="flex gap-4">
          <div class="w-10 h-10 rounded-lg flex-shrink-0 flex items-center justify-center" style="background: #dcfce7;">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
          </div>
          <div>
            <h3 class="font-black mb-1" style="font-family: var(--font-bounded);">Devis gratuit, réponse 24h</h3>
            <p class="text-gray-600 text-sm" style="font-family: var(--font-tinos);">Décrivez votre projet et recevez une proposition adaptée à votre budget.</p>
          </div>
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
          <div class="text-sm text-gray-500" style="font-family: var(--font-tinos);">Sites créés</div>
        </div>
        <div>
          <div class="text-4xl font-black mb-1" style="font-family: var(--font-bounded); color: #2563EB;">100%</div>
          <div class="text-sm text-gray-500" style="font-family: var(--font-tinos);">Sur mesure</div>
        </div>
        <div>
          <div class="text-4xl font-black mb-1" style="font-family: var(--font-bounded); color: #51845C;">24h</div>
          <div class="text-sm text-gray-500" style="font-family: var(--font-tinos);">Réponse garantie</div>
        </div>
        <div>
          <div class="text-4xl font-black mb-1" style="font-family: var(--font-bounded); color: #2563EB;">A</div>
          <div class="text-sm text-gray-500" style="font-family: var(--font-tinos);">EcoIndex</div>
        </div>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/../../includes/cta.php'; ?>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
</body>
</html>
