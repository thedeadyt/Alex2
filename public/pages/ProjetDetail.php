<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: ' . BASE_URL . 'nos-realisations');
    exit;
}

$stmt = $pdo->prepare("SELECT id, nom, slug, annee, type, image, images, description_courte, description_detaillee, lien FROM projets WHERE slug = ?");
$stmt->execute([$slug]);
$projet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$projet) {
    header('HTTP/1.0 404 Not Found');
    include __DIR__ . '/404.php';
    exit;
}

$projet['images'] = !empty($projet['images']) ? json_decode($projet['images'], true) : [];

// Projets similaires (autres projets)
$stmtSimilaires = $pdo->prepare("SELECT id, nom, slug, annee, type, image, images, description_courte FROM projets WHERE id != ? ORDER BY annee DESC LIMIT 3");
$stmtSimilaires->execute([$projet['id']]);
$projetsSimilaires = $stmtSimilaires->fetchAll(PDO::FETCH_ASSOC);
foreach ($projetsSimilaires as &$ps) {
    $ps['images'] = !empty($ps['images']) ? json_decode($ps['images'], true) : [];
}
unset($ps);

$tags = array_map('trim', explode(',', $projet['type']));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($projet['nom']) ?> | Projet &lt;Alex²/&gt;</title>
    <link rel="icon" href="<?= BASE_URL ?>Alex2logo.png" type="image/x-icon">
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
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/index.css?v=6">
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

    <meta name="description" content="<?= htmlspecialchars($projet['description_courte']) ?>">
    <link rel="canonical" href="https://alex2.dev/projets/<?= htmlspecialchars($projet['slug']) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($projet['nom']) ?> | Alex²">
    <meta property="og:description" content="<?= htmlspecialchars($projet['description_courte']) ?>">
    <meta property="og:url" content="https://alex2.dev/projets/<?= htmlspecialchars($projet['slug']) ?>">
    <meta property="og:image" content="https://alex2.dev/<?= htmlspecialchars($projet['image']) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($projet['nom']) ?> | Alex²">
    <meta name="twitter:description" content="<?= htmlspecialchars($projet['description_courte']) ?>">

    <script>
      window.projetData = <?= json_encode($projet, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
      window.projetsSimilaires = <?= json_encode($projetsSimilaires, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
      window.projetTags = <?= json_encode($tags, JSON_UNESCAPED_UNICODE) ?>;
    </script>
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">
  <?php include __DIR__ . '/../../includes/header.php'; ?>

  <section id="content">
    <div id="projet-detail-root"></div>
  </section>

  <?php include __DIR__ . '/../../includes/footer.php'; ?>

  <script type="text/babel">
    const BASE = "<?= BASE_URL ?>";
    const projet = window.projetData;
    const similaires = window.projetsSimilaires || [];
    const tags = window.projetTags || [];
    const gallery = projet.images || [];

    function ProjetDetail() {
      return (
        <>
          {/* Back Navigation */}
          <div className="max-w-7xl mx-auto px-6 pt-8">
            <a href={BASE + "nos-realisations"} className="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors duration-200" style={{ fontFamily: "var(--font-tinos)" }}>
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
              Retour aux projets
            </a>
          </div>

          {/* Hero */}
          <section className="py-12 px-6">
            <div className="max-w-7xl mx-auto">
              <div className="grid md:grid-cols-2 gap-12 items-center">
                <div className="space-y-6">
                  <div className="flex flex-wrap gap-2">
                    {tags.map((tag, i) => (
                      <span key={i} className="badge badge-green" style={{ fontFamily: "var(--font-bounded)" }}>{tag}</span>
                    ))}
                    <span className="badge badge-blue" style={{ fontFamily: "var(--font-bounded)" }}>{projet.annee}</span>
                  </div>
                  <h1 className="text-4xl md:text-5xl font-black" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
                    {projet.nom}
                  </h1>
                  <p className="text-xl text-gray-600 leading-relaxed" style={{ fontFamily: "var(--font-tinos)" }}>
                    {projet.description_courte}
                  </p>
                  {projet.lien && (
                    <a
                      href={projet.lien}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-semibold transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                      style={{ background: "linear-gradient(135deg, #51845C, #2563EB)", fontFamily: "var(--font-bounded)" }}
                    >
                      Visiter le site
                      <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    </a>
                  )}
                </div>
                <div className="relative">
                  <div className="rounded-2xl overflow-hidden shadow-xl border border-gray-200">
                    <img
                      src={BASE + projet.image}
                      alt={projet.nom}
                      className="w-full h-auto object-cover"
                      style={{ maxHeight: "450px" }}
                    />
                  </div>
                </div>
              </div>
            </div>
          </section>

          {/* Description détaillée */}
          <section className="py-16 px-6" style={{ background: "var(--color-gray-50)" }}>
            <div className="max-w-4xl mx-auto">
              <div className="text-center mb-12">
                <span className="badge badge-green mb-4" style={{ fontFamily: "var(--font-bounded)" }}>Le projet</span>
                <h2 className="text-4xl font-black" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
                  À propos de ce projet
                </h2>
              </div>
              <div className="bg-white rounded-2xl p-8 md:p-12 shadow-sm border border-gray-100">
                <p className="text-lg text-gray-700 leading-relaxed whitespace-pre-line" style={{ fontFamily: "var(--font-tinos)" }}>
                  {projet.description_detaillee || projet.description_courte}
                </p>
              </div>

              {/* Galerie mockups */}
              {gallery.length > 0 && (
                <div className="mt-16">
                  <div className="text-center mb-10">
                    <span className="badge badge-blue mb-4" style={{ fontFamily: "var(--font-bounded)" }}>Aperçu</span>
                    <h2 className="text-4xl font-black" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
                      Captures d'écran
                    </h2>
                  </div>
                  {gallery.length >= 2 ? (
                    <div className="flex items-end justify-center gap-6" style={{ perspective: "1000px" }}>
                      <div className="relative" style={{ width: "65%", maxWidth: "700px" }}>
                        <div className="bg-gray-900 rounded-t-xl p-2 pb-0 shadow-2xl">
                          <div className="flex items-center gap-1.5 px-2 pb-2">
                            <span className="w-2.5 h-2.5 rounded-full bg-red-400" />
                            <span className="w-2.5 h-2.5 rounded-full bg-yellow-400" />
                            <span className="w-2.5 h-2.5 rounded-full bg-green-400" />
                          </div>
                          <img src={BASE + gallery[0].replace(/^\//, '')} alt="Desktop" className="w-full rounded-t" />
                        </div>
                        <div className="bg-gray-700 h-4 rounded-b-lg mx-8" />
                        <div className="bg-gray-600 h-2 rounded-b-lg mx-16" />
                      </div>
                      <div className="relative" style={{ width: "18%", maxWidth: "150px", marginBottom: "8px" }}>
                        <div className="bg-gray-900 rounded-2xl p-1.5 pb-0 shadow-2xl">
                          <div className="w-8 h-1 bg-gray-700 rounded-full mx-auto mb-1" />
                          <img src={BASE + gallery[1].replace(/^\//, '')} alt="Mobile" className="w-full rounded-lg rounded-b-none" />
                        </div>
                        <div className="bg-gray-900 h-6 rounded-b-2xl flex items-center justify-center">
                          <div className="w-8 h-1 bg-gray-700 rounded-full" />
                        </div>
                      </div>
                    </div>
                  ) : (
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      {gallery.map((img, i) => (
                        <div key={i} className="rounded-2xl overflow-hidden shadow-lg border border-gray-200">
                          <img src={BASE + img.replace(/^\//, '')} alt={`Capture ${i + 1}`} className="w-full h-auto" />
                        </div>
                      ))}
                    </div>
                  )}
                </div>
              )}
            </div>
          </section>

          {/* Stack technique */}
          <section className="py-16 px-6" style={{ background: "var(--color-white)" }}>
            <div className="max-w-4xl mx-auto">
              <div className="text-center mb-12">
                <span className="badge badge-blue mb-4" style={{ fontFamily: "var(--font-bounded)" }}>Technologies</span>
                <h2 className="text-4xl font-black" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
                  Stack technique
                </h2>
              </div>
              <div className="flex flex-wrap justify-center gap-4">
                {tags.map((tag, i) => (
                  <div key={i} className="bg-white rounded-xl px-6 py-4 shadow-sm border border-gray-200 flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                    <div className="w-10 h-10 rounded-lg flex items-center justify-center" style={{ background: i % 2 === 0 ? "#dcfce7" : "#dbeafe" }}>
                      <svg className="w-5 h-5" fill="none" stroke={i % 2 === 0 ? "#51845C" : "#2563EB"} viewBox="0 0 24 24" strokeWidth={2}>
                        <path strokeLinecap="round" strokeLinejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                      </svg>
                    </div>
                    <span className="font-black" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>{tag}</span>
                  </div>
                ))}
              </div>
            </div>
          </section>

          {/* Projets similaires */}
          {similaires.length > 0 && (
            <section className="py-16 px-6" style={{ background: "var(--color-gray-50)" }}>
              <div className="max-w-7xl mx-auto">
                <div className="text-center mb-12">
                  <span className="badge badge-green mb-4" style={{ fontFamily: "var(--font-bounded)" }}>Portfolio</span>
                  <h2 className="text-4xl font-black" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
                    Autres réalisations
                  </h2>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                  {similaires.map((p, i) => {
                    const pSlug = p.slug || p.nom.toLowerCase().replace(/\s+/g, '-');
                    return (
                      <a key={p.id} href={BASE + "projets/" + pSlug} className="project-card-modern block no-underline">
                        <div className="project-card-content">
                          <div className="project-image-container">
                            <img src={BASE + p.image} alt={p.nom} className="project-image" />
                            <div className="project-overlay">
                              <div className="project-view-btn">
                                <svg className="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <span>Voir le projet</span>
                              </div>
                            </div>
                          </div>
                          <div className="project-info">
                            <div className="project-meta">
                              <span className="project-year">{p.annee}</span>
                              <span className="project-dot">•</span>
                              <span className="project-type">{p.type}</span>
                            </div>
                            <h3 className="project-title" style={{ fontFamily: "var(--font-bounded)" }}>{p.nom}</h3>
                            <p className="project-description" style={{ fontFamily: "var(--font-tinos)" }}>{p.description_courte}</p>
                          </div>
                        </div>
                      </a>
                    );
                  })}
                </div>
              </div>
            </section>
          )}

          {/* CTA — Modern Terminal Style */}
          <section className="relative overflow-hidden py-24 px-6" style={{ background: "#0a0a0a" }}>
            {/* Grid background */}
            <div className="absolute inset-0 opacity-[0.04]" style={{ backgroundImage: "linear-gradient(rgba(81,132,92,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(81,132,92,.5) 1px, transparent 1px)", backgroundSize: "40px 40px" }} />
            {/* Glow orbs */}
            <div className="absolute top-0 left-1/4 w-72 h-72 rounded-full opacity-20 blur-3xl pointer-events-none" style={{ background: "radial-gradient(circle, #51845C, transparent)" }} />
            <div className="absolute bottom-0 right-1/4 w-72 h-72 rounded-full opacity-15 blur-3xl pointer-events-none" style={{ background: "radial-gradient(circle, #2563EB, transparent)" }} />

            <div className="relative max-w-4xl mx-auto text-center">
              {/* Terminal prompt badge */}
              <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-8" style={{ background: "rgba(81,132,92,0.1)", border: "1px solid rgba(81,132,92,0.25)" }}>
                <span className="w-2 h-2 rounded-full animate-pulse" style={{ background: "#51845C", boxShadow: "0 0 8px #51845C" }} />
                <code className="text-sm" style={{ color: "#51845C", fontFamily: "monospace" }}>~/projet$ ready_to_start</code>
              </div>

              <h2 className="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 leading-tight" style={{ fontFamily: "var(--font-bounded)" }}>
                Transformons votre idée<br />
                <span className="bg-gradient-to-r from-green-400 to-blue-500 bg-clip-text text-transparent">en réalité.</span>
              </h2>
              <p className="text-xl text-gray-400 max-w-2xl mx-auto mb-10" style={{ fontFamily: "var(--font-tinos)" }}>
                Un café, une idée, un site. Devis gratuit sous 48h — à Tarbes, Lourdes ou en visio.
              </p>

              {/* CTA buttons */}
              <div className="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
                <a href={BASE + "contact"} className="group inline-flex items-center gap-3 px-8 py-4 rounded-xl font-black text-xl text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl" style={{ background: "linear-gradient(135deg, #51845C 0%, #2563EB 100%)", fontFamily: "var(--font-bounded)", boxShadow: "0 8px 32px rgba(81,132,92,0.3)" }}>
                  Démarrer un projet
                  <svg className="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </a>
                <a href={BASE + "nos-realisations"} className="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-black text-xl transition-all duration-300 hover:-translate-y-1" style={{ color: "#e5e7eb", border: "1px solid rgba(255,255,255,0.15)", fontFamily: "var(--font-bounded)", background: "rgba(255,255,255,0.03)" }}>
                  Voir nos projets
                </a>
              </div>

              {/* Trust badges */}
              <div className="flex flex-wrap justify-center gap-8 text-gray-500" style={{ fontFamily: "var(--font-tinos)" }}>
                <div className="flex items-center gap-2">
                  <svg className="w-4 h-4" style={{ color: "#51845C" }} fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" /></svg>
                  <span className="text-sm">Devis gratuit</span>
                </div>
                <div className="flex items-center gap-2">
                  <svg className="w-4 h-4" style={{ color: "#51845C" }} fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" /></svg>
                  <span className="text-sm">100% sur mesure</span>
                </div>
                <div className="flex items-center gap-2">
                  <svg className="w-4 h-4" style={{ color: "#51845C" }} fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" /></svg>
                  <span className="text-sm">Réponse sous 24h</span>
                </div>
              </div>
            </div>
          </section>
        </>
      );
    }

    ReactDOM.createRoot(document.getElementById("projet-detail-root")).render(<ProjetDetail />);
  </script>
</body>
</html>
