<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM services ORDER BY id ASC");
    $services = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $lines = array_unique(array_filter([
            $row['line1'], $row['line2'], $row['line3'], $row['line4'], $row['line5']
        ]));
        $services[] = [
            'name' => $row['name'],
            'lines' => array_values($lines)
        ];
    }
} catch (PDOException $e) {
    $services = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Services | &lt;Alex²/&gt;</title>
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

    <meta name="description" content="Alex² propose des services de développement web à Tarbes et Lourdes (65) : backend PHP, APIs REST, hébergement et maintenance.">
    <link rel="canonical" href="https://alex2.dev/services">
    <meta property="og:title" content="Services | Alex² - Développement web 65">
    <meta property="og:description" content="Découvrez les services web proposés par Alex² : backend PHP, APIs, hébergement et maintenance.">
    <meta property="og:url" content="https://alex2.dev/services">
    <meta name="twitter:title" content="Services | Alex² - Développement web 65">
    <meta name="twitter:description" content="Nos services : backend PHP, APIs REST, hébergement et maintenance web à Tarbes et Lourdes (65).">
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">
<?php include __DIR__ . '/../../includes/header.php'; ?>

<section id="content">
  <!-- Hero -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-5xl mx-auto text-center">
      <span class="badge badge-green mb-4" style="font-family: var(--font-bounded);">Nos Services</span>
      <h1 class="text-4xl md:text-5xl font-black mb-6" style="font-family: var(--font-bounded); color: var(--color-black);">
        Des solutions <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">sur mesure</span>
      </h1>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto" style="font-family: var(--font-tinos);">
        Un duo de développeurs passionnés à votre service pour créer des solutions web modernes, performantes et adaptées à vos besoins.
      </p>
    </div>
  </section>

  <!-- Services Grid -->
  <section class="py-20 px-6" style="background: var(--color-gray-50);">
    <script>window.SERVICES = <?= json_encode($services, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?>;</script>
    <div id="services-root" class="max-w-7xl mx-auto"></div>
  </section>

  <!-- Pourquoi nous choisir -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-5xl mx-auto">
      <div class="text-center mb-16">
        <span class="badge badge-blue mb-4" style="font-family: var(--font-bounded);">Avantages</span>
        <h2 class="text-3xl md:text-4xl font-black" style="font-family: var(--font-bounded); color: var(--color-black);">
          Pourquoi nous choisir ?
        </h2>
      </div>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="text-center p-6">
          <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: #dcfce7;">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
          </div>
          <h3 class="text-2xl font-black mb-2" style="font-family: var(--font-bounded);">Code de qualité</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">Du code propre, testé et maintenable. Pas de templates, tout est fait sur mesure.</p>
        </div>
        <div class="text-center p-6">
          <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: #dbeafe;">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
          </div>
          <h3 class="text-2xl font-black mb-2" style="font-family: var(--font-bounded);">Performance</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">Sites rapides et optimisés pour le SEO. Votre visibilité est notre priorité.</p>
        </div>
        <div class="text-center p-6">
          <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: #dcfce7;">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
          </div>
          <h3 class="text-2xl font-black mb-2" style="font-family: var(--font-bounded);">Accompagnement</h3>
          <p class="text-gray-600" style="font-family: var(--font-tinos);">Un interlocuteur direct, réactif et transparent. Pas de sous-traitance.</p>
        </div>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/../../includes/cta.php'; ?>
</section>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

<script type="text/babel">
  const { useState, useEffect, useRef } = React;

  const Icons = [
    () => <svg className="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5"><path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>,
    () => <svg className="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>,
    () => <svg className="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg>,
    () => <svg className="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>,
    () => <svg className="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>,
    () => <svg className="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
  ];

  const colors = ['#51845C', '#2563EB', '#51845C', '#2563EB', '#51845C', '#2563EB'];
  const bgColors = ['#dcfce7', '#dbeafe', '#dcfce7', '#dbeafe', '#dcfce7', '#dbeafe'];

  function ServiceCard({ service, index }) {
    const [isHovered, setIsHovered] = useState(false);
    const cardRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
      const observer = new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) setIsVisible(true);
      }, { threshold: 0.2 });
      if (cardRef.current) observer.observe(cardRef.current);
      return () => { if (cardRef.current) observer.unobserve(cardRef.current); };
    }, []);

    const lines = service.lines || [];
    const description = lines.find(line => !line.includes('DISPONIBLE') && line.trim() !== service.name)?.trim() || '';
    const features = lines.filter(line => line.trim() && !line.includes('DISPONIBLE') && line.trim() !== service.name && line !== description);
    const IconComponent = Icons[index] || Icons[0];
    const color = colors[index] || '#51845C';
    const bgColor = bgColors[index] || '#dcfce7';

    return (
      <div
        ref={cardRef}
        className={`transition-all duration-700 ${isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'}`}
        style={{ transitionDelay: `${index * 100}ms` }}
        onMouseEnter={() => setIsHovered(true)}
        onMouseLeave={() => setIsHovered(false)}
      >
        <div className={`bg-white rounded-2xl border-2 p-8 h-full transition-all duration-300 ${isHovered ? 'shadow-xl -translate-y-2 border-gray-200' : 'shadow-sm border-gray-100'}`}>
          <div className="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 transition-transform duration-300" style={{ background: bgColor, color, transform: isHovered ? 'scale(1.1)' : 'scale(1)' }}>
            <IconComponent />
          </div>

          <h3 className="text-2xl font-black mb-3" style={{ fontFamily: 'var(--font-bounded)', color: 'var(--color-black)' }}>
            {service.name}
          </h3>

          <p className="text-gray-600 mb-6 leading-relaxed" style={{ fontFamily: 'var(--font-tinos)' }}>
            {description}
          </p>

          <div className="space-y-2 mb-6">
            {features.map((feature, i) => (
              <div key={i} className="flex items-start gap-2">
                <svg className="w-4 h-4 mt-1 flex-shrink-0" fill="none" stroke={color} viewBox="0 0 24 24" strokeWidth={2.5}>
                  <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span className="text-sm text-gray-700" style={{ fontFamily: 'var(--font-tinos)' }}>{feature}</span>
              </div>
            ))}
          </div>

          <a href="<?= BASE_URL ?>contact" className="inline-flex items-center gap-2 text-base font-black transition-all duration-300" style={{ color, fontFamily: 'var(--font-bounded)', transform: isHovered ? 'translateX(4px)' : 'translateX(0)' }}>
            Démarrer
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2.5}><path strokeLinecap="round" strokeLinejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
          </a>
        </div>
      </div>
    );
  }

  function ServicesList() {
    const services = window.SERVICES || [];
    return (
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        {services.map((service, idx) => (
          <ServiceCard key={idx} service={service} index={idx} />
        ))}
      </div>
    );
  }

  ReactDOM.createRoot(document.getElementById('services-root')).render(<ServicesList />);
</script>
</body>
</html>
