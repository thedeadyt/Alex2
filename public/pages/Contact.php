<?php
// Traitement POST JSON (AJAX)
if ($_SERVER["REQUEST_METHOD"] === "POST" && strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
    header('Content-Type: application/json');

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    if (json_last_error() !== JSON_ERROR_NONE || !is_array($input)) {
        echo json_encode(['success' => false, 'message' => 'Données JSON invalides']);
        exit;
    }

    $recaptcha_secret = '6LfjEHQrAAAAAGR2TA9vJhZLRcpf3qPGITGMa-Tv';
    $recaptcha_response = $input['g-recaptcha-response'] ?? '';
    $remote_ip = $_SERVER['REMOTE_ADDR'] ?? '';

    $consent = isset($input['consent']) && $input['consent'] === true;

    $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response,
        'remoteip' => $remote_ip,
    ]));
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) {
        echo json_encode(['success' => false, 'recaptchaError' => true]);
        exit;
    }

    $captcha = json_decode($response);

    if (empty($captcha->success) || !$consent) {
        echo json_encode(['success' => false, 'recaptchaError' => true]);
        exit;
    }

    require 'SendMailFunction.php';

    $infos = [
        'nom' => htmlspecialchars(trim($input["nom"] ?? ''), ENT_QUOTES, 'UTF-8'),
        'prenom' => htmlspecialchars(trim($input["prenom"] ?? ''), ENT_QUOTES, 'UTF-8'),
        'email' => htmlspecialchars(trim($input["email"] ?? ''), ENT_QUOTES, 'UTF-8'),
        'telephone' => htmlspecialchars(trim($input["telephone"] ?? ''), ENT_QUOTES, 'UTF-8'),
        'entreprise' => htmlspecialchars(trim($input["societe"] ?? ''), ENT_QUOTES, 'UTF-8'),
        'budget' => htmlspecialchars(trim($input["budget"] ?? ''), ENT_QUOTES, 'UTF-8'),
        'sujet' => htmlspecialchars(trim($input["objet"] ?? ''), ENT_QUOTES, 'UTF-8'),
        'message' => htmlspecialchars(trim($input["message"] ?? ''), ENT_QUOTES, 'UTF-8'),
    ];

    $form_success = EnvoieMailFormulaire($infos);
    echo json_encode(['success' => (bool)$form_success, 'recaptchaError' => false]);
    exit;
}

require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contact | &lt;Alex²/&gt;</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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

  <!-- React CDN -->
  <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-EFTK5TK4MM"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-EFTK5TK4MM');
  </script>
  <meta name="description" content="Contactez <Alex²/>, agence de développement web à Tarbes et Lourdes (65), pour discuter de votre projet de site internet ou demander un devis.">

  <link rel="canonical" href="https://alex2.dev/contact">

  <meta property="og:title" content="Contact | <Alex²/> - Développement web 65">
  <meta property="og:description" content="Prenez contact avec <Alex²/> pour vos projets web dans les Hautes-Pyrénées : création de sites vitrines, e-commerce et solutions sur mesure.">
  <meta property="og:url" content="https://alex2.dev/contact">

  <meta name="twitter:title" content="Contact | <Alex²/> - Développement web 65">
  <meta name="twitter:description" content="Contactez <Alex²/> pour discuter de votre projet de site internet à Tarbes et Lourdes (65).">


    <!-- Local Business JSON-LD (SEO Local) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "<Alex²/>",
      "image": "https://alex2.dev/Alex2logo.png",
      "url": "https://alex2.dev",
      "telephone": ["+33768882766", "+33686825714"],
      "priceRange": "€€",
      "address": [
          {
            "@type": "PostalAddress",
            "streetAddress": "8 Rue Charles Baudelaire",
            "addressLocality": "Lourdes",
            "postalCode": "65100",
            "addressCountry": "FR"
          },
          {
            "@type": "PostalAddress",
            "streetAddress": "8 Rue Georges Lassalle",
            "addressLocality": "Tarbes",
            "postalCode": "65000",
            "addressCountry": "FR"
          }
        ],
        "geo": [
          {
            "@type": "GeoCoordinates",
            "latitude": 43.0956,
            "longitude": 0.0475
          },
          {
            "@type": "GeoCoordinates",
            "latitude": 43.2330,
            "longitude": 0.0660
          }
        ],
      "sameAs": [
        "https://www.instagram.com/alex2.dev",
        "https://www.linkedin.com/company/alex2",
        "https://github.com/Alex2-dev"
      ],
      "description": "<Alex²/> est une agence de développement web basée à Tarbes et Lourdes (65). Spécialiste en création de sites internet modernes, performants et écoresponsables dans les Hautes-Pyrénées."
    }
    </script>
