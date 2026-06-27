<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

// Traitement POST JSON — formulaire promo email
if ($_SERVER["REQUEST_METHOD"] === "POST" && strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
    header('Content-Type: application/json; charset=utf-8');

    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($input)) {
        echo json_encode(['success' => false, 'message' => 'Données invalides']);
        exit;
    }

    $email = filter_var(trim($input['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    if (!$email) {
        echo json_encode(['success' => false, 'message' => 'Email invalide']);
        exit;
    }

    try {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT code_promo FROM promo_emails WHERE email = ?");
        $stmt->execute([$email]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            echo json_encode(['success' => true, 'code' => $existing['code_promo'], 'alreadyExists' => true]);
            exit;
        }

        // Générer un code unique
        $code = 'ALEX2-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));

        // Insérer en BDD
        $stmt = $pdo->prepare("INSERT INTO promo_emails (email, code_promo) VALUES (?, ?)");
        $stmt->execute([$email, $code]);

        // Envoyer l'email avec le code promo
        try {
            require_once __DIR__ . '/PHPMailer-master/src/Exception.php';
            require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
            require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';

            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'ssl0.ovh.net';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply@alex2.dev';
            $mail->Password = 'Alex.2005';
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('noreply@alex2.dev', 'Alex²');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "Votre code promo Alex² — 10% de réduction";

            $mail->Body = '<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;font-family:Georgia,serif;background:#f4f4f4;">
<div style="max-width:560px;margin:30px auto;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);">
  <div style="background:linear-gradient(135deg,#51845C,#2563EB);padding:32px;text-align:center;">
    <h1 style="color:#fff;margin:0;font-size:28px;">&lt;Alex²/&gt;</h1>
    <p style="color:rgba(255,255,255,0.85);margin:8px 0 0;font-size:15px;">Pour nous faire pardonner...</p>
  </div>
  <div style="padding:32px;">
    <p style="color:#1f2020;font-size:16px;line-height:1.6;">Voici votre code promo exclusif pour bénéficier de <strong>10% de réduction</strong> sur votre prochain projet web avec Alex² :</p>
    <div style="background:#f0fdf4;border:2px dashed #51845C;border-radius:12px;padding:20px;text-align:center;margin:24px 0;">
      <span style="font-size:28px;font-weight:bold;color:#51845C;letter-spacing:3px;">' . htmlspecialchars($code) . '</span>
    </div>
    <p style="color:#6c757d;font-size:14px;line-height:1.6;">Mentionnez ce code lors de votre prise de contact. Il est valable sans limite de durée.</p>
    <div style="text-align:center;margin-top:28px;">
      <a href="https://alex2.dev/Contact" style="display:inline-block;background:linear-gradient(135deg,#51845C,#2563EB);color:#fff;padding:14px 32px;border-radius:10px;text-decoration:none;font-weight:bold;font-size:15px;">Démarrer un projet</a>
    </div>
  </div>
  <div style="background:#1f2020;padding:20px;text-align:center;">
    <p style="color:rgba(255,255,255,0.6);margin:0;font-size:12px;">© Alex² — Développement web à Tarbes & Lourdes</p>
  </div>
</div>
</body>
</html>';

            $mail->AltBody = "Votre code promo Alex² : {$code}\nMentionnez-le lors de votre prise de contact pour 10% de réduction.";
            $mail->send();
        } catch (\Exception $e) {
            error_log("Erreur envoi mail promo: " . $e->getMessage());
        }

        echo json_encode(['success' => true, 'code' => $code, 'alreadyExists' => false]);
    } catch (PDOException $e) {
        error_log("Erreur BDD promo: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>404 — Page introuvable | &lt;Alex²/&gt;</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="<?= BASE_URL ?>Alex2logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/variables.css?v=10">
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/index.css?v=6">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <style>
      @font-face {
        font-family: 'Bounded';
        src: url('<?= BASE_URL ?>asset/fonts/Bounded-Regular.ttf') format('truetype');
        font-weight: 400;
        font-style: normal;
        font-display: swap;
      }
      @font-face {
        font-family: 'Bounded';
        src: url('<?= BASE_URL ?>asset/fonts/Bounded-Black.ttf') format('truetype');
        font-weight: 900;
        font-style: normal;
        font-display: swap;
      }
    </style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-EFTK5TK4MM"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-EFTK5TK4MM');
    </script>
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">

<?php include __DIR__ . '/../../includes/header.php'; ?>

<section id="content">
  <div id="page-404-root"></div>
</section>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

<script type="text/babel">
const { useState } = React;

const BASE = "<?= BASE_URL ?>";

// ─── Navigation cards data ───
const navItems = [
  {
    name: "Accueil", href: BASE, icon: (
      <svg className="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={1.5}>
        <path strokeLinecap="round" strokeLinejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
      </svg>
    )
  },
  {
    name: "Nos services", href: BASE + "services", icon: (
      <svg className="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={1.5}>
        <path strokeLinecap="round" strokeLinejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085" />
      </svg>
    )
  },
  {
    name: "Portfolio", href: BASE + "nos-realisations", icon: (
      <svg className="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={1.5}>
        <path strokeLinecap="round" strokeLinejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A1.5 1.5 0 0 0 21.75 19.5V4.5A1.5 1.5 0 0 0 20.25 3H3.75A1.5 1.5 0 0 0 2.25 4.5v15A1.5 1.5 0 0 0 3.75 21z" />
      </svg>
    )
  },
  {
    name: "À propos", href: BASE + "a-propos", icon: (
      <svg className="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={1.5}>
        <path strokeLinecap="round" strokeLinejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
      </svg>
    )
  },
  {
    name: "Contact", href: BASE + "contact", icon: (
      <svg className="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth={1.5}>
        <path strokeLinecap="round" strokeLinejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
      </svg>
    )
  }
];

// ─── Search data ───
const searchPages = [
  { name: "Accueil", href: BASE, keywords: "accueil home page principale" },
  { name: "Nos services", href: BASE + "services", keywords: "services développement web création site vitrine maintenance" },
  { name: "Projets réalisés", href: BASE + "nos-realisations", keywords: "projets portfolio réalisations travaux" },
  { name: "À propos", href: BASE + "a-propos", keywords: "à propos qui sommes nous équipe histoire" },
  { name: "Contact", href: BASE + "contact", keywords: "contact email téléphone formulaire devis" },
  { name: "Blog", href: BASE + "blog", keywords: "blog articles actualités tutoriels" },
  { name: "Mentions légales", href: BASE + "mentions-legales", keywords: "mentions légales juridique" },
  { name: "Politique de confidentialité", href: BASE + "politique-de-confidentialite", keywords: "confidentialité données rgpd" },
];

// ─── Hero Section ───
function Hero404() {
  return (
    <div className="text-center pt-16 pb-12 px-6 animate-fade-in-up">
      <div className="relative inline-block mb-6">
        <span className="text-8xl md:text-9xl font-black bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent" style={{ fontFamily: "var(--font-bounded)" }}>
          404
        </span>
      </div>
      <h1 className="text-3xl md:text-4xl font-black mb-4" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
        On dirait que cette page a pris ses vacances...
      </h1>
      <p className="text-lg text-gray-600 max-w-xl mx-auto" style={{ fontFamily: "var(--font-tinos)" }}>
        Pas de panique ! Voici quelques pistes pour retrouver votre chemin.
      </p>
    </div>
  );
}

// ─── Search Bar ───
function SearchBar() {
  const [query, setQuery] = useState("");
  const [results, setResults] = useState([]);

  const handleSearch = (value) => {
    setQuery(value);
    if (value.trim().length < 2) {
      setResults([]);
      return;
    }
    const q = value.toLowerCase();
    const filtered = searchPages.filter(p =>
      p.name.toLowerCase().includes(q) || p.keywords.toLowerCase().includes(q)
    );
    setResults(filtered);
  };

  return (
    <div className="max-w-xl mx-auto px-6 mb-16">
      <div className="relative">
        <svg className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
        <input
          type="text"
          value={query}
          onChange={(e) => handleSearch(e.target.value)}
          placeholder="Rechercher sur le site..."
          className="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 focus:border-green-400 outline-none transition-all duration-300 text-lg bg-white shadow-sm"
          style={{ fontFamily: "var(--font-tinos)" }}
        />
      </div>
      {results.length > 0 && (
        <div className="mt-2 bg-white rounded-xl border-2 border-gray-100 shadow-lg overflow-hidden">
          {results.map((page, i) => (
            <a
              key={i}
              href={page.href}
              className="flex items-center gap-3 px-4 py-3 hover:bg-green-50 transition-colors duration-200 border-b border-gray-50 last:border-0"
            >
              <svg className="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="m8.25 4.5 7.5 7.5-7.5 7.5" />
              </svg>
              <span style={{ fontFamily: "var(--font-tinos)", color: "var(--color-black)" }}>{page.name}</span>
            </a>
          ))}
        </div>
      )}
      {query.trim().length >= 2 && results.length === 0 && (
        <div className="mt-2 bg-white rounded-xl border-2 border-gray-100 shadow-lg px-4 py-3 text-gray-500 text-center" style={{ fontFamily: "var(--font-tinos)" }}>
          Aucun résultat pour "{query}"
        </div>
      )}
    </div>
  );
}

// ─── Navigation Cards ───
function NavCards() {
  return (
    <div className="max-w-4xl mx-auto px-6 mb-16">
      <h2 className="text-2xl font-black text-center mb-8" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
        Où souhaitez-vous aller ?
      </h2>
      <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        {navItems.map((item, i) => (
          <a
            key={i}
            href={item.href}
            className="group bg-white rounded-2xl border-2 border-gray-100 p-5 text-center transition-all duration-300 hover:border-green-200 hover:shadow-lg"
            style={{ animationDelay: `${i * 0.1}s`, opacity: 0, animation: `slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) ${i * 0.1}s forwards` }}
          >
            <div className="flex justify-center mb-3 transition-transform duration-300 group-hover:scale-110 group-hover:-translate-y-1" style={{ color: i % 2 === 0 ? "#51845C" : "#2563EB" }}>
              {item.icon}
            </div>
            <span className="text-base font-black block" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
              {item.name}
            </span>
          </a>
        ))}
      </div>
    </div>
  );
}

// ─── Contact CTA ───
function ContactCTA() {
  return (
    <div className="text-center mb-20 px-6">
      <p className="text-gray-600 mb-4" style={{ fontFamily: "var(--font-tinos)" }}>
        Vous ne trouvez toujours pas ? On peut vous aider !
      </p>
      <a
        href={BASE + "contact"}
        className="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold text-lg text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
        style={{ background: "linear-gradient(135deg, #51845C, #2563EB)", fontFamily: "var(--font-bounded)" }}
      >
        Nous contacter
        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M13 7l5 5m0 0l-5 5m5-5H6" />
        </svg>
      </a>
    </div>
  );
}

// ─── Promo Section ───
function PromoSection() {
  const [email, setEmail] = useState("");
  const [status, setStatus] = useState("idle");
  const [code, setCode] = useState("");
  const [alreadyExists, setAlreadyExists] = useState(false);
  const [errorMsg, setErrorMsg] = useState("");

  const isValidEmail = (e) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e);

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!isValidEmail(email)) {
      setErrorMsg("Veuillez entrer une adresse email valide.");
      setStatus("error");
      return;
    }
    setStatus("loading");
    setErrorMsg("");

    try {
      const res = await fetch(window.location.href, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email: email.trim() })
      });
      const data = await res.json();

      if (data.success) {
        setCode(data.code);
        setAlreadyExists(data.alreadyExists || false);
        setStatus("success");
      } else {
        setErrorMsg(data.message || "Une erreur est survenue.");
        setStatus("error");
      }
    } catch {
      setErrorMsg("Erreur de connexion. Réessayez.");
      setStatus("error");
    }
  };

  return (
    <div className="max-w-2xl mx-auto px-6 pb-20">
      <div className="bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl p-8 md:p-12 shadow-xl border border-gray-200">
        <div className="text-center mb-8">
          <span className="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-base font-black mb-4" style={{ fontFamily: "var(--font-bounded)" }}>
            Cadeau
          </span>
          <h2 className="text-3xl md:text-4xl font-black mb-3" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
            Pour nous faire pardonner...
          </h2>
          <p className="text-gray-600 text-lg" style={{ fontFamily: "var(--font-tinos)" }}>
            Recevez un code promo de <strong className="text-green-700">10%</strong> pour votre prochain projet web avec Alex².
          </p>
        </div>

        {status === "success" ? (
          <div className="text-center animate-fade-in-up">
            <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg className="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M4.5 12.75l6 6 9-13.5" />
              </svg>
            </div>
            {alreadyExists ? (
              <p className="text-gray-600 mb-4" style={{ fontFamily: "var(--font-tinos)" }}>
                Vous avez déjà un code ! Le voici de nouveau :
              </p>
            ) : (
              <p className="text-gray-600 mb-4" style={{ fontFamily: "var(--font-tinos)" }}>
                Votre code a été envoyé par email. Le voici :
              </p>
            )}
            <div className="bg-white border-2 border-dashed border-green-400 rounded-xl py-4 px-6 inline-block mb-4">
              <span className="text-3xl font-black tracking-widest" style={{ color: "#51845C", fontFamily: "var(--font-bounded)" }}>
                {code}
              </span>
            </div>
            <p className="text-sm text-gray-500" style={{ fontFamily: "var(--font-tinos)" }}>
              Mentionnez ce code lors de votre prise de contact.
            </p>
          </div>
        ) : (
          <form onSubmit={handleSubmit} className="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
            <div className="flex-1">
              <input
                type="email"
                value={email}
                onChange={(e) => { setEmail(e.target.value); setStatus("idle"); setErrorMsg(""); }}
                placeholder="votre@email.com"
                className={`w-full px-5 py-4 rounded-xl border-2 outline-none transition-all duration-300 text-lg ${
                  status === "error" ? "border-red-300 focus:border-red-400" : "border-gray-200 focus:border-green-400"
                }`}
                style={{ fontFamily: "var(--font-tinos)" }}
                required
              />
            </div>
            <button
              type="submit"
              disabled={status === "loading"}
              className="px-6 py-4 rounded-xl text-white font-semibold text-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-lg disabled:opacity-60 disabled:hover:translate-y-0 flex-shrink-0"
              style={{ background: "linear-gradient(135deg, #51845C, #2563EB)", fontFamily: "var(--font-bounded)" }}
            >
              {status === "loading" ? (
                <span className="flex items-center gap-2">
                  <svg className="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                    <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                  </svg>
                  Envoi...
                </span>
              ) : "Recevoir mon code"}
            </button>
          </form>
        )}

        {status === "error" && errorMsg && (
          <p className="text-red-500 text-center mt-3 text-sm" style={{ fontFamily: "var(--font-tinos)" }}>
            {errorMsg}
          </p>
        )}
      </div>
    </div>
  );
}

// ─── Main Page ───
function Page404() {
  return (
    <>
      <Hero404 />
      <SearchBar />
      <NavCards />
      <ContactCTA />
      <PromoSection />
    </>
  );
}

ReactDOM.createRoot(document.getElementById("page-404-root")).render(<Page404 />);
</script>

</body>
</html>
