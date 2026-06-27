<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: text/html; charset=utf-8');

$stmt = $pdo->query("SELECT * FROM blog WHERE publie = TRUE ORDER BY date_publication DESC");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$articlesJson = json_encode($articles, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Développement Web 65 | Alex²</title>
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

    <meta name="description" content="Blog développement web : tutoriels, actualités tech et articles sur la création de sites web par Alex², agence web à Tarbes et Lourdes (65).">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://alex2.dev/blog">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Blog - Développement Web 65 | Alex²">
    <meta property="og:description" content="Tutoriels, actualités tech et articles sur le développement web dans le 65">
    <meta property="og:url" content="https://alex2.dev/blog">
    <meta property="og:image" content="https://alex2.dev/Alex2logo.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Blog - Développement Web 65 | Alex²">
    <meta name="twitter:description" content="Tutoriels, actualités tech et articles sur le développement web dans le 65">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Blog",
      "name": "Blog Alex² - Développement Web 65",
      "description": "Blog sur le développement web, tutoriels et actualités tech par Alex², duo de développeurs à Tarbes et Lourdes (65)",
      "url": "https://alex2.dev/blog",
      "publisher": {
        "@type": "Organization",
        "name": "Alex²",
        "logo": { "@type": "ImageObject", "url": "https://alex2.dev/Alex2logo.png" }
      }
    }
    </script>
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">

<?php include __DIR__ . '/../../includes/header.php'; ?>

<section id="content">
  <!-- Hero -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-4xl mx-auto text-center">
      <span class="badge badge-blue mb-4" style="font-family: var(--font-bounded);">Blog</span>
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6" style="font-family: var(--font-bounded); color: var(--color-black);">
        Notre <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">Blog</span>
      </h1>
      <p class="text-xl text-gray-600 max-w-2xl mx-auto" style="font-family: var(--font-tinos);">
        Tutoriels, actualités et ressources sur le développement web
      </p>
    </div>
  </section>

  <!-- Articles Grid -->
  <section class="py-16 px-6" style="background: var(--color-gray-50);">
    <div id="blog-root" class="max-w-7xl mx-auto"></div>
  </section>

  <?php include __DIR__ . '/../../includes/cta.php'; ?>
</section>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

<script type="text/babel">
const BASE = "<?= BASE_URL ?>";
const { useState, useEffect } = React;

const articles = <?= $articlesJson ?>;

function BlogPage() {
    const [filtreCategorie, setFiltreCategorie] = useState('Tous');
    const [articlesFiltres, setArticlesFiltres] = useState(articles);
    const [categories, setCategories] = useState(['Tous']);

    useEffect(() => {
        const uniqueCategories = ['Tous', ...new Set(articles.map(a => a.categorie))];
        setCategories(uniqueCategories);
    }, []);

    useEffect(() => {
        if (filtreCategorie === 'Tous') {
            setArticlesFiltres(articles);
        } else {
            setArticlesFiltres(articles.filter(a => a.categorie === filtreCategorie));
        }
    }, [filtreCategorie]);

    const formatDate = (dateStr) => {
        const date = new Date(dateStr);
        return date.toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' });
    };

    const getReadTime = (contenu) => {
        const words = (contenu || '').split(/\s+/).length;
        return Math.max(1, Math.ceil(words / 200));
    };

    return (
        <>
            {/* Filtres */}
            <div className="flex flex-wrap justify-center gap-3 mb-8">
                {categories.map(cat => (
                    <button
                        key={cat}
                        onClick={() => setFiltreCategorie(cat)}
                        className={`filter-btn ${filtreCategorie === cat ? 'active' : ''}`}
                        style={{ fontFamily: "var(--font-bounded)" }}
                    >
                        {cat}
                    </button>
                ))}
            </div>

            <p className="text-center text-gray-600 mb-8" style={{ fontFamily: "var(--font-tinos)" }}>
                {articlesFiltres.length} article{articlesFiltres.length > 1 ? 's' : ''} trouvé{articlesFiltres.length > 1 ? 's' : ''}
            </p>

            {articlesFiltres.length === 0 ? (
                <div className="text-center py-20">
                    <p className="text-2xl text-gray-500" style={{ fontFamily: "var(--font-tinos)" }}>
                        Aucun article dans cette catégorie pour le moment
                    </p>
                </div>
            ) : (
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {articlesFiltres.map((article, i) => {
                        const slug = article.slug || article.titre.toLowerCase().replace(/\s+/g, '-');
                        const readTime = getReadTime(article.contenu);
                        return (
                            <a
                                key={article.id}
                                href={BASE + "blog/" + slug}
                                className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden block no-underline transition-all duration-300 hover:shadow-lg hover:-translate-y-1"
                                style={{ animationDelay: `${i * 0.1}s` }}
                            >
                                {article.image && (
                                    <img src={article.image} alt={article.titre} className="w-full h-48 object-cover" />
                                )}
                                <div className="p-6">
                                    <div className="flex items-center gap-2 mb-3 flex-wrap">
                                        <span className="badge badge-green text-sm" style={{ fontFamily: "var(--font-bounded)" }}>
                                            {article.categorie}
                                        </span>
                                        {article.sous_categorie && (
                                            <span className="badge badge-blue text-sm" style={{ fontFamily: "var(--font-bounded)" }}>
                                                {article.sous_categorie}
                                            </span>
                                        )}
                                    </div>
                                    <h2 className="text-2xl font-black mb-3" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
                                        {article.titre}
                                    </h2>
                                    <p className="text-gray-600 mb-4 text-sm" style={{ fontFamily: "var(--font-tinos)" }}>
                                        {article.resume}
                                    </p>
                                    <div className="flex items-center justify-between text-xs text-gray-500" style={{ fontFamily: "var(--font-tinos)" }}>
                                        <span>{formatDate(article.date_publication)}</span>
                                        <span>{readTime} min de lecture</span>
                                    </div>
                                </div>
                            </a>
                        );
                    })}
                </div>
            )}
        </>
    );
}

ReactDOM.createRoot(document.getElementById('blog-root')).render(<BlogPage />);
</script>

</body>
</html>