</head>

<body style="background-color: var(--color-white); color: var(--color-black);">
<?php include __DIR__ . '/../../includes/header.php'; ?>

<section id="content">
  <!-- Hero Section -->
  <section class="relative py-20 px-6 overflow-hidden" style="background-color: var(--color-white);">
    <div class="max-w-7xl mx-auto text-center relative z-10">
      <span class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-base font-black mb-6" style="font-family: var(--font-bounded);">
        Parlons de votre projet
      </span>
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6" style="font-family: var(--font-bounded); color: var(--color-black);">
        <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">Contactez-nous</span>
      </h1>
      <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto mb-8" style="font-family: var(--font-tinos);">
        Une idée de projet web ? Besoin d'un devis ? Nous sommes là pour vous accompagner dans les <strong>Hautes-Pyrénées</strong> et partout en France.
      </p>
    </div>
  </section>

  <!-- Form & Contact Info Section -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-7xl mx-auto">
      <div class="grid lg:grid-cols-2 gap-12">
        <!-- Contact Form -->
        <div>
          <div id="react-contact-form"></div>
        </div>

        <!-- Contact Info Cards -->
        <div class="space-y-6">
          <!-- Who We Are Card -->
          <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-2xl p-8 border-2 border-blue-200">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-blue-500 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
                  <path strokeLinecap="round" strokeLinejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <h3 class="text-3xl font-black" style="font-family: var(--font-bounded); color: var(--color-black);">
                Qui sommes-nous ?
              </h3>
            </div>
            <p class="text-gray-700 leading-relaxed" style="font-family: var(--font-tinos);">
              Deux développeurs indépendants passionnés travaillant en collaboration sous le nom <strong style="color: var(--color-green);">&lt;alex²/&gt;</strong>. Que vous nous contactiez pour un site web, une refonte, du conseil ou du développement spécifique, vous serez pris en charge par l'un de nous deux selon vos besoins.
            </p>
          </div>

          <!-- Contact Methods -->
          <div class="grid md:grid-cols-2 gap-4">
            <!-- Phone Card -->
            <div class="bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-green-200 transition-all duration-300 hover:shadow-lg">
              <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
                  <path strokeLinecap="round" strokeLinejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <h4 class="font-black mb-2 text-base" style="font-family: var(--font-bounded); color: var(--color-black);">Téléphone</h4>
              <p class="text-sm text-gray-700 mb-1" style="font-family: var(--font-tinos);">
                <strong>Alexis</strong><br/>
                <a href="tel:+33768882766" class="text-green-600 hover:underline">+33 7 68 88 27 66</a>
              </p>
              <p class="text-sm text-gray-700" style="font-family: var(--font-tinos);">
                <strong>Alexandre</strong><br/>
                <a href="tel:+33686825714" class="text-green-600 hover:underline">+33 6 86 82 57 14</a>
              </p>
            </div>

            <!-- Email Card -->
            <div class="bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-blue-200 transition-all duration-300 hover:shadow-lg">
              <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
                  <path strokeLinecap="round" strokeLinejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <h4 class="font-black mb-2 text-base" style="font-family: var(--font-bounded); color: var(--color-black);">Email</h4>
              <p class="text-sm text-gray-700 mb-1" style="font-family: var(--font-tinos);">
                <strong>Alexis</strong><br/>
                <a href="mailto:alexis.rodrigues@alex2.dev" class="text-blue-600 hover:underline">alexis.rodrigues@alex2.dev</a>
              </p>
              <p class="text-sm text-gray-700 mb-1" style="font-family: var(--font-tinos);">
                <strong>Alexandre</strong><br/>
                <a href="mailto:alexandre.bouvy@alex2.dev" class="text-blue-600 hover:underline">alexandre.bouvy@alex2.dev</a>
              </p>
              <p class="text-sm text-gray-700" style="font-family: var(--font-tinos);">
                <strong>Contact</strong><br/>
                <a href="mailto:contact@alex2.dev" class="text-blue-600 hover:underline">contact@alex2.dev</a>
              </p>
            </div>

            <!-- Hours Card -->
            <div class="bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-green-200 transition-all duration-300 hover:shadow-lg">
              <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
                  <path strokeLinecap="round" strokeLinejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <h4 class="font-black mb-2 text-base" style="font-family: var(--font-bounded); color: var(--color-black);">Horaires</h4>
              <p class="text-sm text-gray-700" style="font-family: var(--font-tinos);">
                Lundi - Vendredi<br/>
                9h - 18h
              </p>
            </div>

            <!-- Location Card -->
            <div class="bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-blue-200 transition-all duration-300 hover:shadow-lg">
              <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
                  <path strokeLinecap="round" strokeLinejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path strokeLinecap="round" strokeLinejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <h4 class="font-black mb-2 text-base" style="font-family: var(--font-bounded); color: var(--color-black);">Localisation</h4>
              <p class="text-sm text-gray-700" style="font-family: var(--font-tinos);">
                Tarbes & Lourdes<br/>
                Hautes-Pyrénées (65)
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Maps Section -->
  <section class="py-20 px-6" style="background-color: var(--color-white);">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-12">
        <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-base font-black mb-4" style="font-family: var(--font-bounded);">
          Nos bureaux
        </span>
        <h2 class="text-3xl md:text-4xl font-black mb-4" style="color: var(--color-black); font-family: var(--font-bounded);">
          Où nous trouver
        </h2>
        <p class="text-xl text-gray-600" style="font-family: var(--font-tinos);">
          Deux emplacements stratégiques dans les Hautes-Pyrénées
        </p>
      </div>

      <div class="grid md:grid-cols-2 gap-8">
        <!-- Lourdes Map -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-100">
          <div id="map-lourdes" class="w-full h-72"></div>
          <div class="p-6">
            <div class="flex items-start gap-3">
              <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                </svg>
              </div>
              <div>
                <h3 class="text-2xl font-black mb-1" style="font-family: var(--font-bounded); color: var(--color-black);">Lourdes</h3>
                <p class="text-gray-700" style="font-family: var(--font-tinos);">
                  8 Rue Charles Baudelaire<br/>
                  65100 Lourdes
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Tarbes Map -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-100">
          <div id="map-tarbes" class="w-full h-72"></div>
          <div class="p-6">
            <div class="flex items-start gap-3">
              <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                </svg>
              </div>
              <div>
                <h3 class="text-2xl font-black mb-1" style="font-family: var(--font-bounded); color: var(--color-black);">Tarbes</h3>
                <p class="text-gray-700" style="font-family: var(--font-tinos);">
                  8 Rue Georges Lassalle<br/>
                  65000 Tarbes
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</section>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

