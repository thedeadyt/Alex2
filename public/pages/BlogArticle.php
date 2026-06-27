<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: ' . BASE_URL . 'blog');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM blog WHERE slug = ? AND publie = TRUE");
$stmt->execute([$slug]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    header('HTTP/1.0 404 Not Found');
    include __DIR__ . '/404.php';
    exit;
}

// Articles similaires (même catégorie, excluant l'article courant)
$stmtSimilaires = $pdo->prepare("SELECT id, titre, slug, categorie, resume, image, date_publication, contenu FROM blog WHERE publie = TRUE AND id != ? AND categorie = ? ORDER BY date_publication DESC LIMIT 3");
$stmtSimilaires->execute([$article['id'], $article['categorie']]);
$articlesSimilaires = $stmtSimilaires->fetchAll(PDO::FETCH_ASSOC);

// Si pas assez d'articles similaires, compléter avec des récents
if (count($articlesSimilaires) < 3) {
    $existingIds = array_merge([$article['id']], array_column($articlesSimilaires, 'id'));
    $placeholders = implode(',', array_fill(0, count($existingIds), '?'));
    $stmtRecents = $pdo->prepare("SELECT id, titre, slug, categorie, resume, image, date_publication, contenu FROM blog WHERE publie = TRUE AND id NOT IN ($placeholders) ORDER BY date_publication DESC LIMIT " . (3 - count($articlesSimilaires)));
    $stmtRecents->execute($existingIds);
    $articlesSimilaires = array_merge($articlesSimilaires, $stmtRecents->fetchAll(PDO::FETCH_ASSOC));
}

