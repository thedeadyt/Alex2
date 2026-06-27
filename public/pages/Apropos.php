<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>À propos | &lt;Alex²/&gt;</title>
    <link rel="icon" href="<?= BASE_URL ?>Alex2logo.png" type="image/x-icon">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
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
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/Apropos.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- React & ReactDOM + Babel -->
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
    <meta name="description" content="À propos de <Alex²/>, agence de développement web à Tarbes et Lourdes (65). Notre mission : créer des sites modernes, performants et écoresponsables pour les entreprises des Hautes-Pyrénées.">

    <link rel="canonical" href="https://alex2.dev/a-propos">

    <meta property="og:title" content="À propos | <Alex²/> - Développement web 65">
    <meta property="og:description" content="Découvrez l'équipe et la mission de <Alex²/>, agence web responsable à Tarbes et Lourdes (65).">
    <meta property="og:url" content="https://alex2.dev/a-propos">

    <meta name="twitter:title" content="À propos | <Alex²/> - Développement web 65">
    <meta name="twitter:description" content="En savoir plus sur <Alex²/>, votre agence web à Tarbes et Lourdes (65) spécialisée en sites modernes et écoresponsables.">


    <!-- Local Business JSON-LD (SEO Local) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "<Alex²/>",
      "image": "https://alex2.dev/Alex2logo.png",
      "url": "https://alex2.dev",
      "telephone": ["+33768882766", "+33686825714"],
      "priceRange": "€€",
      "address": [
          {
            "@type": "PostalAddress",
            "streetAddress": "8 Rue Charles Baudelaire",
            "addressLocality": "Lourdes",
            "postalCode": "65100",
            "addressCountry": "FR"
          },
          {
            "@type": "PostalAddress",
            "streetAddress": "8 Rue Georges Lassalle",
            "addressLocality": "Tarbes",
            "postalCode": "65000",
            "addressCountry": "FR"
          }
        ],
        "geo": [
          {
            "@type": "GeoCoordinates",
            "latitude": 43.0956,
            "longitude": 0.0475
          },
          {
            "@type": "GeoCoordinates",
            "latitude": 43.2330,
            "longitude": 0.0660
          }
        ],
      "sameAs": [
        "https://www.instagram.com/alex2.dev",
        "https://www.linkedin.com/company/alex2",
        "https://github.com/Alex2-dev"
      ],
      "description": "<Alex²/> est une agence de développement web basée à Tarbes et Lourdes (65). Spécialiste en création de sites internet modernes, performants et écoresponsables dans les Hautes-Pyrénées."
    }
    </script>
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">
<?php include __DIR__ . '/../../includes/header.php'; ?>