<!-- SCRIPT LEAFLET POUR LES CARTES -->
<script>
  const rootStyles = getComputedStyle(document.documentElement);
  const colorWhite = rootStyles.getPropertyValue('--color-white').trim() || '#e8e8e8';
  const colorBlack = rootStyles.getPropertyValue('--color-black').trim() || '#1f2020';
  const colorGreen = rootStyles.getPropertyValue('--color-green').trim() || '#51845C';

  function createCustomMap(containerId, coords, label) {
    const map = L.map(containerId, {
      zoomControl: true,
      scrollWheelZoom: true
    }).setView(coords, 17);

    map.setMinZoom(14);
    map.setMaxZoom(18);
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const markerIcon = L.divIcon({
      html: `<div style="
        background-color: ${colorGreen};
        width: 20px; height: 20px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
      "></div>`,
      className: ''
    });

    L.marker(coords, { icon: markerIcon }).addTo(map)
      .bindPopup(`<b>${label}</b>`);
  }

  createCustomMap('map-lourdes', [43.096435827627595, -0.025754975680814925], "8 Rue Charles Baudelaire, Lourdes");
  createCustomMap('map-tarbes', [43.23491777180639, 0.07188113003333478], "8 Rue Georges Lassalle, Tarbes");
</script>

<!-- REACT COMPONENT -->
<script type="text/babel">
  const { useState } = React;

  function ContactForm() {
    const [form, setForm] = useState({
      prenom: '', nom: '', societe: '', email: '', telephone: '',
      budget: '', objet: '', message: '', consent: false, 'g-recaptcha-response': ''
    });
    const [success, setSuccess] = useState(false);
    const [error, setError] = useState(false);
    const [recaptchaError, setRecaptchaError] = useState(false);
    const [isFocused, setIsFocused] = useState({});

    const handleChange = (e) => {
      const { name, value, type, checked } = e.target;
      setForm({ ...form, [name]: type === 'checkbox' ? checked : value });
    };

    const handleSubmit = async (e) => {
      e.preventDefault();
      setSuccess(false);
      setError(false);
      setRecaptchaError(false);

      if (typeof grecaptcha === 'undefined') {
        setError(true);
        setRecaptchaError(true);
        alert("reCAPTCHA non chargé");
        return;
      }

      const token = grecaptcha.getResponse();
      if (!token) {
        setError(true);
        setRecaptchaError(true);
        return;
      }

      const payload = { ...form, 'g-recaptcha-response': token };

      try {
        const res = await fetch(window.location.href, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });

        const text = await res.text();
        let result = {};
        try {
          result = JSON.parse(text);
        } catch (e) {
          setError(true);
          return;
        }

        if (result.success) {
          setSuccess(true);
          setForm({
            prenom: '', nom: '', societe: '', email: '', telephone: '',
            budget: '', objet: '', message: '', consent: false, 'g-recaptcha-response': ''
          });
          grecaptcha.reset();
        } else {
          setError(true);
          setRecaptchaError(result.recaptchaError || false);
        }
      } catch (err) {
        setError(true);
        console.error(err);
      }
    };

    return (
      <div className="bg-white rounded-2xl shadow-xl p-8 border-2 border-gray-100">
        <div className="mb-8">
          <div className="flex items-center gap-3 mb-4">
            <div className="w-12 h-12 bg-gradient-to-br from-green-500 to-blue-500 rounded-xl flex items-center justify-center">
              <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={2}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
              </svg>
            </div>
            <div>
              <h2 className="text-3xl font-black" style={{ fontFamily: 'var(--font-bounded)', color: 'var(--color-black)' }}>
                Envoyez-nous un message
              </h2>
              <p className="text-gray-600 text-sm" style={{ fontFamily: 'var(--font-tinos)' }}>
                Nous vous répondons sous 24h
              </p>
            </div>
          </div>
        </div>

        {success && (
          <div className="bg-green-50 border-2 border-green-200 text-green-800 p-4 rounded-xl mb-6 flex items-start gap-3">
            <svg className="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <strong style={{ fontFamily: 'var(--font-bounded)' }}>Message envoyé !</strong>
              <p style={{ fontFamily: 'var(--font-tinos)' }}>Merci pour votre message. Nous vous répondrons très rapidement.</p>
            </div>
          </div>
        )}

        {error && recaptchaError && (
          <div className="bg-red-50 border-2 border-red-200 text-red-800 p-4 rounded-xl mb-6 flex items-start gap-3">
            <svg className="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <strong style={{ fontFamily: 'var(--font-bounded)' }}>Erreur de validation</strong>
              <p style={{ fontFamily: 'var(--font-tinos)' }}>Veuillez cocher le reCAPTCHA et accepter le consentement.</p>
            </div>
          </div>
        )}

        {error && !recaptchaError && (
          <div className="bg-red-50 border-2 border-red-200 text-red-800 p-4 rounded-xl mb-6 flex items-start gap-3">
            <svg className="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <strong style={{ fontFamily: 'var(--font-bounded)' }}>Erreur</strong>
              <p style={{ fontFamily: 'var(--font-tinos)' }}>Une erreur est survenue. Veuillez réessayer.</p>
            </div>
          </div>
        )}

        <form onSubmit={handleSubmit} className="space-y-5" noValidate>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label className="block text-base font-black mb-2" style={{ fontFamily: 'var(--font-bounded)', color: 'var(--color-black)' }}>
                Prénom *
              </label>
              <input
                name="prenom"
                value={form.prenom}
                onChange={handleChange}
                onFocus={() => setIsFocused({...isFocused, prenom: true})}
                onBlur={() => setIsFocused({...isFocused, prenom: false})}
                type="text"
                required
                className="w-full p-3 border-2 rounded-xl transition-all duration-300 focus:outline-none"
                style={{
                  backgroundColor: 'var(--color-white)',
                  color: 'var(--color-black)',
                  borderColor: isFocused.prenom ? 'var(--color-green)' : '#e5e7eb',
                  fontFamily: 'var(--font-tinos)'
                }}
              />
            </div>
            <div>
              <label className="block text-base font-black mb-2" style={{ fontFamily: 'var(--font-bounded)', color: 'var(--color-black)' }}>
                Nom *
              </label>
              <input
                name="nom"
                value={form.nom}
                onChange={handleChange}
                onFocus={() => setIsFocused({...isFocused, nom: true})}
                onBlur={() => setIsFocused({...isFocused, nom: false})}
                type="text"
                required
                className="w-full p-3 border-2 rounded-xl transition-all duration-300 focus:outline-none"
                style={{
                  backgroundColor: 'var(--color-white)',
                  color: 'var(--color-black)',
                  borderColor: isFocused.nom ? 'var(--color-green)' : '#e5e7eb',
                  fontFamily: 'var(--font-tinos)'
                }}
              />
            </div>
          </div>

          <div>
            <label className="block text-base font-black mb-2" style={{ fontFamily: 'var(--font-bounded)', color: 'var(--color-black)' }}>
              Email *
            </label>
            <input
              name="email"
              value={form.email}
              onChange={handleChange}
              onFocus={() => setIsFocused({...isFocused, email: true})}
              onBlur={() => setIsFocused({...isFocused, email: false})}
              type="email"
              required
              className="w-full p-3 border-2 rounded-xl transition-all duration-300 focus:outline-none"
              style={{
                backgroundColor: 'var(--color-white)',
                color: 'var(--color-black)',
                borderColor: isFocused.email ? 'var(--color-green)' : '#e5e7eb',
                fontFamily: 'var(--font-tinos)'
              }}
            />
          </div>

          <div>
            <label className="block text-base font-black mb-2" style={{ fontFamily: 'var(--font-bounded)', color: 'var(--color-black)' }}>
              Téléphone *
            </label>
            <input
              name="telephone"
              value={form.telephone}
              onChange={handleChange}
              onFocus={() => setIsFocused({...isFocused, telephone: true})}
              onBlur={() => setIsFocused({...isFocused, telephone: false})}
              type="tel"
              required
              className="w-full p-3 border-2 rounded-xl transition-all duration-300 focus:outline-none"
              style={{
                backgroundColor: 'var(--color-white)',
                color: 'var(--color-black)',
                borderColor: isFocused.telephone ? 'var(--color-green)' : '#e5e7eb',
                fontFamily: 'var(--font-tinos)'
              }}
            />
          </div>

          <div>
            <label className="block text-base font-black mb-2" style={{ fontFamily: 'var(--font-bounded)', color: 'var(--color-black)' }}>
              Société
            </label>
            <input
              name="societe"
              value={form.societe}
              onChange={handleChange}
              onFocus={() => setIsFocused({...isFocused, societe: true})}
              onBlur={() => setIsFocused({...isFocused, societe: false})}
              type="text"
              className="w-full p-3 border-2 rounded-xl transition-all duration-300 focus:outline-none"
              style={{
                backgroundColor: 'var(--color-white)',
                color: 'var(--color-black)',
                borderColor: isFocused.societe ? 'var(--color-blue)' : '#e5e7eb',
                fontFamily: 'var(--font-tinos)'
              }}
            />
          </div>

          <div>
            <label className="block text-base font-black mb-2" style={{ fontFamily: 'var(--font-bounded)', color: 'var(--color-black)' }}>
              Budget estimé
            </label>
            <input
              name="budget"
              value={form.budget}
              onChange={handleChange}
              onFocus={() => setIsFocused({...isFocused, budget: true})}
              onBlur={() => setIsFocused({...isFocused, budget: false})}
              type="text"
              placeholder="Ex : 2 000€"
              className="w-full p-3 border-2 rounded-xl transition-all duration-300 focus:outline-none"
              style={{
                backgroundColor: 'var(--color-white)',
                color: 'var(--color-black)',
                borderColor: isFocused.budget ? 'var(--color-blue)' : '#e5e7eb',
                fontFamily: 'var(--font-tinos)'
              }}
            />
          </div>

          <div>
            <label className="block text-base font-black mb-2" style={{ fontFamily: 'var(--font-bounded)', color: 'var(--color-black)' }}>
              Objet *
            </label>
            <input
              name="objet"
              value={form.objet}
              onChange={handleChange}
              onFocus={() => setIsFocused({...isFocused, objet: true})}
              onBlur={() => setIsFocused({...isFocused, objet: false})}
              type="text"
              required
              className="w-full p-3 border-2 rounded-xl transition-all duration-300 focus:outline-none"
              style={{
                backgroundColor: 'var(--color-white)',
                color: 'var(--color-black)',
                borderColor: isFocused.objet ? 'var(--color-green)' : '#e5e7eb',
                fontFamily: 'var(--font-tinos)'
              }}
            />
          </div>

          <div>
            <label className="block text-base font-black mb-2" style={{ fontFamily: 'var(--font-bounded)', color: 'var(--color-black)' }}>
              Message *
            </label>
            <textarea
              name="message"
              value={form.message}
              onChange={handleChange}
              onFocus={() => setIsFocused({...isFocused, message: true})}
              onBlur={() => setIsFocused({...isFocused, message: false})}
              rows="5"
              required
              className="w-full p-3 border-2 rounded-xl transition-all duration-300 focus:outline-none resize-none"
              style={{
                backgroundColor: 'var(--color-white)',
                color: 'var(--color-black)',
                borderColor: isFocused.message ? 'var(--color-green)' : '#e5e7eb',
                fontFamily: 'var(--font-tinos)'
              }}
            />
          </div>

          <div className="flex items-start gap-3">
            <input
              name="consent"
              type="checkbox"
              checked={form.consent}
              onChange={handleChange}
              className="mt-1 w-5 h-5 rounded border-2 border-gray-300 text-green-600 focus:ring-green-500"
            />
            <label className="text-sm text-gray-700" style={{ fontFamily: 'var(--font-tinos)' }}>
              J'accepte que mes données soient utilisées pour être recontacté(e). *
            </label>
          </div>

          <div className="g-recaptcha" data-sitekey="6LfjEHQrAAAAAJL1CPME0KI24tMJvzbxFjFpHxOD"></div>

          <button
            type="submit"
            className="w-full bg-gradient-to-r from-green-600 to-blue-600 text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 hover:shadow-2xl hover:scale-105 flex items-center justify-center gap-2"
            style={{ fontFamily: 'var(--font-bounded)' }}
          >
            Envoyer le message
            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </button>
        </form>
      </div>
    );
  }

  ReactDOM.createRoot(document.getElementById('react-contact-form')).render(<ContactForm />);
</script>
</body>
</html>