// Temps de lecture estimé
$wordCount = str_word_count(strip_tags($article['contenu'] ?? ''));
$readTime = max(1, ceil($wordCount / 200));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($article['titre']) ?> | Blog &lt;Alex²/&gt;</title>
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

    <meta name="description" content="<?= htmlspecialchars($article['resume'] ?? $article['titre']) ?>">
    <link rel="canonical" href="https://alex2.dev/blog/<?= htmlspecialchars($article['slug']) ?>">
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?= htmlspecialchars($article['titre']) ?> | Blog Alex²">
    <meta property="og:description" content="<?= htmlspecialchars($article['resume'] ?? '') ?>">
    <meta property="og:url" content="https://alex2.dev/blog/<?= htmlspecialchars($article['slug']) ?>">
    <?php if (!empty($article['image'])): ?>
    <meta property="og:image" content="https://alex2.dev/<?= ltrim(htmlspecialchars($article['image']), '/') ?>">
    <?php endif; ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($article['titre']) ?> | Blog Alex²">
    <meta name="twitter:description" content="<?= htmlspecialchars($article['resume'] ?? '') ?>">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "headline": <?= json_encode($article['titre']) ?>,
      "description": <?= json_encode($article['resume'] ?? '') ?>,
      "datePublished": <?= json_encode($article['date_publication'] ?? '') ?>,
      "author": {
        "@type": "Organization",
        "name": "Alex²"
      },
      "publisher": {
        "@type": "Organization",
        "name": "Alex²",
        "logo": { "@type": "ImageObject", "url": "https://alex2.dev/Alex2logo.png" }
      }
    }
    </script>

    <script>
      window.articleData = <?= json_encode($article, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>;
      window.articlesSimilaires = <?= json_encode($articlesSimilaires, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>;
      window.readTime = <?= $readTime ?>;
    </script>
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">
  <?php include __DIR__ . '/../../includes/header.php'; ?>

  <section id="content">
    <div id="blog-article-root"></div>
  </section>

  <?php include __DIR__ . '/../../includes/footer.php'; ?>

  <script type="text/babel">
    const BASE = "<?= BASE_URL ?>";
    const article = window.articleData;
    const similaires = window.articlesSimilaires || [];
    const readTime = window.readTime || 1;

    const formatDate = (dateStr) => {
      const date = new Date(dateStr);
      return date.toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' });
    };

    function ShareSection({ slug, titre }) {
      const { useState } = React;
      const [copied, setCopied] = useState(false);
      const articleUrl = `https://alex2.dev/blog/${slug}`;
      const encodedUrl = encodeURIComponent(articleUrl);
      const encodedTitle = encodeURIComponent(titre);

      const copyLink = () => {
        navigator.clipboard.writeText(articleUrl).then(() => {
          setCopied(true);
          setTimeout(() => setCopied(false), 3000);
        });
      };

      return (
        <section className="px-6 pb-12">
          <div className="max-w-4xl mx-auto">
            <div className="border-t border-gray-200 pt-8">
              <p className="text-base text-gray-500 mb-4" style={{ fontFamily: "var(--font-bounded)" }}>Partager cet article</p>
              <div className="flex flex-wrap items-center gap-3">
                {/* Facebook */}
                <a
                  href={`https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 hover:scale-105 hover:shadow-md"
                  style={{ background: "#1877F2", color: "white", fontFamily: "var(--font-bounded)" }}
                >
                  <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                  Facebook
                </a>
                {/* LinkedIn */}
                <a
                  href={`https://www.linkedin.com/sharing/share-offsite/?url=${encodedUrl}`}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 hover:scale-105 hover:shadow-md"
                  style={{ background: "#0A66C2", color: "white", fontFamily: "var(--font-bounded)" }}
                >
                  <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                  LinkedIn
                </a>
                {/* Instagram — copie le lien */}
                <button
                  onClick={copyLink}
                  className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 hover:scale-105 hover:shadow-md cursor-pointer"
                  style={{ background: "linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888)", color: "white", fontFamily: "var(--font-bounded)", border: "none" }}
                >
                  <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                  {copied ? "Lien copié !" : "Instagram"}
                </button>
                {/* Copier le lien */}
                <button
                  onClick={copyLink}
                  className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 hover:scale-105 hover:shadow-md cursor-pointer"
                  style={{ background: "#f3f4f6", color: "#374151", fontFamily: "var(--font-bounded)", border: "1px solid #e5e7eb" }}
                >
                  <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                  {copied ? "Copié !" : "Copier le lien"}
                </button>
              </div>
              {copied && (
                <p className="text-sm mt-3" style={{ color: "#51845C", fontFamily: "var(--font-tinos)" }}>
                  Lien copié dans le presse-papier ! Collez-le dans votre story ou publication Instagram.
                </p>
              )}
            </div>
          </div>
        </section>
      );
    }

    function BlogArticlePage() {
      return (
        <>
          {/* Back Navigation */}
          <div className="max-w-4xl mx-auto px-6 pt-8">
            <a href={BASE + "blog"} className="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors duration-200" style={{ fontFamily: "var(--font-tinos)" }}>
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
              Retour au blog
            </a>
          </div>

          {/* Article Header */}
          <section className="py-12 px-6">
            <div className="max-w-4xl mx-auto">
              <div className="flex flex-wrap items-center gap-3 mb-6">
                <span className="badge badge-green" style={{ fontFamily: "var(--font-bounded)" }}>{article.categorie}</span>
                {article.sous_categorie && (
                  <span className="badge badge-blue" style={{ fontFamily: "var(--font-bounded)" }}>{article.sous_categorie}</span>
                )}
              </div>
              <h1 className="text-3xl md:text-4xl lg:text-5xl font-black mb-6" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
                {article.titre}
              </h1>
              <div className="flex flex-wrap items-center gap-4 text-gray-500" style={{ fontFamily: "var(--font-tinos)" }}>
                {article.auteur && (
                  <div className="flex items-center gap-2">
                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span>{article.auteur}</span>
                  </div>
                )}
                {article.date_publication && (
                  <div className="flex items-center gap-2">
                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span>{formatDate(article.date_publication)}</span>
                  </div>
                )}
                <div className="flex items-center gap-2">
                  <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                  <span>{readTime} min de lecture</span>
                </div>
              </div>
            </div>
          </section>

          {/* Article Image */}
          {article.image && (
            <section className="px-6 mb-12">
              <div className="max-w-4xl mx-auto">
                <div className="rounded-2xl overflow-hidden shadow-lg">
                  <img src={article.image} alt={article.titre} className="w-full h-auto object-cover" style={{ maxHeight: "500px" }} />
                </div>
              </div>
            </section>
          )}

          {/* Article Content */}
          <section className="px-6 pb-16">
            <div className="max-w-4xl mx-auto">
              <div
                className="article-content"
                style={{ fontFamily: "var(--font-tinos)" }}
                dangerouslySetInnerHTML={{ __html: article.contenu }}
              />
            </div>
          </section>

          {/* Share */}
          <ShareSection slug={article.slug} titre={article.titre} />

          {/* Articles similaires */}
          {similaires.length > 0 && (
            <section className="py-16 px-6" style={{ background: "var(--color-gray-50)" }}>
              <div className="max-w-7xl mx-auto">
                <div className="text-center mb-12">
                  <span className="badge badge-green mb-4" style={{ fontFamily: "var(--font-bounded)" }}>À lire aussi</span>
                  <h2 className="text-4xl font-black" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
                    Articles similaires
                  </h2>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                  {similaires.map((a, i) => {
                    const aSlug = a.slug || a.titre.toLowerCase().replace(/\s+/g, '-');
                    const aWordCount = (a.contenu || '').split(/\s+/).length;
                    const aReadTime = Math.max(1, Math.ceil(aWordCount / 200));
                    return (
                      <a key={a.id} href={BASE + "blog/" + aSlug} className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden block no-underline transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        {a.image && <img src={a.image} alt={a.titre} className="w-full h-48 object-cover" />}
                        <div className="p-6">
                          <div className="flex items-center gap-2 mb-3">
                            <span className="badge badge-green text-sm" style={{ fontFamily: "var(--font-bounded)" }}>{a.categorie}</span>
                            <span className="text-xs text-gray-500" style={{ fontFamily: "var(--font-tinos)" }}>{aReadTime} min</span>
                          </div>
                          <h3 className="text-xl font-black mb-2" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>{a.titre}</h3>
                          <p className="text-gray-600 text-sm" style={{ fontFamily: "var(--font-tinos)" }}>{a.resume}</p>
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

    ReactDOM.createRoot(document.getElementById("blog-article-root")).render(<BlogArticlePage />);
  </script>
</body>
</html>
