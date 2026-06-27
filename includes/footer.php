<?php
$year = date('Y');
?>

<div id="footer-root"></div>

<script type="text/babel">
const { useState, useEffect } = React;

function Footer() {
  const [showFull, setShowFull] = useState(false);
  const [showScrollTop, setShowScrollTop] = useState(false);

  useEffect(() => {
    const handleScroll = () => setShowScrollTop(window.scrollY > 300);
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  };

  const navItems = [
    { name: "Accueil", href: "<?= BASE_URL ?>" },
    { name: "Projets", href: "<?= BASE_URL ?>nos-realisations" },
    { name: "Services", href: "<?= BASE_URL ?>services" },
    { name: "À propos", href: "<?= BASE_URL ?>a-propos" },
    { name: "Blog", href: "<?= BASE_URL ?>blog" },
    { name: "Contact", href: "<?= BASE_URL ?>contact" }
  ];

  const serviceItems = [
    "Développement Backend PHP",
    "APIs REST",
    "Hébergement & Infra",
    "Maintenance & Support"
  ];

  const legal = [
    { name: "Mentions légales", href: "<?= BASE_URL ?>mentions-legales" },
    { name: "Politique de confidentialité", href: "<?= BASE_URL ?>politique-de-confidentialite" }
  ];

  const socials = [
    {
      name: "GitHub",
      href: "https://github.com/Alex2-dev",
      icon: <path d="M12 0C5.372 0 0 5.373 0 12c0 5.303 3.438 9.8 8.205 11.387.6.113.82-.26.82-.577v-2.168c-3.338.726-4.033-1.415-4.033-1.415-.546-1.387-1.333-1.757-1.333-1.757-1.09-.745.083-.729.083-.729 1.205.085 1.84 1.237 1.84 1.237 1.07 1.835 2.809 1.305 3.495.997.107-.776.418-1.305.762-1.605-2.665-.305-5.466-1.335-5.466-5.933 0-1.31.47-2.382 1.236-3.222-.124-.304-.535-1.527.117-3.182 0 0 1.008-.322 3.3 1.23a11.52 11.52 0 0 1 3-.404c1.02.005 2.047.138 3 .404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.655.242 2.878.12 3.182.77.84 1.235 1.912 1.235 3.222 0 4.61-2.805 5.625-5.475 5.92.43.37.823 1.102.823 2.222v3.293c0 .32.218.694.825.576C20.565 21.796 24 17.298 24 12c0-6.627-5.373-12-12-12z"/>
    },
    {
      name: "Instagram",
      href: "https://www.instagram.com/alex2.dev",
      icon: <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.056 1.97.24 2.428.403a4.92 4.92 0 0 1 1.675 1.092 4.92 4.92 0 0 1 1.092 1.675c.163.459.347 1.259.403 2.428.058 1.266.07 1.645.07 4.85s-.012 3.584-.07 4.85c-.056 1.17-.24 1.97-.403 2.428a4.932 4.932 0 0 1-1.092 1.675 4.932 4.932 0 0 1-1.675 1.092c-.459.163-1.259.347-2.428.403-1.266.058-1.645.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.056-1.97-.24-2.428-.403a4.932 4.932 0 0 1-1.675-1.092 4.932 4.932 0 0 1-1.092-1.675c-.163-.459-.347-1.259-.403-2.428C2.175 15.747 2.163 15.368 2.163 12s.012-3.584.07-4.85c.056-1.17.24-1.97.403-2.428A4.92 4.92 0 0 1 3.728 3.047a4.92 4.92 0 0 1 1.675-1.092c.459-.163 1.259-.347 2.428-.403C8.416 2.175 8.796 2.163 12 2.163zm0 1.837c-3.17 0-3.555.012-4.808.07-.923.045-1.423.198-1.755.33a3.093 3.093 0 0 0-1.118.725 3.093 3.093 0 0 0-.725 1.118c-.132.332-.285.832-.33 1.755-.058 1.253-.07 1.638-.07 4.808s.012 3.555.07 4.808c.045.923.198 1.423.33 1.755.17.43.396.805.725 1.118.313.313.688.555 1.118.725.332.132.832.285 1.755.33 1.253.058 1.638.07 4.808.07s3.555-.012 4.808-.07c.923-.045 1.423-.198 1.755-.33a3.093 3.093 0 0 0 1.118-.725 3.093 3.093 0 0 0 .725-1.118c.132-.332.285-.832.33-1.755.058-1.253.07-1.638.07-4.808s-.012-3.555-.07-4.808c-.045-.923-.198-1.423-.33-1.755a3.093 3.093 0 0 0-.725-1.118 3.093 3.093 0 0 0-1.118-.725c-.332-.132-.832-.285-1.755-.33-1.253-.058-1.638-.07-4.808-.07zm0 4.838a5 5 0 1 1 0 10.001 5 5 0 0 1 0-10zm0 1.837a3.163 3.163 0 1 0 0 6.326 3.163 3.163 0 0 0 0-6.326zm6.406-.797a1.17 1.17 0 1 1-2.34 0 1.17 1.17 0 0 1 2.34 0z"/>
    },
    {
      name: "LinkedIn",
      href: "https://www.linkedin.com/company/alex2",
      icon: <path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.3c-.966 0-1.75-.783-1.75-1.75s.784-1.75 1.75-1.75 1.75.783 1.75 1.75-.784 1.75-1.75 1.75zm13.5 10.3h-3v-4.5c0-1.08-.92-2-2-2s-2 .92-2 2v4.5h-3v-9h3v1.2c.615-.87 1.9-1.2 3-1.2 2.21 0 4 1.79 4 4v5z"/>
    }
  ];

  const SocialIcon = ({ social }) => (
    <a href={social.href} className="flex items-center justify-center w-9 h-9 rounded-lg transition-all duration-200 hover:-translate-y-0.5"
       style={{ backgroundColor: "rgba(255,255,255,0.08)" }}
       target="_blank" rel="noopener noreferrer" aria-label={social.name}>
      <svg xmlns="http://www.w3.org/2000/svg" fill="white" className="w-4 h-4" style={{ opacity: 0.6 }} viewBox="0 0 24 24">
        {social.icon}
      </svg>
    </a>
  );

  return (
    <footer style={{ backgroundColor: "#1f2020" }}>
      {showScrollTop && (
        <button
          onClick={scrollToTop}
          className="fixed bottom-6 right-6 p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110 hover:-translate-y-1"
          style={{ background: "linear-gradient(135deg, #51845C, #2563EB)", color: "white", zIndex: 40 }}
          aria-label="Remonter en haut"
        >
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" className="w-5 h-5">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 15l7-7 7 7" />
          </svg>
        </button>
      )}

      {/* Desktop */}
      <div className="hidden md:block">
        <div className="max-w-7xl mx-auto px-6 pt-16 pb-8">
          <div className="grid grid-cols-4 gap-12">
            <div>
              <div className="flex items-center space-x-2 mb-4">
                <img src="<?= BASE_URL ?>asset/img/logo.png" alt="Alex²" className="w-12 h-12 brightness-200" />
                <span className="text-white font-black text-2xl" style={{ fontFamily: "var(--font-heading)" }}>&lt;Alex²/&gt;</span>
              </div>
              <p className="text-gray-400 text-sm leading-relaxed mb-6" style={{ fontFamily: "var(--font-base)" }}>
                Agence de développement web basée à Tarbes & Lourdes. Solutions sur mesure en PHP, APIs et hébergement.
              </p>
              <div className="flex space-x-2">
                {socials.map((s, i) => <SocialIcon key={i} social={s} />)}
              </div>
            </div>

            <div>
              <h4 className="text-white font-black text-sm uppercase tracking-wider mb-4" style={{ fontFamily: "var(--font-heading)" }}>Navigation</h4>
              <ul className="space-y-3">
                {navItems.map((item, i) => (
                  <li key={i}>
                    <a href={item.href} className="text-gray-400 text-sm hover:text-white transition-colors duration-200 no-underline" style={{ fontFamily: "var(--font-base)" }}>{item.name}</a>
                  </li>
                ))}
              </ul>
            </div>

            <div>
              <h4 className="text-white font-black text-sm uppercase tracking-wider mb-4" style={{ fontFamily: "var(--font-heading)" }}>Services</h4>
              <ul className="space-y-3">
                {serviceItems.map((item, i) => (
                  <li key={i}><span className="text-gray-400 text-sm" style={{ fontFamily: "var(--font-base)" }}>{item}</span></li>
                ))}
              </ul>
            </div>

            <div>
              <h4 className="text-white font-black text-sm uppercase tracking-wider mb-4" style={{ fontFamily: "var(--font-heading)" }}>Contact</h4>
              <ul className="space-y-3">
                <li className="flex items-start space-x-3">
                  <svg className="w-4 h-4 text-gray-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                    <path strokeLinecap="round" strokeLinejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  <a href="mailto:contact@alex2.dev" className="text-gray-400 text-sm hover:text-white transition-colors no-underline" style={{ fontFamily: "var(--font-base)" }}>contact@alex2.dev</a>
                </li>
                <li className="flex items-start space-x-3">
                  <svg className="w-4 h-4 text-gray-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                    <path strokeLinecap="round" strokeLinejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path strokeLinecap="round" strokeLinejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span className="text-gray-400 text-sm" style={{ fontFamily: "var(--font-base)" }}>Tarbes & Lourdes (65)</span>
                </li>
                <li className="flex items-start space-x-3">
                  <svg className="w-4 h-4 text-gray-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span className="text-gray-400 text-sm" style={{ fontFamily: "var(--font-base)" }}>Lun-Ven, 9h-18h</span>
                </li>
              </ul>
            </div>
          </div>

          {/* Eco-conception badge */}
          <div className="mt-12 pt-8 pb-8" style={{ borderTop: "1px solid rgba(255,255,255,0.1)" }}>
            <div className="flex flex-wrap items-center justify-between gap-6">
              <div className="flex items-center gap-4">
                <div className="flex items-center justify-center w-12 h-12 rounded-xl" style={{ background: "rgba(81,132,92,0.15)", border: "1px solid rgba(81,132,92,0.3)" }}>
                  <svg className="w-6 h-6" style={{ color: "#51845C" }} fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                </div>
                <div>
                  <div className="flex items-center gap-2 mb-0.5">
                    <span className="text-white text-sm font-black" style={{ fontFamily: "var(--font-heading)" }}>Site éco-conçu</span>
                    <span className="px-2 py-0.5 rounded-md text-xs font-black" style={{ background: "rgba(81,132,92,0.2)", color: "#7ec88a", fontFamily: "var(--font-heading)" }}>EcoIndex A</span>
                  </div>
                  <p className="text-gray-500 text-xs" style={{ fontFamily: "var(--font-base)" }}>
                    ~1.04g CO₂ · ~1.56cL eau par visite — Notre démarche d'éco-conception web
                  </p>
                </div>
              </div>
              <div className="flex items-center gap-6">
                <div className="flex items-center gap-3">
                  <div className="text-center">
                    <div className="text-lg font-black" style={{ color: "#7ec88a", fontFamily: "var(--font-heading)" }}>A</div>
                    <div className="text-gray-600 text-[10px]" style={{ fontFamily: "var(--font-base)" }}>Grade</div>
                  </div>
                  <div className="w-px h-8" style={{ background: "rgba(255,255,255,0.1)" }} />
                  <div className="text-center">
                    <div className="text-lg font-black" style={{ color: "#7ec88a", fontFamily: "var(--font-heading)" }}>96</div>
                    <div className="text-gray-600 text-[10px]" style={{ fontFamily: "var(--font-base)" }}>/100</div>
                  </div>
                  <div className="w-px h-8" style={{ background: "rgba(255,255,255,0.1)" }} />
                  <div className="text-center">
                    <div className="text-lg font-black" style={{ color: "#7ec88a", fontFamily: "var(--font-heading)" }}>1.04g</div>
                    <div className="text-gray-600 text-[10px]" style={{ fontFamily: "var(--font-base)" }}>CO₂/visite</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div className="pt-8 flex flex-wrap items-center justify-between" style={{ borderTop: "1px solid rgba(255,255,255,0.1)" }}>
            <p className="text-gray-500 text-sm" style={{ fontFamily: "var(--font-base)" }}>
              &copy; <?= $year ?> <span className="text-gray-400">&lt;Alex²/&gt;</span>. Tous droits réservés.
            </p>
            <div className="flex items-center space-x-6">
              {legal.map((item, i) => (
                <a key={i} href={item.href} className="text-gray-500 text-sm hover:text-gray-300 transition-colors no-underline" style={{ fontFamily: "var(--font-base)" }}>{item.name}</a>
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* Mobile */}
      <div className="md:hidden px-6 py-8">
        <div className="text-center mb-6">
          <div className="flex items-center justify-center space-x-2 mb-3">
            <img src="<?= BASE_URL ?>asset/img/logo.png" alt="Alex²" className="w-10 h-10 brightness-200" />
            <span className="text-white font-black text-2xl" style={{ fontFamily: "var(--font-heading)" }}>&lt;Alex²/&gt;</span>
          </div>
          <p className="text-gray-400 text-sm" style={{ fontFamily: "var(--font-base)" }}>Agence web · Tarbes & Lourdes</p>
        </div>

        <div className="flex justify-center space-x-3 mb-6">
          {socials.map((s, i) => <SocialIcon key={i} social={s} />)}
        </div>

        <button onClick={() => setShowFull(!showFull)} className="w-full flex items-center justify-center text-gray-400 text-sm py-2 mb-4 transition-colors hover:text-white">
          <svg className={`w-4 h-4 mr-1 transform transition-transform duration-300 ${showFull ? "rotate-180" : ""}`} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7" />
          </svg>
          {showFull ? "Réduire" : "Plus d'infos"}
        </button>

        {showFull && (
          <div className="space-y-6 text-center" style={{ fontFamily: "var(--font-base)" }}>
            <div>
              <h4 className="text-white text-sm font-black mb-3" style={{ fontFamily: "var(--font-heading)" }}>Navigation</h4>
              <div className="space-y-2">
                {navItems.map((item, i) => (
                  <a key={i} href={item.href} className="block text-gray-400 text-sm hover:text-white transition-colors no-underline">{item.name}</a>
                ))}
              </div>
            </div>
            <div>
              <h4 className="text-white text-sm font-black mb-3" style={{ fontFamily: "var(--font-heading)" }}>Contact</h4>
              <a href="mailto:contact@alex2.dev" className="block text-gray-400 text-sm hover:text-white transition-colors no-underline mb-1">contact@alex2.dev</a>
              <span className="text-gray-500 text-sm">Tarbes & Lourdes (65)</span>
            </div>
          </div>
        )}

        {/* Eco badge mobile */}
        <div className="mt-6 pt-6 text-center" style={{ borderTop: "1px solid rgba(255,255,255,0.1)" }}>
          <div className="flex items-center justify-center gap-3 mb-4">
            <div className="flex items-center justify-center w-8 h-8 rounded-lg" style={{ background: "rgba(81,132,92,0.15)", border: "1px solid rgba(81,132,92,0.3)" }}>
              <svg className="w-4 h-4" style={{ color: "#51845C" }} fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
            </div>
            <div className="text-left">
              <div className="flex items-center gap-2">
                <span className="text-white text-xs font-black" style={{ fontFamily: "var(--font-heading)" }}>Site éco-conçu</span>
                <span className="px-1.5 py-0.5 rounded text-[10px] font-black" style={{ background: "rgba(81,132,92,0.2)", color: "#7ec88a", fontFamily: "var(--font-heading)" }}>EcoIndex A · 96/100</span>
              </div>
              <p className="text-gray-600 text-[10px]" style={{ fontFamily: "var(--font-base)" }}>~1.04g CO₂ par visite</p>
            </div>
          </div>
        </div>

        <div className="pt-4 text-center" style={{ borderTop: "1px solid rgba(255,255,255,0.1)" }}>
          <p className="text-gray-500 text-xs mb-2" style={{ fontFamily: "var(--font-base)" }}>&copy; <?= $year ?> &lt;Alex²/&gt;. Tous droits réservés.</p>
          <div className="flex justify-center space-x-4">
            {legal.map((item, i) => (
              <a key={i} href={item.href} className="text-gray-600 text-xs hover:text-gray-400 transition-colors no-underline" style={{ fontFamily: "var(--font-base)" }}>{item.name}</a>
            ))}
          </div>
        </div>
      </div>
    </footer>
  );
}

if (!window.__footer_root__) {
  const container = document.getElementById("footer-root");
  window.__footer_root__ = ReactDOM.createRoot(container);
}
window.__footer_root__.render(<Footer />);
</script>
