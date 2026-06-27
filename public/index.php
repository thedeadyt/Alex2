<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

// Projets pour la homepage (3 derniers avec slug)
$sql = "SELECT id, nom, slug, annee, type, image, images, description_courte, lien FROM projets ORDER BY annee DESC LIMIT 3";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$projetsAccueil = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($projetsAccueil as &$p) {
    $p['images'] = !empty($p['images']) ? json_decode($p['images'], true) : [];
}
unset($p);

// Services
$services = [];
$stmt = $pdo->query("SELECT * FROM services ORDER BY id ASC");
if ($stmt) {
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Nombre total de projets
$nbProjets = $pdo->query("SELECT COUNT(*) FROM projets")->fetchColumn();

// Témoignages clients (actifs uniquement)
$stmtTemoignages = $pdo->query("SELECT * FROM temoignages WHERE actif = 1 ORDER BY date_creation DESC");
$temoignages = $stmtTemoignages->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Développement Web 65 Tarbes Lourdes | Création Site Personnalisé | Alex²</title>
    <link rel="icon" href="./Alex2logo.png" type="image/x-icon">
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='<?= BASE_URL ?>asset/css/index.css?v=6'>
    <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <script>
      if (!sessionStorage.getItem('animation_done')) {
        sessionStorage.setItem('animation_done', 'true');
        window.location.href = "<?= BASE_URL ?>animation";
      }
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-EFTK5TK4MM"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-EFTK5TK4MM');
    </script>
    <meta name="description" content="Développement web 65 : duo de développeurs web spécialisés dans la création de sites personnalisés à Tarbes et Lourdes. Backend PHP, APIs REST, hébergement et maintenance.">
    <meta name="robots" content="index, follow">
    <meta name="author" content="&lt;Alex²/&gt;">
    <meta name="keywords" content="développement web 65, développement web personnalisé 65, création site personnalisé Tarbes, création de site Lourdes, développeur web Tarbes, développeur web Lourdes, agence web Tarbes, agence web Lourdes, développement web Hautes-Pyrénées, backend PHP, API REST, hébergement web 65">
    <link rel="canonical" href="https://alex2.dev/">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="&lt;Alex²/&gt; - Développement Web 65">
    <meta property="og:title" content="Développement Web 65 | Backend PHP & APIs | Tarbes & Lourdes">
    <meta property="og:description" content="Duo de développeurs web experts en backend PHP, APIs REST et hébergement à Tarbes et Lourdes (65). Solutions sur mesure pour votre entreprise.">
    <meta property="og:url" content="https://alex2.dev/">
    <meta property="og:image" content="https://alex2.dev/asset/img/Alex2_logo.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Développement Web 65 | Backend PHP & APIs | Alex²">
    <meta name="twitter:description" content="Duo de développeurs web spécialisés backend PHP, APIs REST et hébergement à Tarbes et Lourdes.">
    <meta name="twitter:image" content="https://alex2.dev/asset/img/Alex2_logo.png">

    <!-- Local Business JSON-LD -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ProfessionalService",
      "@id": "https://alex2.dev/#organization",
      "name": "Alex² - Développement Web 65",
      "alternateName": ["Alex2", "Alex Carré", "Alex2.dev"],
      "image": "https://alex2.dev/Alex2logo.png",
      "url": "https://alex2.dev",
      "telephone": ["+33768882766", "+33686825714"],
      "priceRange": "€€",
      "address": [
        {"@type": "PostalAddress", "streetAddress": "8 Rue Charles Baudelaire", "addressLocality": "Lourdes", "postalCode": "65100", "addressCountry": "FR"},
        {"@type": "PostalAddress", "streetAddress": "8 Rue Georges Lassalle", "addressLocality": "Tarbes", "postalCode": "65000", "addressCountry": "FR"}
      ],
      "geo": [
        {"@type": "GeoCoordinates", "latitude": 43.0956, "longitude": 0.0475},
        {"@type": "GeoCoordinates", "latitude": 43.2330, "longitude": 0.0660}
      ],
      "sameAs": ["https://www.instagram.com/alex2.dev", "https://www.linkedin.com/company/alex2", "https://github.com/Alex2-dev"],
      "description": "Duo de développeurs web experts basés à Tarbes et Lourdes (65). Spécialistes en backend PHP, APIs REST, hébergement et solutions digitales sur mesure.",
      "foundingDate": "2024",
      "email": "contact@alex2.dev",
      "openingHoursSpecification": [{"@type": "OpeningHoursSpecification", "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"], "opens": "09:00", "closes": "18:00"}],
      "areaServed": [{"@type": "City", "name": "Tarbes"}, {"@type": "City", "name": "Lourdes"}, {"@type": "State", "name": "Hautes-Pyrénées"}],
      "makesOffer": [
        {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Développement Backend PHP", "description": "Applications web robustes et APIs performantes"}},
        {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "APIs REST", "description": "Conception et développement d'APIs RESTful"}},
        {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Hébergement & Infrastructure", "description": "Déploiement, serveurs et maintenance technique"}}
      ]
    }
    </script>
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">
  <?php include __DIR__ . '/../includes/header.php'; ?>

  <section id="content">

    <!-- HERO -->
    <section class="relative overflow-hidden" style="background-color: var(--color-white);">
      <div class="px-6 py-20 mx-auto max-w-7xl md:py-28">
        <div class="grid items-center gap-12 md:grid-cols-2">
          <div class="space-y-8 animate-fade-in-up">
            <div>
              <span class="inline-flex items-center px-3 py-1 mb-6 text-base font-black rounded-full" style="background: #dcfce7; color: #166534; font-family: var(--font-bounded);">
                Agence Web · Tarbes & Lourdes
              </span>
              <h1 class="text-4xl font-black leading-tight tracking-tight md:text-5xl lg:text-6xl" style="font-family: var(--font-bounded); color: var(--color-black);">
                Développement Web
                <br>
                <span class="text-transparent bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text">
                  sur mesure pour votre entreprise
                </span>
              </h1>
              <p class="mt-6 text-xl leading-relaxed text-gray-600" style="font-family: var(--font-tinos);">
                Spécialistes en <strong>backend PHP</strong>, <strong>APIs REST</strong> et <strong>hébergement</strong>. Nous construisons des solutions web robustes et performantes.
              </p>
            </div>

            <div class="flex flex-col gap-4 sm:flex-row">
              <a href="<?= BASE_URL ?>contact" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-xl font-black transition-all duration-300 hero-cta-primary rounded-xl" style="font-family: var(--font-bounded);">
                Démarrer un projet
                <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
              </a>
              <a href="<?= BASE_URL ?>nos-realisations" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-xl font-black transition-all duration-300 hero-cta-secondary rounded-xl" style="font-family: var(--font-bounded);">
                Voir nos réalisations
              </a>
            </div>

            <div class="flex flex-wrap gap-6 pt-6">
              <div class="flex items-center gap-2">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg" style="background: #dcfce7;">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                  <div class="text-xl font-black" style="font-family: var(--font-bounded); color: #51845C;"><?= $nbProjets ?>+</div>
                  <div class="text-xs text-gray-500" style="font-family: var(--font-tinos);">Projets réalisés</div>
                </div>
              </div>
              <div class="flex items-center gap-2">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg" style="background: #dbeafe;">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                </div>
                <div>
                  <div class="text-xl font-black" style="font-family: var(--font-bounded); color: #2563EB;">100%</div>
                  <div class="text-xs text-gray-500" style="font-family: var(--font-tinos);">Sur mesure</div>
                </div>
              </div>
              <div class="flex items-center gap-2">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg" style="background: #dcfce7;">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                  <div class="text-xl font-black" style="font-family: var(--font-bounded); color: #51845C;">24h</div>
                  <div class="text-xs text-gray-500" style="font-family: var(--font-tinos);">Réponse garantie</div>
                </div>
              </div>
            </div>
          </div>

          <div class="relative hidden animate-fade-in-right md:block">
            <div class="overflow-hidden bg-white border border-gray-200 shadow-xl code-card-hero rounded-2xl">
              <div class="flex items-center gap-2 px-6 py-3 bg-gray-900">
                <div class="flex gap-2">
                  <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                  <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                  <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                </div>
                <div class="ml-4 text-sm text-gray-400" style="font-family: monospace;">alex2.dev</div>
              </div>
              <div class="p-8">
                <pre class="font-mono text-sm leading-relaxed"><span class="text-gray-500">// Notre philosophie</span>
