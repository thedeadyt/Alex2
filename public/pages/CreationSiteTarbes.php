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
    <title>Création de Site Internet à Tarbes (65) | Agence Web | Alex²</title>
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

    <meta name="description" content="Création de site internet à Tarbes (65). Alex² conçoit des sites web sur mesure, modernes et optimisés SEO pour les entreprises, artisans et commerces de Tarbes et des Hautes-Pyrénées.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://alex2.dev/creation-site-internet-tarbes">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Création de Site Internet à Tarbes (65) | Alex²">
    <meta property="og:description" content="Création de site internet à Tarbes : sites vitrines, applications web et solutions sur mesure. Devis gratuit.">
    <meta property="og:url" content="https://alex2.dev/creation-site-internet-tarbes">
    <meta property="og:image" content="https://alex2.dev/asset/img/Alex2_logo.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Création de Site Internet à Tarbes (65) | Alex²">
    <meta name="twitter:description" content="Création de site internet à Tarbes : sites vitrines, applications web et solutions sur mesure.">
    <meta name="twitter:image" content="https://alex2.dev/asset/img/Alex2_logo.png">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ProfessionalService",
      "name": "Alex² - Création de site internet Tarbes",
      "image": "https://alex2.dev/Alex2logo.png",
      "url": "https://alex2.dev/creation-site-internet-tarbes",
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
      "description": "Création de site internet à Tarbes (65). Sites vitrines, applications web, APIs REST et hébergement sur mesure.",
      "areaServed": {
        "@type": "City",
        "name": "Tarbes"
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
          Création de Site · Tarbes (65)
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight leading-tight mb-6" style="font-family: var(--font-bounded); color: var(--color-black);">
          <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">Création de site internet</span> à Tarbes
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed" style="font-family: var(--font-tinos);">
          Vous souhaitez <strong>créer votre site internet à Tarbes</strong> ? Alex² est votre agence web locale. Nous concevons des sites web sur mesure, modernes et optimisés pour attirer vos clients dans les Hautes-Pyrénées et au-delà.
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

  <!-- Types de sites -->
  <section class="py-20 px-6" style="background: var(--color-gray-50);">
    <div class="max-w-5xl mx-auto">
      <h2 class="text-3xl md:text-4xl font-black mb-4 text-center" style="font-family: var(--font-bounded); color: var(--color-black);">
        Quel type de site internet pour votre entreprise à Tarbes ?
      </h2>
      <p class="text-lg text-gray-600 max-w-3xl mx-auto text-center mb-12" style="font-family: var(--font-tinos);">
        Chaque entreprise a des besoins différents. Que vous soyez artisan, commerçant, profession libérale ou association à Tarbes, nous avons la solution adaptée.
      </p>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Site vitrine</h3>
          <p class="text-gray-600 mb-4" style="font-family: var(--font-tinos);">
            Présentez votre activité, vos services et vos coordonnées. Idéal pour les artisans, PME et professions libérales de Tarbes qui veulent être visibles en ligne.
          </p>
          <span class="text-base font-black px-3 py-1 rounded-full" style="background: #dcfce7; color: #166534; font-family: var(--font-bounded);">Le plus demandé</span>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Site e-commerce</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Vendez vos produits en ligne avec une boutique sur mesure. Gestion des stocks, paiements sécurisés et expéditions automatisées.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Application web</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Outil de gestion interne, espace client, système de réservation... Des applications web sur mesure pour digitaliser votre activité.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Portfolio & blog</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Montrez votre travail et partagez votre expertise. Idéal pour photographes, artistes, consultants et freelances de Tarbes.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Refonte de site</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Votre site actuel est lent ou daté ? Nous le modernisons avec un design actuel, des performances optimales et un meilleur référencement.
          </p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
          <h3 class="text-2xl font-black mb-3" style="font-family: var(--font-bounded);">Maintenance & SEO</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">
            Mises à jour, sécurité, optimisation du référencement. On s'occupe de votre site pour que vous puissiez vous concentrer sur votre activité.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Pourquoi Alex² -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-5xl mx-auto">
      <h2 class="text-3xl md:text-4xl font-black mb-8 text-center" style="font-family: var(--font-bounded); color: var(--color-black);">
        Pourquoi choisir Alex² pour créer votre site à Tarbes ?
      </h2>
      <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <div class="flex gap-4">
          <div class="w-10 h-10 rounded-lg flex-shrink-0 flex items-center justify-center" style="background: #dcfce7;">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
          </div>
          <div>
            <h3 class="font-black mb-1" style="font-family: var(--font-bounded);">Pas de template, du vrai code</h3>
            <p class="text-gray-600 text-sm" style="font-family: var(--font-tinos);">Chaque site est développé à la main. Pas de WordPress, pas de template. Un site unique qui vous ressemble.</p>
          </div>
        </div>
        <div class="flex gap-4">
          <div class="w-10 h-10 rounded-lg flex-shrink-0 flex items-center justify-center" style="background: #dcfce7;">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
          </div>
          <div>
            <h3 class="font-black mb-1" style="font-family: var(--font-bounded);">SEO intégré dès le départ</h3>
            <p class="text-gray-600 text-sm" style="font-family: var(--font-tinos);">Optimisation technique, balisage sémantique et performance. Votre site est conçu pour être bien référencé sur Google.</p>
          </div>
        </div>
        <div class="flex gap-4">
          <div class="w-10 h-10 rounded-lg flex-shrink-0 flex items-center justify-center" style="background: #dcfce7;">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
          </div>
          <div>
            <h3 class="font-black mb-1" style="font-family: var(--font-bounded);">Agence locale à Tarbes</h3>
            <p class="text-gray-600 text-sm" style="font-family: var(--font-tinos);">On se rencontre, on échange en direct. Pas d'intermédiaire, pas de call center. Juste vous et nous.</p>
          </div>
        </div>
        <div class="flex gap-4">
          <div class="w-10 h-10 rounded-lg flex-shrink-0 flex items-center justify-center" style="background: #dcfce7;">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
          </div>
          <div>
            <h3 class="font-black mb-1" style="font-family: var(--font-bounded);">Devis gratuit sous 24h</h3>
            <p class="text-gray-600 text-sm" style="font-family: var(--font-tinos);">Contactez-nous et recevez une proposition détaillée adaptée à votre budget et vos objectifs.</p>
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