<section id="content">
  <!-- Hero Section -->
  <section class="relative py-20 px-6 overflow-hidden" style="background-color: var(--color-white);">
    <div class="max-w-7xl mx-auto text-center relative z-10">
      <span class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-base font-black mb-6" style="font-family: var(--font-bounded);">
        Notre histoire
      </span>
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6" style="font-family: var(--font-bounded); color: var(--color-black);">
        À propos de <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">&lt;Alex²/&gt;</span>
      </h1>
      <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto mb-8" style="font-family: var(--font-tinos);">
        Deux développeurs passionnés, une vision commune : créer des sites web <strong>sobres, rapides et durables</strong> dans les Hautes-Pyrénées.
      </p>
    </div>
  </section>

  <!-- Mission Section -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-6xl mx-auto">
      <div class="text-center mb-16">
        <span class="badge badge-blue mb-4" style="font-family: var(--font-bounded);">
          Notre Mission
        </span>
        <h2 class="text-3xl md:text-4xl font-black mb-6" style="color: var(--color-black); font-family: var(--font-bounded);">
          Pourquoi nous existons
        </h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto" style="font-family: var(--font-tinos);">
          Créer des sites web simples, performants et responsables, pensés pour durer et conçus pour avoir un impact minimal sur l'environnement.
        </p>
      </div>

      <!-- Valeurs Grid -->
      <div class="grid md:grid-cols-2 gap-8">
        <!-- Qualité -->
        <div class="value-card bg-white p-8 rounded-2xl border-2 border-gray-100 hover:border-green-200 transition-all duration-300 hover:shadow-lg">
          <div class="flex items-start gap-4">
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
              <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="text-2xl font-black mb-2" style="font-family: var(--font-bounded); color: var(--color-black);">
                Qualité
              </h3>
              <p class="text-gray-700" style="font-family: var(--font-tinos);">
                Un code propre, optimisé et fiable. Chaque ligne est écrite avec soin pour garantir performance et maintenabilité.
              </p>
            </div>
          </div>
        </div>

        <!-- Simplicité -->
        <div class="value-card bg-white p-8 rounded-2xl border-2 border-gray-100 hover:border-blue-200 transition-all duration-300 hover:shadow-lg">
          <div class="flex items-start gap-4">
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
              <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="text-2xl font-black mb-2" style="font-family: var(--font-bounded); color: var(--color-black);">
                Simplicité
              </h3>
              <p class="text-gray-700" style="font-family: var(--font-tinos);">
                Des sites efficaces, utiles, sans superflu. Nous privilégions la clarté et l'essentiel pour une expérience utilisateur optimale.
              </p>
            </div>
          </div>
        </div>

        <!-- Responsabilité -->
        <div class="value-card bg-white p-8 rounded-2xl border-2 border-gray-100 hover:border-green-200 transition-all duration-300 hover:shadow-lg">
          <div class="flex items-start gap-4">
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
              <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="text-2xl font-black mb-2" style="font-family: var(--font-bounded); color: var(--color-black);">
                Responsabilité
              </h3>
              <p class="text-gray-700" style="font-family: var(--font-tinos);">
                Sobriété numérique, hébergement éco-responsable, optimisation des ressources. Chaque décision est pensée pour réduire l'impact environnemental.
              </p>
            </div>
          </div>
        </div>

        <!-- Accessibilité -->
        <div class="value-card bg-white p-8 rounded-2xl border-2 border-gray-100 hover:border-blue-200 transition-all duration-300 hover:shadow-lg">
          <div class="flex items-start gap-4">
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
              <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="text-2xl font-black mb-2" style="font-family: var(--font-bounded); color: var(--color-black);">
                Accessibilité
              </h3>
              <p class="text-gray-700" style="font-family: var(--font-tinos);">
                Des solutions adaptées à tous les budgets. La qualité web ne doit pas être un luxe réservé aux grandes entreprises.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Positionnement Section -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-4xl mx-auto">
      <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl shadow-xl p-8 md:p-12">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-blue-500 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
              <path strokeLinecap="round" strokeLinejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
          </div>
          <h2 class="text-4xl font-black" style="font-family: var(--font-bounded); color: var(--color-black);">
            Notre avantage
          </h2>
        </div>
        <p class="text-lg text-gray-700 leading-relaxed" style="font-family: var(--font-tinos);">
          Nous créons des sites <strong style="color: var(--color-green);">sobres, rapides et durables</strong>, conçus pour minimiser la consommation de ressources tout en offrant une expérience utilisateur fluide. Notre approche allie <strong style="color: var(--color-blue);">performance et responsabilité écologique</strong> pour garantir une présence web efficace et pérenne.
        </p>
        <div class="mt-8 pt-8 border-t border-gray-200">
          <h3 class="text-2xl font-black mb-4" style="font-family: var(--font-bounded); color: var(--color-black);">
            Pour qui ?
          </h3>
          <ul class="space-y-3">
            <li class="flex items-start gap-3">
              <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
              </svg>
              <span style="font-family: var(--font-tinos);">Toute personne ou structure ayant besoin d'un site web de qualité</span>
            </li>
            <li class="flex items-start gap-3">
              <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
              </svg>
              <span style="font-family: var(--font-tinos);">Ceux qui recherchent une solution claire et sans artifice</span>
            </li>
            <li class="flex items-start gap-3">
              <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
              </svg>
              <span style="font-family: var(--font-tinos);">Les entreprises soucieuses de leur empreinte carbone numérique</span>
            </li>
            <li class="flex items-start gap-3">
              <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
              </svg>
              <span style="font-family: var(--font-tinos);">Ceux qui veulent un accompagnement humain et transparent</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Founders Section -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-16">
        <span class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-base font-black mb-4" style="font-family: var(--font-bounded);">
          L'équipe
        </span>
        <h2 class="text-3xl md:text-4xl font-black mb-6" style="color: var(--color-black); font-family: var(--font-bounded);">
          Les fondateurs
        </h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto" style="font-family: var(--font-tinos);">
          Deux Alex passionnés par le web, la performance et l'éco-conception
        </p>
      </div>

      <div id="founders-root"></div>
    </div>
  </section>

  <!-- Culture Section -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-4xl mx-auto">
      <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl p-8 md:p-12">
        <h2 class="text-4xl font-black mb-6 text-center" style="font-family: var(--font-bounded); color: var(--color-black);">
          Notre personnalité
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-green-200 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
              <span class="text-green-700 font-bold">✓</span>
            </div>
            <p class="text-gray-700" style="font-family: var(--font-tinos);">
              <strong>Professionnel</strong>, sans jargon inutile
            </p>
          </div>
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-blue-200 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
              <span class="text-blue-700 font-bold">✓</span>
            </div>
            <p class="text-gray-700" style="font-family: var(--font-tinos);">
              <strong>Sincère et rigoureux</strong>, mais accessible
            </p>
          </div>
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-green-200 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
              <span class="text-green-700 font-bold">✓</span>
            </div>
            <p class="text-gray-700" style="font-family: var(--font-tinos);">
              <strong>Sobres</strong> comme nos sites, solidité technique avant tout
            </p>
          </div>
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-blue-200 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
              <span class="text-blue-700 font-bold">✓</span>
            </div>
            <p class="text-gray-700" style="font-family: var(--font-tinos);">
              <strong>Engagés</strong>, sans greenwashing
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</section>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

