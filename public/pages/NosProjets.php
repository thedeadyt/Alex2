<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

$sql = "SELECT id, nom, slug, annee, type, image, images, description_courte, description_detaillee, lien FROM projets ORDER BY annee DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($projets as &$p) {
    $p['images'] = !empty($p['images']) ? json_decode($p['images'], true) : [];
}
unset($p);

// Extraire les types uniques pour les filtres
$types = [];
foreach ($projets as $p) {
    foreach (array_map('trim', explode(',', $p['type'])) as $t) {
        if ($t && !in_array($t, $types)) $types[] = $t;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nos Réalisations | &lt;Alex²/&gt;</title>
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

  <script>
    window.projetsFromPHP = <?= json_encode($projets, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    window.typesFromPHP = <?= json_encode($types, JSON_UNESCAPED_UNICODE) ?>;
  </script>

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-EFTK5TK4MM"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-EFTK5TK4MM');
  </script>

  <meta name="description" content="Découvrez les projets réalisés par Alex², agence web à Tarbes et Lourdes (65) : sites vitrines, applications web et solutions backend sur mesure.">
  <link rel="canonical" href="https://alex2.dev/nos-realisations">
  <meta property="og:title" content="Nos Réalisations | Alex² - Développement web 65">
  <meta property="og:description" content="Explorez les projets web réalisés par Alex² dans les Hautes-Pyrénées : sites modernes et performants.">
  <meta property="og:url" content="https://alex2.dev/nos-realisations">
  <meta name="twitter:title" content="Nos Réalisations | Alex² - Développement web 65">
  <meta name="twitter:description" content="Découvrez les réalisations web d'Alex² : sites vitrines et solutions sur mesure à Tarbes et Lourdes (65).">
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">
  <?php include __DIR__ . '/../../includes/header.php'; ?>

  <section id="content">
    <!-- Hero -->
    <section class="py-20 px-6" style="background-color: var(--color-white);">
      <div class="max-w-7xl mx-auto text-center">
        <span class="badge badge-green mb-4" style="font-family: var(--font-bounded);">Portfolio</span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6" style="font-family: var(--font-bounded); color: var(--color-black);">
          Nos <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">Réalisations</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto mb-8" style="font-family: var(--font-tinos);">
          Découvrez les projets web que nous avons créés avec passion pour nos clients des <strong>Hautes-Pyrénées</strong> et d'ailleurs.
        </p>
        <div class="flex justify-center gap-8 mt-10">
          <div class="text-center">
            <div class="text-4xl font-black" style="font-family: var(--font-bounded); color: #51845C;">
              <?= count($projets) ?>+
            </div>
            <div class="text-sm text-gray-600" style="font-family: var(--font-tinos);">Projets réalisés</div>
          </div>
          <div class="text-center">
            <div class="text-4xl font-black" style="font-family: var(--font-bounded); color: #2563EB;">100%</div>
            <div class="text-sm text-gray-600" style="font-family: var(--font-tinos);">Sur mesure</div>
          </div>
          <div class="text-center">
            <div class="text-4xl font-black" style="font-family: var(--font-bounded); color: #51845C;">65</div>
            <div class="text-sm text-gray-600" style="font-family: var(--font-tinos);">Hautes-Pyrénées</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Projects Grid -->
    <section class="py-20 px-6" style="background: var(--color-gray-50);">
      <div id="projets-root" class="max-w-7xl mx-auto"></div>
    </section>

    <?php include __DIR__ . '/../../includes/cta.php'; ?>
  </section>

  <?php include __DIR__ . '/../../includes/footer.php'; ?>

  <script type="text/babel">
    const BASE = "<?= BASE_URL ?>";
    const { useState } = React;

    const ProjectCard = ({ projet, index }) => {
      const slug = projet.slug || projet.nom.toLowerCase().replace(/\s+/g, '-');
      const tags = projet.type ? projet.type.split(',').map(t => t.trim()).filter(Boolean) : [];
      const gallery = projet.images || [];
      const hasMockup = gallery.length >= 2;
      const displayUrl = projet.lien ? projet.lien.replace(/^https?:\/\//, '').replace(/\/$/, '') : slug + '.alex2.dev';

      return (
        <a
          href={BASE + 'projets/' + slug}
          className="project-card-modern block no-underline"
          style={{ animationDelay: `${index * 0.1}s` }}
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
              <img src={BASE + projet.image} alt={projet.nom} className="project-image" />
              {hasMockup && (
                <div className="project-mockup-container">
                  <div className="project-mockup-pc">
                    <div className="project-mockup-pc-bar">
                      <span className="dot dot--r" />
                      <span className="dot dot--y" />
                      <span className="dot dot--g" />
                    </div>
                    <img src={BASE + gallery[0].replace(/^\//, '')} alt={projet.nom + ' - Desktop'} />
                  </div>
                  <div className="project-mockup-mobile">
                    <img src={BASE + gallery[1].replace(/^\//, '')} alt={projet.nom + ' - Mobile'} />
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

    const ProjectsGrid = () => {
      const [projets] = useState(window.projetsFromPHP || []);
      const [types] = useState(window.typesFromPHP || []);
      const [activeFilter, setActiveFilter] = useState('Tous');

      const filtered = activeFilter === 'Tous'
        ? projets
        : projets.filter(p => p.type.toLowerCase().includes(activeFilter.toLowerCase()));

      return (
        <>
          {/* Filtres */}
          <div className="flex flex-wrap justify-center gap-3 mb-12">
            <button
              onClick={() => setActiveFilter('Tous')}
              className={`filter-btn ${activeFilter === 'Tous' ? 'active' : ''}`}
              style={{ fontFamily: 'var(--font-bounded)' }}
            >
              Tous
            </button>
            {types.map(type => (
              <button
                key={type}
                onClick={() => setActiveFilter(type)}
                className={`filter-btn ${activeFilter === type ? 'active' : ''}`}
                style={{ fontFamily: 'var(--font-bounded)' }}
              >
                {type}
              </button>
            ))}
          </div>

          <p className="text-center text-gray-600 mb-8" style={{ fontFamily: 'var(--font-tinos)' }}>
            {filtered.length} projet{filtered.length > 1 ? 's' : ''} trouvé{filtered.length > 1 ? 's' : ''}
          </p>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {filtered.map((projet, index) => (
              <ProjectCard key={projet.id} projet={projet} index={index} />
            ))}
          </div>

          {filtered.length === 0 && (
            <div className="text-center py-16">
              <p className="text-xl text-gray-500" style={{ fontFamily: 'var(--font-tinos)' }}>
                Aucun projet dans cette catégorie pour le moment.
              </p>
            </div>
          )}
        </>
      );
    };

    ReactDOM.createRoot(document.getElementById('projets-root')).render(<ProjectsGrid />);
  </script>
</body>
</html>
