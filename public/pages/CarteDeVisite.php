<?php
require_once __DIR__ . '/../../config/config.php';
$currentPage = 'carte-de-visite';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Carte de visite | &lt;Alex²/&gt;</title>
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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-EFTK5TK4MM"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-EFTK5TK4MM');
    </script>
    <meta name="description" content="Carte de visite digitale d'Alex² – Duo de développeurs web à Tarbes et Lourdes. Ajoutez Alexis et Alexandre directement à vos contacts.">
    <link rel="canonical" href="https://alex2.dev/carte-de-visite">

    <!-- Fonts carte -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;600&family=Syne:wght@400;700;800&display=swap" rel="stylesheet">

    <style>
      html, body { margin: 0; padding: 0; overflow: hidden; }

      /* === SECTION CARTE === */
      .cv-section {
        background: #0a0a0f;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100dvh;
        box-sizing: border-box;
        padding: 16px;
        user-select: none;
      }

      .cv-hint {
        font-family: 'JetBrains Mono', monospace;
        font-size: 11px;
        color: #334155;
        margin-bottom: 16px;
        letter-spacing: 0.5px;
      }
      .cv-hint span { color: #22c55e; }

      .cv-scene {
        width: min(340px, 92vw);
        height: min(650px, calc(100dvh - 32px));
        perspective: 1000px;
        cursor: grab;
      }
      .cv-scene:active { cursor: grabbing; }

      .cv-card-wrapper {
        width: 100%; height: 100%;
        position: relative;
        transform-style: preserve-3d;
      }

      .cv-face {
        position: absolute; inset: 0;
        border-radius: 20px; overflow: hidden;
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
      }
      .cv-face-back { transform: rotateY(180deg); }

      /* === RECTO === */
      .cv-recto {
        background: #0d0d1a;
        box-shadow: 0 30px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.05);
      }

      .cv-code-bg {
        position: absolute; inset: 0;
        font-family: 'JetBrains Mono', monospace;
        font-size: 11px; line-height: 1.7; padding: 16px;
        opacity: 0.18; overflow: hidden; white-space: pre;
        animation: cvScrollCode 20s linear infinite;
      }
      @keyframes cvScrollCode {
        0%   { transform: translateY(0); }
        100% { transform: translateY(-50%); }
      }

      .cv-kw  { color: #F92AAD; }
      .cv-fn  { color: #36F9F6; }
      .cv-str { color: #FF8B39; }
      .cv-cmt { color: #6272A4; }
      .cv-var { color: #E8D379; }
      .cv-num { color: #F97E72; }

      .cv-overlay {
        position: absolute; inset: 0;
        background:
          radial-gradient(ellipse at 30% 20%, rgba(67,56,202,0.45) 0%, transparent 60%),
          radial-gradient(ellipse at 80% 80%, rgba(124,58,237,0.3) 0%, transparent 55%),
          linear-gradient(180deg, rgba(13,13,26,0.2) 0%, rgba(13,13,26,0.75) 60%, rgba(13,13,26,0.98) 100%);
      }

      .cv-accent-line {
        position: absolute; top: 0; left: 28px;
        width: 2px; height: 180px;
        background: linear-gradient(180deg, transparent, #22c55e, transparent);
        opacity: 0.7;
      }

      .cv-content {
        position: absolute; inset: 0;
        display: flex; flex-direction: column; padding: 32px 28px;
      }

      .cv-tag-open { font-family: 'JetBrains Mono', monospace; font-size: 13px; color: #64748b; margin-bottom: 6px; }
      .cv-name { font-size: 46px; font-weight: 800; color: #fff; letter-spacing: -1px; line-height: 1; font-family: 'Syne', sans-serif; }
      .cv-name sup { font-size: 22px; vertical-align: super; color: #22c55e; }
      .cv-subtitle { font-family: 'JetBrains Mono', monospace; font-size: 12px; color: #94a3b8; margin-top: 10px; }

      .cv-members { display: flex; flex-direction: column; gap: 10px; margin: 28px 0; }
      .cv-member {
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(10px); border-radius: 12px; padding: 12px 16px;
        display: flex; align-items: center; gap: 12px;
        cursor: pointer; transition: background 0.2s, transform 0.15s, border-color 0.2s;
      }
      .cv-member:hover {
        background: rgba(255,255,255,0.11); border-color: rgba(255,255,255,0.18);
        transform: translateX(3px);
      }
      .cv-member-add-icon {
        margin-left: auto; color: #22c55e; opacity: 0;
        transition: opacity 0.2s; font-size: 20px; line-height: 1;
        font-weight: 300; flex-shrink: 0;
      }
      .cv-member:hover .cv-member-add-icon { opacity: 1; }
      .cv-member-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
      .cv-member-dot.green { background: #22c55e; box-shadow: 0 0 8px #22c55e; }
      .cv-member-dot.blue  { background: #6366f1; box-shadow: 0 0 8px #6366f1; }
      .cv-member-name { font-size: 14px; font-weight: 700; color: #f1f5f9; }
      .cv-member-role { font-family: 'JetBrains Mono', monospace; font-size: 10px; color: #64748b; margin-top: 1px; }

      .cv-code-snippet {
        font-family: 'JetBrains Mono', monospace; font-size: 11px; line-height: 1.8;
        margin: 16px 0; border-left: 2px solid rgba(99,102,241,0.4); padding-left: 12px; color: #64748b;
      }

      .cv-contact { display: flex; flex-direction: column; gap: 8px; margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.06); }
      .cv-contact-item { display: flex; align-items: center; gap: 10px; font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #94a3b8; }
      .cv-contact-icon { width: 18px; height: 18px; color: #22c55e; flex-shrink: 0; }
      .cv-location { font-size: 10px; color: #475569; margin-top: 4px; }

      /* === VERSO === */
      .cv-verso { background: #f8fafc; box-shadow: 0 30px 80px rgba(0,0,0,0.4); }

      .cv-code-bg-light {
        position: absolute; inset: 0;
        font-family: 'JetBrains Mono', monospace; font-size: 11px; line-height: 1.7;
        padding: 16px; opacity: 0.06; overflow: hidden; white-space: pre; color: #1e293b;
        animation: cvScrollCode 25s linear infinite reverse;
      }

      .cv-verso-content { position: absolute; inset: 0; display: flex; flex-direction: column; padding: 32px 28px; }

      .cv-verso-logo { font-family: 'Syne', sans-serif; font-size: 32px; font-weight: 800; color: #0f172a; letter-spacing: -1px; }
      .cv-verso-logo sup { font-size: 16px; color: #22c55e; }
      .cv-verso-logo .cv-v-slash { color: #6366f1; font-weight: 300; }
      .cv-verso-tagline { font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #64748b; margin-top: 6px; }
      .cv-verso-divider { width: 40px; height: 2px; background: linear-gradient(90deg, #22c55e, #6366f1); margin: 20px 0; border-radius: 2px; }

      .cv-verso-services { display: flex; flex-direction: column; gap: 10px; flex: 1; }
      .cv-service { display: flex; align-items: flex-start; gap: 12px; }
      .cv-service-icon {
        width: 32px; height: 32px; border-radius: 8px; background: #f1f5f9;
        border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; color: #6366f1;
      }
      .cv-service-title { font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 2px; }
      .cv-service-desc { font-family: 'JetBrains Mono', monospace; font-size: 10px; color: #94a3b8; line-height: 1.5; }

      .cv-verso-bottom { margin-top: auto; padding-top: 20px; border-top: 1px solid #e2e8f0; }
      .cv-eco-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 20px;
        padding: 6px 12px; font-family: 'JetBrains Mono', monospace; font-size: 10px;
        color: #16a34a; margin-bottom: 14px;
      }
      .cv-verso-contacts { display: flex; flex-direction: column; gap: 7px; }
      .cv-verso-contact-item { display: flex; align-items: center; gap: 8px; font-family: 'JetBrains Mono', monospace; font-size: 10px; color: #475569; }
      .cv-v-icon { width: 14px; height: 14px; color: #22c55e; flex-shrink: 0; }
      .cv-verso-slogan { font-size: 11px; color: #94a3b8; margin-top: 12px; font-style: italic; }
    </style>
</head>
<body style="background-color: #0a0a0f; margin: 0;">

<section id="content">
  <div class="cv-section">

    <div class="cv-scene" id="cv-scene">
      <div class="cv-card-wrapper" id="cv-card">

        <!-- RECTO -->
        <div class="cv-face cv-recto">
          <div class="cv-code-bg" aria-hidden="true"><span class="cv-cmt">// Alex² – buildGreenWebsite()</span>
<span class="cv-kw">class</span> <span class="cv-fn">WebProject</span> {
  <span class="cv-kw">private</span> <span class="cv-var">$values</span> = [
    <span class="cv-str">'performance'</span>,
    <span class="cv-str">'sobriété'</span>,
    <span class="cv-str">'accessibilité'</span>,
  ];

  <span class="cv-kw">public function</span> <span class="cv-fn">build</span>(): <span class="cv-fn">array</span> {
    <span class="cv-kw">return</span> <span class="cv-fn">array_filter</span>(
      <span class="cv-var">$this</span>-><span class="cv-var">values</span>,
      <span class="cv-fn">fn</span>(<span class="cv-var">$v</span>) => <span class="cv-var">$v</span> !== <span class="cv-str">'superflu'</span>
    );
  }

  <span class="cv-kw">public function</span> <span class="cv-fn">getApi</span>(<span class="cv-var">$route</span>) {
    <span class="cv-var">$data</span> = <span class="cv-var">$this</span>-><span class="cv-fn">db</span>
      -><span class="cv-fn">cache</span>(<span class="cv-num">3600</span>)
      -><span class="cv-fn">query</span>(<span class="cv-var">$route</span>);
    <span class="cv-kw">return new</span> <span class="cv-fn">JsonResponse</span>(<span class="cv-var">$data</span>);
  }
}

<span class="cv-cmt">// Déploiement sobre</span>
<span class="cv-var">$server</span> = <span class="cv-kw">new</span> <span class="cv-fn">DockerContainer</span>([
  <span class="cv-str">'image'</span>  => <span class="cv-str">'php:8.3-fpm'</span>,
  <span class="cv-str">'nginx'</span>  => <span class="cv-num">true</span>,
  <span class="cv-str">'green'</span>  => <span class="cv-num">true</span>,
]);

<span class="cv-kw">function</span> <span class="cv-fn">optimise</span>(<span class="cv-var">$code</span>): <span class="cv-fn">string</span> {
  <span class="cv-cmt">// Moins de requêtes, plus d'impact</span>
  <span class="cv-kw">return</span> <span class="cv-fn">trim</span>(<span class="cv-var">$code</span>);
}

<span class="cv-cmt">// Alex² – buildGreenWebsite()</span>
<span class="cv-kw">class</span> <span class="cv-fn">WebProject</span> {
  <span class="cv-kw">private</span> <span class="cv-var">$values</span> = [
    <span class="cv-str">'performance'</span>,
    <span class="cv-str">'sobriété'</span>,
  ];
  <span class="cv-kw">public function</span> <span class="cv-fn">build</span>() {
    <span class="cv-kw">return</span> <span class="cv-fn">array_filter</span>(
      <span class="cv-var">$this</span>-><span class="cv-var">values</span>
    );
  }
}
<span class="cv-var">$router</span>-><span class="cv-fn">get</span>(<span class="cv-str">'/api/projects'</span>,
  <span class="cv-kw">function</span>() {
    <span class="cv-kw">return</span> <span class="cv-fn">json_encode</span>(<span class="cv-var">$projects</span>);
  }
);
</div>
          <div class="cv-overlay"></div>
          <div class="cv-accent-line"></div>
          <div class="cv-content">
            <div>
              <div class="cv-tag-open">&lt;développeurs /&gt;</div>
              <div class="cv-name">Alex<sup>2</sup></div>
              <div class="cv-subtitle">Duo web · Tarbes & Lourdes · 65</div>
            </div>
            <div class="cv-members">
              <div class="cv-member" data-name="Alexis" data-phone="+33768882768" data-role="Back-end · PHP · APIs · Docker" title="Appuyer pour ajouter le contact">
                <div class="cv-member-dot green"></div>
                <div class="cv-member-info">
                  <div class="cv-member-name">Alexis</div>
                  <div class="cv-member-role">Back-end · PHP · APIs · Docker</div>
                </div>
                <div class="cv-member-add-icon">＋</div>
              </div>
              <div class="cv-member" data-name="Alexandre" data-phone="+33686825714" data-role="Front-end · React · UX/UI" title="Appuyer pour ajouter le contact">
                <div class="cv-member-dot blue"></div>
                <div class="cv-member-info">
                  <div class="cv-member-name">Alexandre</div>
                  <div class="cv-member-role">Front-end · React · UX/UI</div>
                </div>
                <div class="cv-member-add-icon">＋</div>
              </div>
            </div>
            <div class="cv-code-snippet">
              <span style="color:#F92AAD">function</span> <span style="color:#36F9F6">buildWebsite</span>() {<br>
              &nbsp;&nbsp;<span style="color:#F92AAD">return</span> [<span style="color:#FF8B39">"performance"</span>,<br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#FF8B39">"accessibilité"</span>,<br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#FF8B39">"sobriété"</span>];<br>
              }
            </div>
            <div class="cv-contact">
              <div class="cv-contact-item">
                <svg class="cv-contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.68A2 2 0 012 .84h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.73a16 16 0 006.29 6.29l1.25-1.25a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                07 68 88 27 68 · 06 86 82 57 14
              </div>
              <div class="cv-contact-item">
                <svg class="cv-contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                contact@Alex2.dev
              </div>
              <div class="cv-contact-item">
                <svg class="cv-contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
                <a href="https://www.Alex2.dev" target="_blank" rel="noopener" style="color:inherit;text-decoration:none;">www.Alex2.dev</a>
              </div>
              <div class="cv-location">Écrire du code qui a du sens.</div>
            </div>
          </div>
        </div>

        <!-- VERSO -->
        <div class="cv-face cv-face-back cv-verso">
          <div class="cv-code-bg-light" aria-hidden="true">:root {
  --vert    : #22c55e;
  --primary : #F92AAD;
  --accent  : #36F9F6;
}

/* Du code sobre, comme nos sites */
.alex2 {
  font-weight : 400;
  color       : var(--vert);
  background  : #f8fafc;
}

.alex2__image {
  format    : webp;
  max-width : 100%;
  loading   : lazy;
}

/* Zéro superflu */
.alex2:not(:hover) {
  animation  : none;
  transition : none;
}

:root {
  --vert    : #22c55e;
  --primary : #F92AAD;
}
.alex2 {
  font-weight : 400;
  color       : var(--vert);
}
.alex2__image {
  format    : webp;
  max-width : 100%;
}
</div>
          <div class="cv-verso-content">
            <div>
              <div class="cv-verso-logo">Alex<sup>2</sup><span class="cv-v-slash">/</span></div>
              <div class="cv-verso-tagline">// Duo de développeurs web · Hautes-Pyrénées</div>
            </div>
            <div class="cv-verso-divider"></div>
            <div class="cv-verso-services">
              <div class="cv-service">
                <div class="cv-service-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                </div>
                <div>
                  <div class="cv-service-title">Sites vitrines & e-commerce</div>
                  <div class="cv-service-desc">Design sur-mesure · React · WordPress</div>
                </div>
              </div>
              <div class="cv-service">
                <div class="cv-service-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                </div>
                <div>
                  <div class="cv-service-title">Applications web & APIs</div>
                  <div class="cv-service-desc">PHP · REST · MySQL · Docker</div>
                </div>
              </div>
              <div class="cv-service">
                <div class="cv-service-icon" style="color:#22c55e">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div>
                  <div class="cv-service-title">Éco-conception web</div>
                  <div class="cv-service-desc">Performance · Sobriété · Accessibilité</div>
                </div>
              </div>
              <div class="cv-service">
                <div class="cv-service-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
                </div>
                <div>
                  <div class="cv-service-title">Maintenance & hébergement</div>
                  <div class="cv-service-desc">Suivi · Mises à jour · Sécurité</div>
                </div>
              </div>
            </div>
            <div class="cv-verso-bottom">
              <div class="cv-eco-badge">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Sites écologiquement viables
              </div>
              <div class="cv-verso-contacts">
                <div class="cv-verso-contact-item">
                  <svg class="cv-v-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
                  <a href="https://www.Alex2.dev" target="_blank" rel="noopener" style="color:inherit;text-decoration:none;">www.Alex2.dev</a>
                </div>
                <div class="cv-verso-contact-item">
                  <svg class="cv-v-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                  contact@Alex2.dev
                </div>
              </div>
              <div class="cv-verso-slogan">Écrire du code qui a du sens.</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script>
  const VCARD_BASE = '<?= BASE_URL ?>';

  const card = document.getElementById('cv-card');
  const scene = document.getElementById('cv-scene');
  let rotY = 0, flipped = false, isDragging = false;
  let startX = 0, dragDelta = 0, isAnimating = false, baseRotY = 0;

  function setRotation(y, animate = false) {
    card.style.transition = animate ? 'transform 0.6s cubic-bezier(0.4,0,0.2,1)' : 'none';
    card.style.transform = `rotateY(${y}deg)`;
  }

  function snapToNearest(currentY) {
    const mod = ((currentY % 360) + 360) % 360;
    if (mod < 90 || mod >= 270) {
      flipped = false;
      rotY = Math.round(currentY / 360) * 360;
    } else {
      flipped = true;
      rotY = Math.round((currentY - 180) / 360) * 360 + 180;
    }
    return rotY;
  }

  // SCROLL — uniquement sur la carte pour ne pas bloquer le scroll de la page
  scene.addEventListener('wheel', (e) => {
    e.preventDefault();
    if (isAnimating) return;
    const dir = e.deltaY > 0 ? 1 : -1;
    if (dir > 0 && !flipped)     { flipped = true;  rotY += 180; }
    else if (dir < 0 && flipped) { flipped = false; rotY -= 180; }
    else return;
    isAnimating = true;
    setRotation(rotY, true);
    setTimeout(() => isAnimating = false, 650);
  }, { passive: false });

  // DRAG souris
  card.addEventListener('mousedown', (e) => {
    if (isAnimating) return;
    isDragging = true; startX = e.clientX; dragDelta = 0; baseRotY = rotY;
  });
  window.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    dragDelta = e.clientX - startX;
    setRotation(baseRotY - dragDelta * 0.6);
  });
  window.addEventListener('mouseup', () => {
    if (!isDragging) return;
    isDragging = false;
    rotY = snapToNearest(baseRotY - dragDelta * 0.6);
    setRotation(rotY, true);
    isAnimating = true;
    setTimeout(() => isAnimating = false, 650);
  });

  // DRAG tactile
  card.addEventListener('touchstart', (e) => {
    if (isAnimating) return;
    startX = e.touches[0].clientX; dragDelta = 0; baseRotY = rotY;
  }, { passive: true });
  card.addEventListener('touchmove', (e) => {
    dragDelta = e.touches[0].clientX - startX;
    setRotation(baseRotY - dragDelta * 0.6);
  }, { passive: true });
  card.addEventListener('touchend', () => {
    rotY = snapToNearest(baseRotY - dragDelta * 0.6);
    setRotation(rotY, true);
    isAnimating = true;
    setTimeout(() => isAnimating = false, 650);
  });

  // CONTACT vCard
  function makeVCard(name, phone, role) {
    return [
      'BEGIN:VCARD', 'VERSION:3.0',
      'FN:' + name, 'N:;' + name + ';;;',
      'TEL;TYPE=CELL:' + phone,
      'EMAIL:contact@Alex2.dev',
      'URL:https://www.Alex2.dev',
      'TITLE:' + role,
      'ORG:Alex\u00B2',
      'END:VCARD'
    ].join('\r\n');
  }

  document.querySelectorAll('.cv-member[data-name]').forEach(el => {
    el.addEventListener('click', async () => {
      if (Math.abs(dragDelta) > 5) return;
      const name = el.dataset.name;
      const phone = el.dataset.phone;
      const role = el.dataset.role;
      const vcard = makeVCard(name, phone, role);

      // Mobile : navigation vers le PHP → Content-Type: text/vcard → Contacts
      if (/Android|iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        window.location.href = VCARD_BASE + 'asset/carte-de-visite/' + name.toLowerCase() + '.php';
        return;
      }

      // Desktop : téléchargement
      const url = URL.createObjectURL(new Blob([vcard], { type: 'text/vcard' }));
      const a = document.createElement('a');
      a.href = url; a.download = name + '.vcf';
      document.body.appendChild(a); a.click();
      document.body.removeChild(a); URL.revokeObjectURL(url);
    });
  });
</script>
</body>
</html>