<!-- Composant React -->
<script type="text/babel">
const FounderCard = ({ img, name, description, parcours, valeurs, linkedin, instagram, index }) => {
  const [isHovered, setIsHovered] = React.useState(false);

  const isAlexandre = index === 0;
  const accentColor = isAlexandre ? 'green' : 'blue';
  const bgColor = isAlexandre ? 'bg-green-50' : 'bg-blue-50';
  const borderColor = isAlexandre ? 'border-green-200' : 'border-blue-200';
  const textColor = isAlexandre ? 'text-green-600' : 'text-blue-600';

  return (
    <div
      className={`founder-card bg-white rounded-2xl border-2 ${borderColor} p-8 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2`}
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
    >
      <div className="text-center mb-6">
        <div className="relative inline-block mb-4">
          <img
            src={img}
            alt={name}
            className={`w-32 h-32 rounded-full object-cover border-4 ${isAlexandre ? 'border-green-400' : 'border-blue-400'} shadow-lg transition-transform duration-300 ${isHovered ? 'scale-110' : ''}`}
          />
          <div className={`absolute -bottom-2 -right-2 w-12 h-12 ${bgColor} rounded-full flex items-center justify-center border-4 border-white shadow-md`}>
            <svg className={`w-6 h-6 ${textColor}`} fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
              <path strokeLinecap="round" strokeLinejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
            </svg>
          </div>
        </div>
        <h3 className="text-4xl font-black mb-2" style={{ fontFamily: 'var(--font-bounded)', color: `var(--color-${accentColor})` }}>
          {name}
        </h3>
        <p className="text-gray-600 text-base font-black uppercase tracking-wide" style={{ fontFamily: 'var(--font-bounded)' }}>
          {isAlexandre ? 'Front-end Developer' : 'Back-end Developer'}
        </p>
      </div>

      <p
        className="text-gray-700 text-base mb-8 leading-relaxed"
        style={{ fontFamily: 'var(--font-tinos)' }}
        dangerouslySetInnerHTML={{ __html: description }}
      />

      <div className="space-y-6">
        <div className={`${bgColor} rounded-xl p-4`}>
          <div className="flex items-center gap-2 mb-3">
            <svg className={`w-5 h-5 ${textColor}`} fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
              <path strokeLinecap="round" strokeLinejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <strong className="text-base" style={{ fontFamily: 'var(--font-bounded)' }}>Parcours</strong>
          </div>
          <ul className="space-y-1 text-sm text-gray-700" style={{ fontFamily: 'var(--font-tinos)' }}>
            {parcours.map((item, i) => (
              <li key={i} className="flex items-start gap-2">
                <span className={textColor}>•</span>
                <span>{item}</span>
              </li>
            ))}
          </ul>
        </div>

        <div className={`${bgColor} rounded-xl p-4`}>
          <div className="flex items-center gap-2 mb-3">
            <svg className={`w-5 h-5 ${textColor}`} fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
              <path strokeLinecap="round" strokeLinejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <strong className="text-base" style={{ fontFamily: 'var(--font-bounded)' }}>Valeurs</strong>
          </div>
          <ul className="space-y-1 text-sm text-gray-700" style={{ fontFamily: 'var(--font-tinos)' }}>
            {valeurs.map((item, i) => (
              <li key={i} className="flex items-start gap-2">
                <span className={textColor}>•</span>
                <span>{item}</span>
              </li>
            ))}
          </ul>
        </div>
      </div>

      <div className="flex justify-center gap-4 mt-8 pt-6 border-t border-gray-200">
        <a
          href={linkedin}
          target="_blank"
          rel="noopener noreferrer"
          className="w-12 h-12 bg-gray-100 hover:bg-blue-100 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110"
        >
          <svg className="w-5 h-5 text-gray-600 hover:text-blue-600" fill="currentColor" viewBox="0 0 24 24">
            <path d="M16 8a6 6 0 016 6v6h-4v-6a2 2 0 00-4 0v6h-4v-10h4v1.5A4 4 0 0116 8zM2 9h4v12H2zM4 3a2 2 0 110 4 2 2 0 010-4z"/>
          </svg>
        </a>
        <a
          href={instagram}
          target="_blank"
          rel="noopener noreferrer"
          className="w-12 h-12 bg-gray-100 hover:bg-pink-100 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110"
        >
          <svg className="w-5 h-5 text-gray-600 hover:text-pink-600" fill="currentColor" viewBox="0 0 24 24">
            <path d="M7.75 2C5.678 2 4 3.678 4 5.75v12.5C4 20.322 5.678 22 7.75 22h8.5C18.322 22 20 20.322 20 18.25V5.75C20 3.678 18.322 2 16.25 2h-8.5zM12 17.75A5.75 5.75 0 1117.75 12 5.757 5.757 0 0112 17.75zm0-9.5A3.75 3.75 0 1015.75 12 3.754 3.754 0 0012 8.25zM18 6.5a1 1 0 11-1-1 1 1 0 011 1z"/>
          </svg>
        </a>
      </div>
    </div>
  );
};

