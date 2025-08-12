<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Header React Root -->
<div id="header-root"></div>

<!-- Header Component -->
<script type="text/babel">
  const { useState, useEffect, useRef } = React;

  function Header() {
    const [open, setOpen] = useState(false);
    const [activeIndex, setActiveIndex] = useState(0);
    const [highlight, setHighlight] = useState({ left: 0, width: 0 });
    const navRefs = useRef([]);

    const items = [
      { name: "Accueil", href: "<?= BASE_URL ?>", file: "index.php" },
      { name: "Projets réalisés", href: "<?= BASE_URL ?>/NosProjets", file: "NosProjets.php" },
      { name: "Nos services", href: "<?= BASE_URL ?>/Services", file: "Services.php" },
      { name: "À propos", href: "<?= BASE_URL ?>/Apropos", file: "Apropos.php" },
      { name: "Contact", href: "<?= BASE_URL ?>/Contact", file: "Contact.php" }
    ];

    useEffect(() => {
      const current = "<?= $currentPage ?>";
      const index = items.findIndex(item => item.file === current);
      setActiveIndex(index !== -1 ? index : 0);
    }, []);


    useEffect(() => {
      const timeout = setTimeout(() => {
        const el = navRefs.current[activeIndex];
        if (el) {
          const span = el.querySelector("span");
          if (span) {
            const left = span.offsetLeft + el.offsetLeft - 12;
            const width = span.offsetWidth + 24;
            setHighlight({ left, width });
          }
        }
      }, 50); // léger délai pour laisser le temps au DOM/CSS

      return () => clearTimeout(timeout);
    }, [activeIndex]);


    return (
      <nav style={{ backgroundColor: "var(--color-white)", color: "var(--color-black)", fontFamily: "var(--font-tinos)"}} className="px-6 py-4 rounded-md">
        <div className="max-w-7xl mx-auto flex items-center justify-between">
          <a href="<?= BASE_URL ?>" className="flex items-center space-x-2">
            <img src="<?= BASE_URL ?>/asset/img/logo.png" alt="Logo" className="w-12 h-12" />
            <span style={{ fontFamily: "var(--font-heading)" }} className="text-l font-bold">&lt;Alex²/&gt;</span>
          </a>

          <button onClick={() => setOpen(!open)} className="md:hidden">
            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" style={{ stroke: "black" }}>
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                d={open ? "M6 18L18 6M6 6l12 12" : "M4 6h16M4 12h16M4 18h16"} />
            </svg>
          </button>

          <div className="hidden md:flex space-x-6 relative" style={{ fontFamily: "var(--font-base)", position: "relative" }}>
            <div
              className="absolute rounded transition-all duration-500 ease-out"
              style={{
                width: `${highlight.width}px`,
                left: `${highlight.left}px`,
                backgroundColor: "black",
                top: "50%",
                transform: "translateY(-50%)",
                height: "2em",
                borderRadius: "0.5rem",
                zIndex: 0,
                pointerEvents: "none",
                position: "absolute"
              }}
            />
            {items.map((item, i) => (
              <a
                key={i}
                href={item.href}
                className="relative nav-button px-1 font-medium"
                ref={el => navRefs.current[i] = el}
                style={{ color: i === activeIndex ? "white" : "black", zIndex: 10 }}
                onMouseEnter={() => setActiveIndex(i)}
              >
                <span>{item.name}</span>
              </a>
            ))}
          </div>
        </div>

        {open && (
          <div className="md:hidden mt-4 space-y-2">
            {items.map((item, i) => (
              <a
                key={i}
                href={item.href}
                className="block bg-white px-4 py-2 rounded shadow"
                style={{ fontFamily: "var(--font-base)", color: "black" }}
              >
                {item.name}
              </a>
            ))}
          </div>
        )}
      </nav>
    );
  }

  ReactDOM.createRoot(document.getElementById("header-root")).render(<Header />);
</script>
