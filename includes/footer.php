<?php
$year = date('Y');
?>

<div id="footer-root"></div>

<script type="text/babel">
const { useState, useEffect } = React;

function Footer() {
  const [showFull, setShowFull] = useState(false);

  const items = [
    { name: "Accueil", href: "<?= BASE_URL ?>" },
    { name: "Projets réalisés", href: "<?= BASE_URL ?>/NosProjets" },
    { name: "Nos services", href: "<?= BASE_URL ?>/Services" },
    { name: "À propos", href: "<?= BASE_URL ?>/Apropos" },
    { name: "Contact", href: "<?= BASE_URL ?>/Contact" }
  ];

  const legal = [
    { name: "Mentions légales", href: "<?= BASE_URL ?>/Mentions-Légales" },
    { name: "Politique de confidentialité", href: "<?= BASE_URL ?>/Politique-de-confidentialité" }
  ];

  const isMobile = () => window.innerWidth < 768;

  return (
    <footer className="pt-6 pb-4 px-6" style={{ backgroundColor: "var(--color-black)" }}>
      {/* Desktop */}
      <div className="hidden md:block">
        <div className="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">
          {/* Navigation */}
          <div>
            <h3 className="text-xl mb-4 text-center text-white" style={{ fontFamily: "var(--font-base)" }}>Navigation</h3>
            <ul className="space-y-2 text-center">
              {items.map((item, i) => (
                <li key={i}>
                  <a href={item.href} className="hover:underline text-white" style={{ fontFamily: "var(--font-base)" }}>
                    {item.name}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Mentions */}
          <div>
            <h3 className="text-xl mb-4 text-center text-white" style={{ fontFamily: "var(--font-base)" }}>Mentions légales</h3>
            <ul className="space-y-2 text-center">
              {legal.map((item, i) => (
                <li key={i}>
                  <a href={item.href} className="hover:underline text-white" style={{ fontFamily: "var(--font-base)" }}>
                    {item.name}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Réseaux sociaux */}
          <div>
            <h3 className="text-xl mb-4 text-center text-white" style={{ fontFamily: "var(--font-base)" }}>Suivez-nous</h3>
            <div className="flex flex-col space-y-3 items-center">
              {/* Ajoute ici tes icônes réseaux sociaux si besoin */}
            <a href="https://github.com/Alex2-dev" className="flex items-center text-white space-x-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" className="w-5 h-5" viewBox="0 0 24 24">
                <path d="M12 0C5.372 0 0 5.373 0 12c0 5.303 3.438 9.8 8.205 11.387.6.113.82-.26.82-.577v-2.168c-3.338.726-4.033-1.415-4.033-1.415-.546-1.387-1.333-1.757-1.333-1.757-1.09-.745.083-.729.083-.729 1.205.085 1.84 1.237 1.84 1.237 1.07 1.835 2.809 1.305 3.495.997.107-.776.418-1.305.762-1.605-2.665-.305-5.466-1.335-5.466-5.933 0-1.31.47-2.382 1.236-3.222-.124-.304-.535-1.527.117-3.182 0 0 1.008-.322 3.3 1.23a11.52 11.52 0 0 1 3-.404c1.02.005 2.047.138 3 .404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.655.242 2.878.12 3.182.77.84 1.235 1.912 1.235 3.222 0 4.61-2.805 5.625-5.475 5.92.43.37.823 1.102.823 2.222v3.293c0 .32.218.694.825.576C20.565 21.796 24 17.298 24 12c0-6.627-5.373-12-12-12z"/>
              </svg>
              <span>GitHub</span>
            </a>

            <a href="https://www.instagram.com/alex2.dev" className="flex items-center text-white space-x-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" className="w-5 h-5" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.056 1.97.24 2.428.403a4.92 4.92 0 0 1 1.675 1.092 4.92 4.92 0 0 1 1.092 1.675c.163.459.347 1.259.403 2.428.058 1.266.07 1.645.07 4.85s-.012 3.584-.07 4.85c-.056 1.17-.24 1.97-.403 2.428a4.932 4.932 0 0 1-1.092 1.675 4.932 4.932 0 0 1-1.675 1.092c-.459.163-1.259.347-2.428.403-1.266.058-1.645.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.056-1.97-.24-2.428-.403a4.932 4.932 0 0 1-1.675-1.092 4.932 4.932 0 0 1-1.092-1.675c-.163-.459-.347-1.259-.403-2.428C2.175 15.747 2.163 15.368 2.163 12s.012-3.584.07-4.85c.056-1.17.24-1.97.403-2.428A4.92 4.92 0 0 1 3.728 3.047a4.92 4.92 0 0 1 1.675-1.092c.459-.163 1.259-.347 2.428-.403C8.416 2.175 8.796 2.163 12 2.163zm0 1.837c-3.17 0-3.555.012-4.808.07-.923.045-1.423.198-1.755.33a3.093 3.093 0 0 0-1.118.725 3.093 3.093 0 0 0-.725 1.118c-.132.332-.285.832-.33 1.755-.058 1.253-.07 1.638-.07 4.808s.012 3.555.07 4.808c.045.923.198 1.423.33 1.755.17.43.396.805.725 1.118.313.313.688.555 1.118.725.332.132.832.285 1.755.33 1.253.058 1.638.07 4.808.07s3.555-.012 4.808-.07c.923-.045 1.423-.198 1.755-.33a3.093 3.093 0 0 0 1.118-.725 3.093 3.093 0 0 0 .725-1.118c.132-.332.285-.832.33-1.755.058-1.253.07-1.638.07-4.808s-.012-3.555-.07-4.808c-.045-.923-.198-1.423-.33-1.755a3.093 3.093 0 0 0-.725-1.118 3.093 3.093 0 0 0-1.118-.725c-.332-.132-.832-.285-1.755-.33-1.253-.058-1.638-.07-4.808-.07zm0 4.838a5 5 0 1 1 0 10.001 5 5 0 0 1 0-10zm0 1.837a3.163 3.163 0 1 0 0 6.326 3.163 3.163 0 0 0 0-6.326zm6.406-.797a1.17 1.17 0 1 1-2.34 0 1.17 1.17 0 0 1 2.34 0z"/>
              </svg>
              <span>Instagram</span>
            </a>

            <a href="#" className="flex items-center text-white space-x-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" className="w-5 h-5" viewBox="0 0 24 24">
                <path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.3c-.966 0-1.75-.783-1.75-1.75s.784-1.75 1.75-1.75 1.75.783 1.75 1.75-.784 1.75-1.75 1.75zm13.5 10.3h-3v-4.5c0-1.08-.92-2-2-2s-2 .92-2 2v4.5h-3v-9h3v1.2c.615-.87 1.9-1.2 3-1.2 2.21 0 4 1.79 4 4v5z"/>
              </svg>
              <span>LinkedIn</span>
            </a>

            </div>
          </div>
        </div>
      </div>

      {/* Mobile */}
      <div className="md:hidden text-center text-sm text-gray-400 mt-4">
        &copy; <?= $year ?> <span className="font-semibold text-white">&lt;Alex²/&gt;</span>. Tous droits réservés.

        <div className="flex justify-center mt-2">
          <button onClick={() => setShowFull(!showFull)} className="text-white text-sm flex items-center gap-1">
            <svg className={`w-5 h-5 transform transition-transform duration-300 ${showFull ? "rotate-180" : ""}`} fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7" />
            </svg>
            <span>{showFull ? "Réduire" : "Afficher plus"}</span>
          </button>
        </div>

        {showFull && (
          <div className="mt-6 grid grid-cols-1 gap-10 text-white" style={{ fontFamily: "var(--font-base)" }}>
            {/* Navigation */}
            <div>
              <h3 className="text-lg mb-2">Navigation</h3>
              <ul className="space-y-2">
                {items.map((item, i) => (
                  <li key={i}>
                    <a href={item.href} className="hover:underline">{item.name}</a>
                  </li>
                ))}
              </ul>
            </div>

            {/* Mentions */}
            <div>
              <h3 className="text-lg mb-2">Mentions légales</h3>
              <ul className="space-y-2">
                {legal.map((item, i) => (
                  <li key={i}>
                    <a href={item.href} className="hover:underline">{item.name}</a>
                  </li>
                ))}
              </ul>
            </div>

            {/* Réseaux */}
            <div>
              <h3 className="text-lg mb-2">Suivez-nous</h3>
              <div className="flex flex-col space-y-2 items-center">
              <a href="https://github.com/Alex2-dev" className="flex items-center text-white space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" className="w-5 h-5" viewBox="0 0 24 24">
                  <path d="M12 0C5.372 0 0 5.373 0 12c0 5.303 3.438 9.8 8.205 11.387.6.113.82-.26.82-.577v-2.168c-3.338.726-4.033-1.415-4.033-1.415-.546-1.387-1.333-1.757-1.333-1.757-1.09-.745.083-.729.083-.729 1.205.085 1.84 1.237 1.84 1.237 1.07 1.835 2.809 1.305 3.495.997.107-.776.418-1.305.762-1.605-2.665-.305-5.466-1.335-5.466-5.933 0-1.31.47-2.382 1.236-3.222-.124-.304-.535-1.527.117-3.182 0 0 1.008-.322 3.3 1.23a11.52 11.52 0 0 1 3-.404c1.02.005 2.047.138 3 .404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.655.242 2.878.12 3.182.77.84 1.235 1.912 1.235 3.222 0 4.61-2.805 5.625-5.475 5.92.43.37.823 1.102.823 2.222v3.293c0 .32.218.694.825.576C20.565 21.796 24 17.298 24 12c0-6.627-5.373-12-12-12z"/>
                </svg>
                <span>GitHub</span>
              </a>

              <a href="https://www.instagram.com/alex2.dev" className="flex items-center text-white space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" className="w-5 h-5" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.056 1.97.24 2.428.403a4.92 4.92 0 0 1 1.675 1.092 4.92 4.92 0 0 1 1.092 1.675c.163.459.347 1.259.403 2.428.058 1.266.07 1.645.07 4.85s-.012 3.584-.07 4.85c-.056 1.17-.24 1.97-.403 2.428a4.932 4.932 0 0 1-1.092 1.675 4.932 4.932 0 0 1-1.675 1.092c-.459.163-1.259.347-2.428.403-1.266.058-1.645.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.056-1.97-.24-2.428-.403a4.932 4.932 0 0 1-1.675-1.092 4.932 4.932 0 0 1-1.092-1.675c-.163-.459-.347-1.259-.403-2.428C2.175 15.747 2.163 15.368 2.163 12s.012-3.584.07-4.85c.056-1.17.24-1.97.403-2.428A4.92 4.92 0 0 1 3.728 3.047a4.92 4.92 0 0 1 1.675-1.092c.459-.163 1.259-.347 2.428-.403C8.416 2.175 8.796 2.163 12 2.163zm0 1.837c-3.17 0-3.555.012-4.808.07-.923.045-1.423.198-1.755.33a3.093 3.093 0 0 0-1.118.725 3.093 3.093 0 0 0-.725 1.118c-.132.332-.285.832-.33 1.755-.058 1.253-.07 1.638-.07 4.808s.012 3.555.07 4.808c.045.923.198 1.423.33 1.755.17.43.396.805.725 1.118.313.313.688.555 1.118.725.332.132.832.285 1.755.33 1.253.058 1.638.07 4.808.07s3.555-.012 4.808-.07c.923-.045 1.423-.198 1.755-.33a3.093 3.093 0 0 0 1.118-.725 3.093 3.093 0 0 0 .725-1.118c.132-.332.285-.832.33-1.755.058-1.253.07-1.638.07-4.808s-.012-3.555-.07-4.808c-.045-.923-.198-1.423-.33-1.755a3.093 3.093 0 0 0-.725-1.118 3.093 3.093 0 0 0-1.118-.725c-.332-.132-.832-.285-1.755-.33-1.253-.058-1.638-.07-4.808-.07zm0 4.838a5 5 0 1 1 0 10.001 5 5 0 0 1 0-10zm0 1.837a3.163 3.163 0 1 0 0 6.326 3.163 3.163 0 0 0 0-6.326zm6.406-.797a1.17 1.17 0 1 1-2.34 0 1.17 1.17 0 0 1 2.34 0z"/>
                </svg>
                <span>Instagram</span>
              </a>

              <a href="#" className="flex items-center text-white space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" className="w-5 h-5" viewBox="0 0 24 24">
                  <path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.3c-.966 0-1.75-.783-1.75-1.75s.784-1.75 1.75-1.75 1.75.783 1.75 1.75-.784 1.75-1.75 1.75zm13.5 10.3h-3v-4.5c0-1.08-.92-2-2-2s-2 .92-2 2v4.5h-3v-9h3v1.2c.615-.87 1.9-1.2 3-1.2 2.21 0 4 1.79 4 4v5z"/>
                </svg>
                <span>LinkedIn</span>
              </a>

              </div>
            </div>
          </div>
        )}
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