const FoundersSection = () => {
  const founders = [
    {
      img: "<?= BASE_URL ?>asset/img/alexandre.webp",
      name: "Alexandre",
      description: "Développeur front-end, Alexandre conçoit des interfaces sobres, accessibles et efficaces. Il est à l'origine de l'identité visuelle et de l'expérience utilisateur de <strong style='color: var(--color-green);'>&lt;alex²/&gt;</strong>.",
      parcours: ["Bac STI2D", "BUT MMI", "Projets web sur mesure"],
      valeurs: ["Créativité", "Accessibilité", "Clarté"],
      linkedin: "https://www.linkedin.com/in/alexandre-bouvy-7809a51b7/",
      instagram: "https://www.instagram.com/le_roi_b_tv/"
    },
    {
      img: "<?= BASE_URL ?>asset/img/alexis.webp",
      name: "Alexis",
      description: "Développeur back-end, Alexis s'occupe de l'architecture, des bases de données et de la performance. Il veille à la stabilité et à la sobriété technique de <strong style='color: var(--color-blue);'>&lt;alex²/&gt;</strong>.",
      parcours: ["Bac STI2D", "BUT MMI", "Projets web sur mesure"],
      valeurs: ["Fiabilité", "Efficacité", "Transparence"],
      linkedin: "https://www.linkedin.com/in/alexis-rodrigues-dos-reis-51b008257/",
      instagram: "https://www.instagram.com/alexisrdr_off/"
    }
  ];

  return (
    <div className="grid md:grid-cols-2 gap-8">
      {founders.map((founder, index) => (
        <FounderCard key={index} {...founder} index={index} />
      ))}
    </div>
  );
};

ReactDOM.createRoot(document.getElementById('founders-root')).render(<FoundersSection />);
</script>
</body>
</html>