<span class="text-blue-500">const</span> <span class="font-bold text-purple-500">alex2</span> = {
  <span class="text-green-500">stack</span>: [<span class="text-amber-600">"PHP"</span>, <span class="text-amber-600">"React"</span>, <span class="text-amber-600">"MySQL"</span>],
  <span class="text-green-500">valeurs</span>: [
    <span class="text-amber-600">"performance"</span>,
    <span class="text-amber-600">"accessibilité"</span>,
    <span class="text-amber-600">"sur mesure"</span>
  ],
  <span class="text-green-500">lieu</span>: <span class="text-amber-600">"Tarbes & Lourdes"</span>
};</pre>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SERVICES -->
    <section class="px-6 py-20" style="background: var(--color-gray-50);">
      <div class="mx-auto max-w-7xl">
        <div class="mb-16 text-center">
          <span class="mb-4 badge badge-green" style="font-family: var(--font-bounded);">Nos Services</span>
          <h2 class="mb-4 text-3xl font-black md:text-4xl" style="font-family: var(--font-bounded); color: var(--color-black);">
            Ce que nous faisons de mieux
          </h2>
          <p class="max-w-2xl mx-auto text-lg text-gray-600" style="font-family: var(--font-tinos);">
            Des solutions techniques adaptées aux besoins de votre entreprise.
          </p>
        </div>
        <div id="react-services" class="grid grid-cols-1 gap-8 mb-12 sm:grid-cols-2 lg:grid-cols-4"></div>
        <div class="text-center">
          <a href="<?= BASE_URL ?>services" class="inline-flex items-center gap-2 px-8 py-4 text-xl font-black transition-all duration-300 services-cta-btn rounded-xl" style="font-family: var(--font-bounded);">
            Tous nos services
            <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
          </a>
        </div>
      </div>
      <script>window.servicesFromPHP = <?= json_encode($services) ?>;</script>
    </section>

    <!-- PROJETS -->
    <section class="px-6 py-20" style="background-color: var(--color-white);">
      <div class="mx-auto max-w-7xl">
        <div class="mb-16 text-center">
          <span class="mb-4 badge badge-blue" style="font-family: var(--font-bounded);">Portfolio</span>
          <h2 class="mb-4 text-3xl font-black md:text-4xl" style="font-family: var(--font-bounded); color: var(--color-black);">
            Nos dernières réalisations
          </h2>
          <p class="max-w-2xl mx-auto text-lg text-gray-600" style="font-family: var(--font-tinos);">
            Des projets web créés avec passion pour nos clients.
          </p>
        </div>
        <div id="projets-accueil-root" class="mb-12"></div>
        <div class="text-center">
          <a href="<?= BASE_URL ?>nos-realisations" class="inline-flex items-center gap-2 px-8 py-4 text-xl font-black transition-all duration-300 projects-cta-btn rounded-xl" style="font-family: var(--font-bounded);">
            Voir tous nos projets
            <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
          </a>
        </div>
      </div>
      <script>window.projetsAccueil = <?= json_encode($projetsAccueil, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;</script>
    </section>

    <!-- TEMOIGNAGES -->
    <section class="px-6 py-20" style="background: var(--color-gray-50);">
      <script>window.temoignagesFromDB = <?= json_encode($temoignages, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;</script>
      <div class="mx-auto max-w-7xl">
        <div class="mb-16 text-center">
          <span class="mb-4 badge badge-green" style="font-family: var(--font-bounded);">Avis Clients</span>
          <h2 class="mb-4 text-3xl font-black md:text-4xl" style="font-family: var(--font-bounded); color: var(--color-black);">
            Ils nous font confiance
          </h2>
        </div>
        <div id="temoignages-root"></div>
      </div>
    </section>

    <!-- PROCESS -->
    <section class="px-6 py-20" style="background-color: var(--color-white);">
      <div class="max-w-4xl mx-auto">
        <div class="mb-16 text-center">
          <span class="mb-4 badge badge-blue" style="font-family: var(--font-bounded);">Méthodologie</span>
          <h2 class="mb-4 text-3xl font-black md:text-4xl" style="font-family: var(--font-bounded); color: var(--color-black);">
            Comment nous travaillons
          </h2>
          <p class="max-w-2xl mx-auto text-lg text-gray-600" style="font-family: var(--font-tinos);">
            Un processus clair et transparent pour chaque projet.
          </p>
        </div>
        <div id="process-root"></div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="px-6 py-20" style="background: var(--color-gray-50);">
      <div class="max-w-4xl mx-auto">
        <div class="mb-12 text-center">
          <span class="mb-4 badge badge-green" style="font-family: var(--font-bounded);">FAQ</span>
          <h2 class="text-3xl font-black md:text-4xl" style="color: var(--color-black); font-family: var(--font-bounded);">Questions Fréquentes</h2>
        </div>
        <div id="faq-root"></div>
      </div>
    </section>

    <?php include __DIR__ . '/../includes/cta.php'; ?>

  </section>

  <!-- FAQ Schema.org -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      {"@type": "Question", "name": "Comment obtenir un devis pour mon site web ?", "acceptedAnswer": {"@type": "Answer", "text": "Chaque projet est unique ! Nous analysons vos besoins spécifiques pour vous proposer une solution sur mesure. Contactez-nous pour un devis personnalisé et gratuit."}},
      {"@type": "Question", "name": "Intervenez-vous uniquement dans le 65 ?", "acceptedAnswer": {"@type": "Answer", "text": "Non ! Bien que basés à Tarbes et Lourdes, nous intervenons partout en France."}},
      {"@type": "Question", "name": "Pourquoi choisir un développeur web plutôt qu'une plateforme ?", "acceptedAnswer": {"@type": "Answer", "text": "Accompagnement 100% personnalisé, site unique, code optimisé pour la performance et le SEO."}},
      {"@type": "Question", "name": "Proposez-vous le référencement Google (SEO) ?", "acceptedAnswer": {"@type": "Answer", "text": "Absolument ! Tous nos sites sont optimisés pour le SEO dès la conception."}},
      {"@type": "Question", "name": "Quel est le délai de livraison ?", "acceptedAnswer": {"@type": "Answer", "text": "Les délais varient selon la complexité. Nous établissons un planning personnalisé dès le début."}}
    ]
  }
  </script>

  <?php include __DIR__ . '/../includes/footer.php'; ?>

  <!-- REACT COMPONENTS -->
  <script type="text/babel">
    // === PROJECT CARDS (sans modal, avec liens) ===
    const ProjectCard = ({ projet, index }) => {
      const slug = projet.slug || projet.nom.toLowerCase().replace(/\s+/g, '-');
      const tags = projet.type ? projet.type.split(',').map(t => t.trim()).filter(Boolean) : [];
      const gallery = projet.images || [];
      const hasMockup = gallery.length >= 2;
      const displayUrl = projet.lien ? projet.lien.replace(/^https?:\/\//, '').replace(/\/$/, '') : slug + '.alex2.dev';

      return (
        <a
          href={'<?= BASE_URL ?>projets/' + slug}
          className="project-card-modern block no-underline"
          style={{ animationDelay: `${index * 0.15}s` }}
        >
          <div className="project-card-content">
            {/* Browser bar */}
            <div className="project-browser-bar">
              <span className="project-browser-dot project-browser-dot--red" />
              <span className="project-browser-dot project-browser-dot--yellow" />
              <span className="project-browser-dot project-browser-dot--green" />
              <span className="project-browser-url">{displayUrl}</span>
            </div>

            {/* Image viewport */}
            <div className={`project-image-container${hasMockup ? ' has-mockup' : ''}`}>
              <img src={'<?= BASE_URL ?>' + projet.image} alt={projet.nom} className="project-image" />
              {hasMockup && (
                <div className="project-mockup-container">
                  <div className="project-mockup-pc">
                    <div className="project-mockup-pc-bar">
                      <span className="dot dot--r" />
                      <span className="dot dot--y" />
                      <span className="dot dot--g" />
                    </div>
                    <img src={'<?= BASE_URL ?>' + gallery[0].replace(/^\//, '')} alt={projet.nom + ' - Desktop'} />
                  </div>
                  <div className="project-mockup-mobile">
                    <img src={'<?= BASE_URL ?>' + gallery[1].replace(/^\//, '')} alt={projet.nom + ' - Mobile'} />
                  </div>
                </div>
              )}
              {!hasMockup && <div className="project-image-gradient" />}
              <span className="project-year-badge">{projet.annee}</span>
              <div className="project-tags-overlay">
                {tags.map((tag, i) => (
                  <span key={i} className="project-tag">{tag}</span>
                ))}
              </div>
              <div className="project-hover-overlay">
                <span className="project-hover-btn">
                  Voir le projet
                  <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </span>
              </div>
            </div>

            {/* Info panel */}
            <div className="project-info">
              <h3 className="project-title" style={{ fontFamily: 'var(--font-bounded)' }}>{projet.nom}</h3>
              <p className="project-description" style={{ fontFamily: 'var(--font-tinos)' }}>{projet.description_courte}</p>
              <div className="project-footer">
                <span className="project-link-text">
                  Découvrir
                </span>
                <span className="project-link-arrow">
                  <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </span>
              </div>
            </div>
          </div>
        </a>
      );
    };

    const AccueilProjets = () => {
      const projets = window.projetsAccueil || [];
      return (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {projets.map((projet, index) => (
            <ProjectCard key={projet.id} projet={projet} index={index} />
          ))}
        </div>
      );
    };

    ReactDOM.createRoot(document.getElementById("projets-accueil-root")).render(<AccueilProjets />);
  </script>

  <script type="text/babel">
    // === SERVICE CARDS ===
    const ServiceCard = ({ service, index }) => {
      const [isHovered, setIsHovered] = React.useState(false);
      const icons = {
        1: <svg className="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={1.5}><path strokeLinecap="round" strokeLinejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>,
        2: <svg className="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={1.5}><path strokeLinecap="round" strokeLinejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" /></svg>,
        3: <svg className="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={1.5}><path strokeLinecap="round" strokeLinejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>,
        4: <svg className="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={1.5}><path strokeLinecap="round" strokeLinejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" /></svg>
      };
      const colors = ['#51845C', '#2563EB', '#51845C', '#1f2020'];

      return (
        <div className="service-card-modern" style={{ animationDelay: `${index * 0.15}s` }} onMouseEnter={() => setIsHovered(true)} onMouseLeave={() => setIsHovered(false)}>
          <div className="service-card-content">
            <div className="service-icon" style={{ color: colors[index] || '#51845C' }}>{icons[service.id] || icons[1]}</div>
            <h3 className="service-title" style={{ fontFamily: 'var(--font-bounded)' }}>{service.name}</h3>
            <p className="service-description" style={{ fontFamily: 'var(--font-tinos)' }}>{service.line1}</p>
            <div className="service-arrow" style={{ transform: isHovered ? 'translateX(5px)' : 'translateX(0)', opacity: isHovered ? 1 : 0.5 }}>
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </div>
          </div>
        </div>
      );
    };

    const ServicesGrid = () => {
      const services = (window.servicesFromPHP || []).slice(0, 4);
      return <>{services.map((s, i) => <ServiceCard key={s.id} service={s} index={i} />)}</>;
    };

    ReactDOM.createRoot(document.getElementById("react-services")).render(<ServicesGrid />);
  </script>

  <script type="text/babel">
    // === TEMOIGNAGES — Carousel + Formulaire ===
    const { useRef, useCallback } = React;

    const Stars = ({ count, interactive, onChange }) => (
      <div className="flex gap-0.5">
        {[...Array(5)].map((_, i) => (
          <svg
            key={i}
            className={`w-5 h-5 ${i < count ? 'text-amber-400' : 'text-gray-300'} ${interactive ? 'cursor-pointer hover:scale-110 transition-transform' : ''}`}
            fill="currentColor"
            viewBox="0 0 20 20"
            onClick={interactive ? () => onChange(i + 1) : undefined}
          >
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
          </svg>
        ))}
      </div>
    );

    const TemoignageCard = ({ t }) => (
      <div className="testimonial-card" style={{ height: '100%' }}>
        <svg className="w-8 h-8 mb-4" style={{ color: '#51845C', opacity: 0.3 }} fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" /></svg>
        <p className="text-gray-700 mb-4 leading-relaxed" style={{ fontFamily: 'var(--font-tinos)' }}>{t.texte}</p>
        <Stars count={parseInt(t.note) || 5} />
        <div className="mt-3 pt-3" style={{ borderTop: '1px solid #e5e7eb' }}>
          <div className="font-black text-base" style={{ color: '#1f2020', fontFamily: 'var(--font-bounded)' }}>{t.nom}</div>
          {t.entreprise && <div className="text-xs text-gray-500" style={{ fontFamily: 'var(--font-tinos)' }}>{t.entreprise}</div>}
        </div>
      </div>
    );

    const ReviewFormModal = ({ visible, onClose }) => {
      const [form, setForm] = useState({ nom: '', entreprise: '', texte: '', note: 5 });
      const [sending, setSending] = useState(false);
      const [sent, setSent] = useState(false);
      const [error, setError] = useState('');

      if (!visible) return null;

      const handleSubmit = async (e) => {
        e.preventDefault();
        setSending(true);
        setError('');
        try {
          const res = await fetch('<?= BASE_URL ?>api/temoignages.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(form)
          });
          const data = await res.json();
          if (res.ok && data.success) {
            setSent(true);
          } else {
            setError(data.error || 'Une erreur est survenue.');
          }
        } catch {
          setError('Erreur réseau. Réessayez plus tard.');
        }
        setSending(false);
      };

      return (
        <div className="fixed inset-0 bg-black/60 backdrop-blur-sm flex justify-center items-center z-50 px-4" onClick={onClose}>
          <div className="bg-white rounded-2xl w-full max-w-md p-8 shadow-2xl" onClick={e => e.stopPropagation()}>
            {sent ? (
              <div className="text-center py-8">
                <div className="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style={{ background: '#dcfce7' }}>
                  <svg className="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" /></svg>
                </div>
                <h3 className="text-2xl font-black mb-2" style={{ fontFamily: 'var(--font-bounded)' }}>Merci !</h3>
                <p className="text-gray-600" style={{ fontFamily: 'var(--font-tinos)' }}>
                  Votre avis a bien été envoyé. Il sera publié après validation par notre équipe.
                </p>
                <button onClick={onClose} className="mt-6 px-6 py-2 rounded-xl font-black text-white transition-all hover:-translate-y-0.5" style={{ background: 'linear-gradient(135deg, #51845C, #2563EB)', fontFamily: 'var(--font-bounded)' }}>
                  Fermer
                </button>
              </div>
            ) : (
              <>
                <h3 className="text-3xl font-black mb-6" style={{ fontFamily: 'var(--font-bounded)', color: 'var(--color-black)' }}>
                  Laisser un avis
                </h3>
                <form onSubmit={handleSubmit} className="space-y-4">
                  <div>
                    <label className="block text-base font-black mb-1" style={{ fontFamily: 'var(--font-bounded)' }}>Votre nom *</label>
                    <input
                      type="text"
                      required
                      value={form.nom}
                      onChange={e => setForm({ ...form, nom: e.target.value })}
                      className="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 transition"
                      style={{ fontFamily: 'var(--font-tinos)' }}
                      placeholder="Jean D."
                    />
                  </div>
                  <div>
                    <label className="block text-base font-black mb-1" style={{ fontFamily: 'var(--font-bounded)' }}>Entreprise</label>
                    <input
                      type="text"
                      value={form.entreprise}
                      onChange={e => setForm({ ...form, entreprise: e.target.value })}
                      className="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 transition"
                      style={{ fontFamily: 'var(--font-tinos)' }}
                      placeholder="Mon entreprise (optionnel)"
                    />
                  </div>
                  <div>
                    <label className="block text-base font-black mb-1" style={{ fontFamily: 'var(--font-bounded)' }}>Note</label>
                    <Stars count={form.note} interactive onChange={note => setForm({ ...form, note })} />
                  </div>
                  <div>
                    <label className="block text-base font-black mb-1" style={{ fontFamily: 'var(--font-bounded)' }}>Votre avis *</label>
                    <textarea
                      required
                      minLength={10}
                      rows={4}
                      value={form.texte}
                      onChange={e => setForm({ ...form, texte: e.target.value })}
                      className="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 transition resize-none"
                      style={{ fontFamily: 'var(--font-tinos)' }}
                      placeholder="Partagez votre expérience avec Alex²..."
                    />
                  </div>
                  {error && <p className="text-red-500 text-sm">{error}</p>}
                  <div className="flex gap-3 pt-2">
                    <button type="button" onClick={onClose} className="flex-1 px-4 py-3 rounded-xl font-black border border-gray-300 text-gray-700 hover:bg-gray-50 transition" style={{ fontFamily: 'var(--font-bounded)' }}>
                      Annuler
                    </button>
                    <button type="submit" disabled={sending} className="flex-1 px-4 py-3 rounded-xl font-black text-white transition-all hover:-translate-y-0.5 disabled:opacity-50" style={{ background: 'linear-gradient(135deg, #51845C, #2563EB)', fontFamily: 'var(--font-bounded)' }}>
                      {sending ? 'Envoi...' : 'Envoyer'}
                    </button>
                  </div>
                </form>
              </>
            )}
          </div>
        </div>
      );
    };

    const Temoignages = () => {
      const temoignages = window.temoignagesFromDB || [];
      const [currentIndex, setCurrentIndex] = useState(0);
      const [showForm, setShowForm] = useState(false);
      const autoPlayRef = useRef(null);
      const isCarousel = temoignages.length > 3;

      // Number of visible cards
      const visibleCount = 3;
      const maxIndex = Math.max(0, temoignages.length - visibleCount);

      const goTo = useCallback((idx) => {
        setCurrentIndex(Math.max(0, Math.min(idx, maxIndex)));
      }, [maxIndex]);

      const next = useCallback(() => {
        setCurrentIndex(prev => prev >= maxIndex ? 0 : prev + 1);
      }, [maxIndex]);

      const prev = useCallback(() => {
        setCurrentIndex(prev => prev <= 0 ? maxIndex : prev - 1);
      }, [maxIndex]);

      // Auto-play carousel
      React.useEffect(() => {
        if (!isCarousel) return;
        autoPlayRef.current = setInterval(next, 5000);
        return () => clearInterval(autoPlayRef.current);
      }, [isCarousel, next]);

      const pauseAutoPlay = () => clearInterval(autoPlayRef.current);
      const resumeAutoPlay = () => {
        if (!isCarousel) return;
        autoPlayRef.current = setInterval(next, 5000);
      };

      if (temoignages.length === 0) {
        return (
          <div className="text-center py-8">
            <p className="text-gray-500 mb-6" style={{ fontFamily: 'var(--font-tinos)' }}>Aucun avis pour le moment.</p>
            <button onClick={() => setShowForm(true)} className="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-black text-white transition-all hover:-translate-y-0.5" style={{ background: 'linear-gradient(135deg, #51845C, #2563EB)', fontFamily: 'var(--font-bounded)' }}>
              Soyez le premier
            </button>
            <ReviewFormModal visible={showForm} onClose={() => setShowForm(false)} />
          </div>
        );
      }

      return (
        <>
          {isCarousel ? (
            <div
              className="relative"
              onMouseEnter={pauseAutoPlay}
              onMouseLeave={resumeAutoPlay}
            >
              {/* Carousel container */}
              <div className="overflow-hidden" style={{ margin: '0 -1rem' }}>
                <div
                  className="flex transition-transform duration-500 ease-in-out"
                  style={{ transform: `translateX(-${currentIndex * (100 / visibleCount)}%)` }}
                >
                  {temoignages.map((t, i) => (
                    <div key={t.id || i} className="flex-shrink-0 px-4" style={{ width: `${100 / visibleCount}%` }}>
                      <TemoignageCard t={t} />
                    </div>
                  ))}
                </div>
              </div>

              {/* Navigation arrows */}
              <button
                onClick={() => { prev(); pauseAutoPlay(); }}
                className="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 w-10 h-10 rounded-full bg-white shadow-lg flex items-center justify-center hover:scale-110 transition-transform border border-gray-200"
                style={{ color: '#51845C' }}
              >
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M15 19l-7-7 7-7" /></svg>
              </button>
              <button
                onClick={() => { next(); pauseAutoPlay(); }}
                className="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 w-10 h-10 rounded-full bg-white shadow-lg flex items-center justify-center hover:scale-110 transition-transform border border-gray-200"
                style={{ color: '#51845C' }}
              >
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M9 5l7 7-7 7" /></svg>
              </button>

              {/* Dots indicator */}
              <div className="flex justify-center gap-2 mt-8">
                {Array.from({ length: maxIndex + 1 }).map((_, i) => (
                  <button
                    key={i}
                    onClick={() => { goTo(i); pauseAutoPlay(); }}
                    className="w-2.5 h-2.5 rounded-full transition-all duration-300"
                    style={{
                      background: i === currentIndex ? '#51845C' : '#d1d5db',
                      transform: i === currentIndex ? 'scale(1.3)' : 'scale(1)'
                    }}
                  />
                ))}
              </div>
            </div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
              {temoignages.map((t, i) => (
                <TemoignageCard key={t.id || i} t={t} />
              ))}
            </div>
          )}

          {/* Bouton "Laisser un avis" */}
          <div className="text-center mt-12">
            <button
              onClick={() => setShowForm(true)}
              className="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 hover:-translate-y-1"
              style={{ color: '#51845C', border: '2px solid #51845C', fontFamily: 'var(--font-bounded)', background: 'rgba(81,132,92,0.05)' }}
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
              Laisser un avis
            </button>
          </div>

          <ReviewFormModal visible={showForm} onClose={() => setShowForm(false)} />
        </>
      );
    };

    ReactDOM.createRoot(document.getElementById("temoignages-root")).render(<Temoignages />);
  </script>

  <script type="text/babel">
    // === PROCESS ===
    const Process = () => {
      const steps = [
        { num: "01", title: "Écoute", desc: "Nous analysons vos besoins, votre marché et vos objectifs lors d'un échange approfondi." },
        { num: "02", title: "Conception", desc: "Nous concevons l'architecture technique et les maquettes adaptées à votre projet." },
        { num: "03", title: "Développement", desc: "Code propre, performant et testé. Vous suivez l'avancement en temps réel." },
        { num: "04", title: "Livraison", desc: "Déploiement, formation et accompagnement. Votre projet est entre de bonnes mains." }
      ];

      return (
        <div className="space-y-8">
          {steps.map((step, i) => (
            <div key={i} className="process-step flex gap-6 items-start">
              <div>
                <div className="process-step-number">{step.num}</div>
                {i < steps.length - 1 && <div className="process-connector"></div>}
              </div>
              <div className="pb-8">
                <h3 className="text-2xl font-black mb-2" style={{ fontFamily: 'var(--font-bounded)', color: '#1f2020' }}>{step.title}</h3>
                <p className="text-gray-600" style={{ fontFamily: 'var(--font-tinos)' }}>{step.desc}</p>
              </div>
            </div>
          ))}
        </div>
      );
    };

    ReactDOM.createRoot(document.getElementById("process-root")).render(<Process />);
  </script>

  <script type="text/babel">
    // === FAQ ===
    const FAQItem = ({ question, answer, isOpen, onClick, index }) => {
      const isGreen = index % 2 === 0;
      return (
        <div className={`faq-card bg-white p-6 rounded-2xl border-2 ${isOpen ? (isGreen ? 'border-green-200' : 'border-blue-200') : 'border-gray-100'} transition-all duration-300 cursor-pointer ${isOpen ? 'shadow-lg' : 'hover:shadow-md'}`} onClick={onClick}>
          <div className="flex items-center justify-between">
            <h3 className="font-black text-xl pr-4" style={{ fontFamily: 'var(--font-bounded)', color: '#1f2020' }}>{question}</h3>
            <svg className={`w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-300 ${isOpen ? 'rotate-180' : ''}`} fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" /></svg>
          </div>
          <div className={`overflow-hidden transition-all duration-300 ${isOpen ? 'max-h-96 opacity-100 mt-4' : 'max-h-0 opacity-0'}`}>
            <p className="text-gray-600 leading-relaxed" style={{ fontFamily: 'var(--font-tinos)' }} dangerouslySetInnerHTML={{ __html: answer }} />
          </div>
        </div>
      );
    };

    const FAQ = () => {
      const [openIndex, setOpenIndex] = React.useState(null);
      const faqs = [
        { question: "Comment obtenir un devis ?", answer: 'Chaque projet est unique ! <a href="<?= BASE_URL ?>contact" style="color: #51845C; text-decoration: underline;">Contactez-nous</a> pour un devis personnalisé et gratuit, sans engagement.' },
        { question: "Intervenez-vous uniquement dans le 65 ?", answer: 'Non ! Bien que basés à <strong>Tarbes et Lourdes</strong>, nous intervenons <strong>partout en France</strong>.' },
        { question: "Pourquoi choisir un développeur plutôt qu'une plateforme ?", answer: 'Accompagnement 100% personnalisé, site unique, code optimisé pour la <strong>performance et le SEO</strong>.' },
        { question: "Proposez-vous le référencement Google ?", answer: 'Absolument ! Tous nos sites sont <strong>optimisés pour le SEO</strong> dès la conception.' },
        { question: "Quel est le délai de livraison ?", answer: 'Les délais varient selon la complexité. Nous établissons un <strong>planning personnalisé</strong> dès le début.' }
      ];
      return (
        <div className="space-y-4">
          {faqs.map((faq, i) => <FAQItem key={i} question={faq.question} answer={faq.answer} isOpen={openIndex === i} onClick={() => setOpenIndex(openIndex === i ? null : i)} index={i} />)}
        </div>
      );
    };

    ReactDOM.createRoot(document.getElementById("faq-root")).render(<FAQ />);
  </script>
</body>
</html>
