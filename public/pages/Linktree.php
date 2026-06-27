<?php
require_once __DIR__ . '/../../config/config.php';
$currentPage = 'linktree';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alex² · Links</title>
  <link rel="icon" href="<?= BASE_URL ?>Alex2logo.png" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;600&family=Syne:wght@400;700;800&display=swap" rel="stylesheet">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            mono: ['"JetBrains Mono"', 'monospace'],
            display: ['Syne', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <!-- React 18 + Babel CDN -->
  <script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
  <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      background: #0a0a0f;
      min-height: 100dvh;
      overflow-x: hidden;
      font-family: 'Syne', sans-serif;
    }

    /* ── Code rain background ── */
    .code-rain {
      position: fixed; inset: 0;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px; line-height: 1.7; padding: 20px;
      opacity: 0.07; overflow: hidden; white-space: pre;
      pointer-events: none; z-index: 0; color: #22c55e;
      animation: scrollUp 38s linear infinite;
    }
    @keyframes scrollUp {
      from { transform: translateY(0); }
      to   { transform: translateY(-50%); }
    }

    /* ── Ambient gradients ── */
    .ambient {
      position: fixed; inset: 0; pointer-events: none; z-index: 0;
      background:
        radial-gradient(ellipse at 15% 10%,  rgba(99,102,241,.22)  0%, transparent 55%),
        radial-gradient(ellipse at 88% 85%,  rgba(249,42,173,.13)  0%, transparent 50%),
        radial-gradient(ellipse at 55% 42%,  rgba(54,249,246,.07)  0%, transparent 45%);
    }

    /* ── Accent vertical line ── */
    .accent-line {
      position: fixed; top: 0; left: 28px;
      width: 2px; height: 220px; pointer-events: none; z-index: 0;
      background: linear-gradient(180deg, transparent, #22c55e55, transparent);
    }

    /* ── Animations ── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(18px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp .55s ease both; }

    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }
    .blink { animation: blink 1.1s step-end infinite; }

    /* ── Link card ── */
    .link-card {
      display: flex; align-items: center; gap: 14px;
      padding: 14px 18px; border-radius: 16px;
      border: 1px solid rgba(255,255,255,0.07);
      background: rgba(255,255,255,0.04);
      text-decoration: none;
      transition: background .2s, border-color .2s, transform .2s, box-shadow .2s;
    }
    .link-card:hover {
      background: rgba(255,255,255,0.09);
      transform: translateX(5px);
    }

    .link-icon {
      width: 44px; height: 44px; border-radius: 12px;
      background: rgba(255,255,255,0.06);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0; transition: background .2s;
    }

    .divider-grad {
      width: 40px; height: 2px;
      background: linear-gradient(90deg, #22c55e, #6366f1);
      border-radius: 2px;
    }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 2px; }
  </style>
</head>
<body>

<!-- Code rain -->
<div class="code-rain" aria-hidden="true">// Alex² – buildGreenWebsite()
class WebProject {
  private $values = [
    'performance',
    'sobriété',
    'accessibilité',
  ];

  public function build(): array {
    return array_filter(
      $this->values,
      fn($v) => $v !== 'superflu'
    );
  }

  public function getLinks(): array {
    return [
      'site'      => 'https://alex2.dev',
      'instagram' => '@alex2.dev',
      'tiktok'    => '@alex2dev',
      'linkedin'  => '/in/alex2',
      'email'     => 'contact@alex2.dev',
    ];
  }
}

// Déploiement sobre
$server = new DockerContainer([
  'image'  => 'php:8.3-fpm',
  'nginx'  => true,
  'green'  => true,
]);

function optimise($code): string {
  // Moins de requêtes, plus d'impact
  return trim($code);
}

.alex2-link {
  display: flex;
  align-items: center;
  transition: transform .2s ease;
  border: 1px solid rgba(255,255,255,0.07);
  border-radius: 16px;
  background: rgba(255,255,255,0.04);
}
.alex2-link:hover {
  transform: translateX(5px);
  box-shadow: 0 0 24px rgba(34,197,94,.2);
}

const links = await fetch('/api/links')
  .then(r => r.json())
  .catch(() => []);

links.forEach(link => {
  const el = document.createElement('a');
  el.href = link.url;
  el.textContent = link.label;
  document.body.appendChild(el);
});

// Alex² – buildGreenWebsite()
class WebProject {
  private $values = [
    'performance',
    'sobriété',
  ];
  public function build() {
    return array_filter($this->values);
  }
}
$router->get('/api/projects', function() {
  return json_encode($projects);
});
</div>

<div class="ambient" aria-hidden="true"></div>
<div class="accent-line" aria-hidden="true"></div>

<div id="root" style="position:relative;z-index:1;"></div>

<script type="text/babel">
const { useState } = React;

const LINKS = [
  {
    id: 'site',
    label: 'Notre site web',
    handle: 'www.alex2.dev',
    url: 'https://www.alex2.dev',
    color: '#22c55e',
    cmd: 'open()',
    icon: (
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
        <circle cx="12" cy="12" r="10"/>
        <line x1="2" y1="12" x2="22" y2="12"/>
        <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>
      </svg>
    ),
  },
  {
    id: 'instagram',
    label: 'Instagram',
    handle: '@alex2.dev',
    url: 'https://www.instagram.com/alex2.dev/',
    color: '#F92AAD',
    cmd: 'follow()',
    icon: (
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
        <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/>
        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" strokeWidth="2.5"/>
      </svg>
    ),
  },
  {
    id: 'tiktok',
    label: 'TikTok',
    handle: '@alex2_dev',
    url: 'https://www.tiktok.com/@alex2_dev',
    color: '#36F9F6',
    cmd: 'watch()',
    icon: (
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
        <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.8a8.27 8.27 0 004.84 1.55V6.91a4.85 4.85 0 01-1.07-.22z"/>
      </svg>
    ),
  },
  {
    id: 'linkedin',
    label: 'LinkedIn',
    handle: '/company/alex2',
    url: 'https://www.linkedin.com/company/alex2/',
    color: '#6366f1',
    cmd: 'connect()',
    icon: (
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
        <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/>
        <circle cx="4" cy="4" r="2"/>
      </svg>
    ),
  },
  {
    id: 'email',
    label: 'Nous écrire',
    handle: 'contact@alex2.dev',
    url: 'mailto:contact@alex2.dev',
    color: '#FF8B39',
    cmd: 'send()',
    icon: (
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
        <polyline points="22,6 12,13 2,6"/>
      </svg>
    ),
  },
];

function LinkCard({ link }) {
  const [hovered, setHovered] = useState(false);
  const isExternal = !link.url.startsWith('mailto') && !link.url.startsWith('.');

  return (
    <a
      href={link.url}
      target={isExternal ? '_blank' : '_self'}
      rel={isExternal ? 'noopener noreferrer' : undefined}
      className="link-card"
      onMouseEnter={() => setHovered(true)}
      onMouseLeave={() => setHovered(false)}
      style={{
        borderColor: hovered ? `${link.color}40` : undefined,
        boxShadow:   hovered ? `0 4px 28px ${link.color}18` : undefined,
      }}
    >
      <div
        className="link-icon"
        style={{
          background: hovered ? `${link.color}1a` : undefined,
          color: link.color,
        }}
      >
        {link.icon}
      </div>

      <div style={{ flex: 1, minWidth: 0 }}>
        <div style={{
          fontFamily: 'Syne, sans-serif',
          fontSize: '14px', fontWeight: 700,
          color: 'rgba(255,255,255,.92)',
          marginBottom: '3px',
        }}>
          {link.label}
        </div>
        <div style={{
          fontFamily: 'JetBrains Mono, monospace',
          fontSize: '11px', color: '#64748b',
          whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis',
        }}>
          <span style={{ color: '#334155' }}>{link.cmd} → </span>
          <span style={{ color: hovered ? link.color : '#94a3b8', transition: 'color .2s' }}>
            {link.handle}
          </span>
        </div>
      </div>

      <span style={{
        fontFamily: 'JetBrains Mono, monospace',
        fontSize: '16px',
        color: link.color,
        opacity: hovered ? 1 : 0.25,
        transform: hovered ? 'translateX(3px)' : 'none',
        transition: 'opacity .2s, transform .2s',
        flexShrink: 0,
      }}>→</span>
    </a>
  );
}

function App() {
  return (
    <div style={{
      minHeight: '100dvh',
      display: 'flex', flexDirection: 'column',
      alignItems: 'center', justifyContent: 'center',
      padding: '52px 20px',
    }}>

      <div className="fade-up" style={{ textAlign: 'center', marginBottom: '32px', animationDelay: '0s' }}>
        <div style={{
          fontFamily: 'JetBrains Mono, monospace', fontSize: '12px',
          color: '#334155', marginBottom: '10px', letterSpacing: '.5px',
        }}>
          &lt;<span style={{ color: '#F92AAD' }}>alex2</span> /&gt;
        </div>

        <h1 style={{
          fontFamily: 'Syne, sans-serif',
          fontSize: 'clamp(50px, 16vw, 68px)',
          fontWeight: 800, color: '#fff',
          letterSpacing: '-2px', lineHeight: 1,
        }}>
          Alex<sup style={{ fontSize: '.44em', color: '#22c55e', verticalAlign: 'super' }}>2</sup>
        </h1>

        <div style={{
          fontFamily: 'JetBrains Mono, monospace', fontSize: '12px',
          color: '#94a3b8', marginTop: '14px',
          display: 'flex', alignItems: 'center',
          justifyContent: 'center', gap: '6px', flexWrap: 'wrap',
        }}>
          <span style={{ color: '#F92AAD' }}>duo</span>
          <span style={{ color: '#334155' }}>::</span>
          <span style={{ color: '#36F9F6' }}>web_developers</span>
          <span className="blink" style={{ color: '#22c55e' }}>▋</span>
        </div>

        <div style={{
          fontFamily: 'JetBrains Mono, monospace', fontSize: '10px',
          color: '#334155', marginTop: '7px', letterSpacing: '.3px',
        }}>
          // Tarbes &amp; Lourdes · Hautes-Pyrénées
        </div>
      </div>

      <div className="fade-up divider-grad" style={{ marginBottom: '28px', animationDelay: '.1s' }} />

      <div style={{
        width: '100%', maxWidth: '390px',
        display: 'flex', flexDirection: 'column', gap: '10px',
      }}>
        {LINKS.map((link, i) => (
          <div key={link.id} className="fade-up" style={{ animationDelay: `${.18 + i * .08}s` }}>
            <LinkCard link={link} />
          </div>
        ))}
      </div>

      <div className="fade-up" style={{
        fontFamily: 'JetBrains Mono, monospace', fontSize: '10px',
        color: '#334155', marginTop: '44px', textAlign: 'center',
        animationDelay: '.85s',
      }}>
        <span style={{ color: '#22c55e' }}>✓</span> Écrire du code qui a du sens.
      </div>
    </div>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(<App />);
</script>
</body>
</html>
