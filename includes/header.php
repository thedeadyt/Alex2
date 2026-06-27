<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Fonts -->
<style>
  @font-face {
    font-family: 'Bounded';
    src: url('<?= BASE_URL ?>asset/fonts/Bounded-Regular.ttf') format('truetype');
    font-weight: 100 500;
    font-style: normal;
    font-display: swap;
  }
  @font-face {
    font-family: 'Bounded';
    src: url('<?= BASE_URL ?>asset/fonts/Bounded-Black.ttf') format('truetype');
    font-weight: 600 900;
    font-style: normal;
    font-display: swap;
  }
</style>

<!-- Header React Root -->
<div id="header-root" style="position: sticky; top: 0; z-index: 50;"></div>

<!-- Header Component -->
<script type="text/babel">
  const { useState, useEffect, useRef } = React;

  function Header() {
    const [open, setOpen] = useState(false);
    const [activeIndex, setActiveIndex] = useState(0);
    const [highlight, setHighlight] = useState({ left: 0, width: 0 });
    const [scrolled, setScrolled] = useState(false);
    const navRefs = useRef([]);

    const items = [
      { name: "Accueil", href: "<?= BASE_URL ?>", file: "index.php" },
      { name: "Projets", href: "<?= BASE_URL ?>nos-realisations", file: "NosProjets.php" },
      { name: "Services", href: "<?= BASE_URL ?>services", file: "Services.php" },
      { name: "À propos", href: "<?= BASE_URL ?>a-propos", file: "Apropos.php" },
      { name: "Blog", href: "<?= BASE_URL ?>blog", file: "Blog.php" }
    ];

    useEffect(() => {
      const current = "<?= $currentPage ?>";
      const index = items.findIndex(item => item.file === current);
      setActiveIndex(index !== -1 ? index : 0);
    }, []);

    useEffect(() => {
      const handleScroll = () => setScrolled(window.scrollY > 20);
      window.addEventListener("scroll", handleScroll);
      return () => window.removeEventListener("scroll", handleScroll);
    }, []);

    useEffect(() => {
      const timeout = setTimeout(() => {
        const el = navRefs.current[activeIndex];
        if (el) {
          const span = el.querySelector("span");
          if (span) {
            const left = span.offsetLeft + el.offsetLeft - 10;
            const width = span.offsetWidth + 20;
            setHighlight({ left, width });
          }
        }
      }, 50);
      return () => clearTimeout(timeout);
    }, [activeIndex]);

    useEffect(() => {
      const handleResize = () => { if (window.innerWidth >= 768) setOpen(false); };
      window.addEventListener("resize", handleResize);
      return () => window.removeEventListener("resize", handleResize);
    }, []);

    useEffect(() => {
      document.body.style.overflow = open ? "hidden" : "";
      return () => { document.body.style.overflow = ""; };
    }, [open]);

    return (
      <>
        <nav
          style={{
            backgroundColor: scrolled ? "rgba(250, 250, 250, 0.85)" : "var(--color-white)",
            backdropFilter: scrolled ? "blur(12px)" : "none",
            WebkitBackdropFilter: scrolled ? "blur(12px)" : "none",
            borderBottom: scrolled ? "1px solid #e5e7eb" : "1px solid transparent",
            fontFamily: "var(--font-tinos)",
            transition: "all 0.3s ease"
          }}
          className="px-6 py-3"
        >
          <div className="max-w-7xl mx-auto flex items-center justify-between">
            {/* Logo */}
            <a href="<?= BASE_URL ?>" className="flex items-center space-x-2 no-underline">
              <img src="<?= BASE_URL ?>asset/img/logo.png" alt="Alex² Logo" className="w-14 h-14" />
              <span style={{ fontFamily: "var(--font-heading)", color: "var(--color-black)", letterSpacing: "0.08em" }} className="text-3xl font-black">&lt;Alex²/&gt;</span>
            </a>

            {/* Desktop Nav */}
            <div className="hidden md:flex items-center space-x-1 relative" style={{ fontFamily: "var(--font-base)" }}>
              <div
                className="absolute rounded-lg transition-all duration-500 ease-out"
                style={{
                  width: `${highlight.width}px`,
                  left: `${highlight.left}px`,
                  backgroundColor: "var(--color-black)",
                  top: "50%",
                  transform: "translateY(-50%)",
                  height: "2.2em",
                  borderRadius: "0.5rem",
                  zIndex: 0,
                  pointerEvents: "none"
                }}
              />
              {items.map((item, i) => (
                <a
                  key={i}
                  href={item.href}
                  className="relative px-3 py-1 font-medium no-underline transition-colors duration-300"
                  ref={el => navRefs.current[i] = el}
                  style={{
                    color: i === activeIndex ? "white" : "#6b7280",
                    zIndex: 10,
                    fontSize: "0.95rem"
                  }}
                  onMouseEnter={() => setActiveIndex(i)}
                >
                  <span>{item.name}</span>
                </a>
              ))}
            </div>

            {/* Desktop CTA + Mobile Burger */}
            <div className="flex items-center space-x-4">
              <a
                href="<?= BASE_URL ?>contact"
                className="hidden md:inline-flex items-center px-5 py-2 rounded-lg text-white font-medium no-underline transition-all duration-300 hover:-translate-y-0.5"
                style={{
                  background: "linear-gradient(135deg, #51845C, #2563EB)",
                  fontSize: "0.9rem",
                  boxShadow: "0 4px 15px rgba(81, 132, 92, 0.3)"
                }}
              >
                <svg className="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                  <path strokeLinecap="round" strokeLinejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Contact
              </a>

              <button onClick={() => setOpen(!open)} className="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="#1f2020" strokeWidth={2}>
                  <path strokeLinecap="round" strokeLinejoin="round"
                    d={open ? "M6 18L18 6M6 6l12 12" : "M4 6h16M4 12h16M4 18h16"} />
                </svg>
              </button>
            </div>
          </div>
        </nav>

        {/* Mobile Menu Overlay */}
        {open && (
          <div
            className="md:hidden fixed inset-0 z-40"
            style={{ backgroundColor: "rgba(0,0,0,0.4)" }}
            onClick={() => setOpen(false)}
          >
            <div
              className="absolute right-0 top-0 h-full w-72 bg-white shadow-2xl p-6 pt-20"
              style={{ animation: "slideInRight 0.3s ease" }}
              onClick={e => e.stopPropagation()}
            >
              <div className="space-y-1">
                {items.map((item, i) => (
                  <a
                    key={i}
                    href={item.href}
                    className="flex items-center px-4 py-3 rounded-lg no-underline transition-all duration-200 hover:bg-gray-50"
                    style={{
                      fontFamily: "var(--font-base)",
                      color: "<?= $currentPage ?>" === item.file ? "#51845C" : "#374151",
                      fontWeight: "<?= $currentPage ?>" === item.file ? "600" : "400",
                      backgroundColor: "<?= $currentPage ?>" === item.file ? "#dcfce7" : "transparent"
                    }}
                  >
                    {item.name}
                  </a>
                ))}
              </div>
              <div className="mt-6 pt-6" style={{ borderTop: "1px solid #e5e7eb" }}>
                <a
                  href="<?= BASE_URL ?>contact"
                  className="flex items-center justify-center px-5 py-3 rounded-lg text-white font-medium no-underline"
                  style={{
                    background: "linear-gradient(135deg, #51845C, #2563EB)",
                    boxShadow: "0 4px 15px rgba(81, 132, 92, 0.3)"
                  }}
                >
                  <svg className="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                    <path strokeLinecap="round" strokeLinejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  Contactez-nous
                </a>
              </div>
            </div>
          </div>
        )}

        <style>{`
          @keyframes slideInRight {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
          }
        `}</style>
      </>
    );
  }

  ReactDOM.createRoot(document.getElementById("header-root")).render(<Header />);
</script>
