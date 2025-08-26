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
  <link rel="icon" href="<?= BASE_URL ?>/Alex2logo.png" type="image/x-icon">
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- React CDN -->
  <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</head>

<body style="background-color: var(--color-white); color: var(--color-black);">
<?php include __DIR__ . '/../../includes/header.php'; ?>

<!-- REACT ROOT -->
<div id="react-contact-form"></div>

<!-- CARTES ET INFOS CONTACT -->
<div class="mx-auto rounded-xl shadow-md p-6 md:p-8 w-[90vw] max-w-[1200px] flex flex-col md:flex-row gap-6 md:gap-12 my-8" style="background-color: var(--color-white); color: var(--color-black); font-family: var(--font-tinos)">

  <!-- Cartes -->
  <div class="flex-1 flex flex-col gap-4">
    <div>
      <h3 class="text-xl font-semibold mb-2" style="font-family: var(--font-bounded)">Lourdes</h3>
      <div id="map-lourdes" class="w-full h-48 md:h-56 rounded-lg shadow-md"></div>
      <p class="mt-2">8 Rue Charles Baudelaire, 65100 Lourdes</p>
    </div>

    <div>
      <h3 class="text-xl font-semibold mb-2" style="font-family: var(--font-bounded)">Tarbes</h3>
      <div id="map-tarbes" class="w-full h-48 md:h-56 rounded-lg shadow-md"></div>
      <p class="mt-2">8 Rue Georges Lassalle, 65000 Tarbes</p>
    </div>
  </div>

  <!-- Infos Contact -->
  <div class="flex-1 flex flex-col justify-center items-center text-center">
    <h2 class="text-2xl font-semibold mb-4" style="font-family: var(--font-bounded)">Contactez-nous</h2>

    <p class="mb-3">
      <strong>Qui sommes-nous ?</strong><br>
      Nous sommes deux développeurs indépendants travaillant en collaboration sous le nom <strong>&lt;alex²/&gt;</strong>.<br>
      Que vous nous contactiez pour un site web, une refonte, du conseil ou du développement spécifique, vous serez pris en charge par l’un de nous deux selon vos besoins.
    </p>

    <p class="mb-3">
      <strong>Téléphone :</strong><br>
      <strong>Alexis R.</strong> — <a href="tel:+33768882766" class="text-blue-600 hover:underline">+33 7 68 88 27 66</a><br>
      <strong>Alexandre B.</strong> — <a href="tel:+33686825714" class="text-blue-600 hover:underline">+33 6 86 82 57 14</a>
    </p>

    <p class="mb-3">
      <strong>Email :</strong><br>
      <a href="mailto:contact.alex2.dev@gmail.com" class="text-blue-600 hover:underline">contact.alex2.dev@gmail.com</a>
    </p>

    <p>
      <strong>Horaires :</strong><br>
      Du lundi au vendredi, 9h - 18h
    </p>
  </div>

</div>

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


    // Tuiles minimalistes
    L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map);

    // Marqueur personnalisé
    const markerIcon = L.divIcon({
      html: `<div style="
        background-color: ${colorGreen};
        width: 16px; height: 16px;
        border-radius: 50%;
        border: 2px solid ${colorBlack};
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
      objet: '', message: '', consent: false, 'g-recaptcha-response': ''
    });
    const [success, setSuccess] = useState(false);
    const [error, setError] = useState(false);
    const [recaptchaError, setRecaptchaError] = useState(false);

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
            objet: '', message: '', consent: false, 'g-recaptcha-response': ''
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
      <div className="mx-auto p-6 sm:p-8 rounded-xl shadow-md max-w-full w-full px-4 sm:px-6 md:max-w-2xl" style={{ backgroundColor: 'var(--color-white)', color: 'var(--color-black)' }}>
        <h2 className="text-2xl font-bold mb-6 text-center" style={{ fontFamily: 'var(--font-bounded)' }}>Contactez-nous</h2>

        {success && <div className="bg-green-100 text-green-800 p-4 rounded mb-4">✅ Merci, votre message a bien été envoyé !</div>}
        {error && recaptchaError && <div className="bg-red-100 text-red-800 p-4 rounded mb-4">❌ Erreur reCAPTCHA ou consentement manquant.</div>}
        {error && !recaptchaError && <div className="bg-red-100 text-red-800 p-4 rounded mb-4">❌ Une erreur est survenue. Réessayez plus tard.</div>}

        <form onSubmit={handleSubmit} className="space-y-4" noValidate>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input name="prenom" value={form.prenom} onChange={handleChange} type="text" placeholder="Prénom *" required className="p-3 border rounded w-full" style={{ backgroundColor: 'var(--color-white)', color: 'var(--color-black)', borderColor: 'var(--color-black)' }} />
            <input name="nom" value={form.nom} onChange={handleChange} type="text" placeholder="Nom *" required className="p-3 border rounded w-full" style={{ backgroundColor: 'var(--color-white)', color: 'var(--color-black)', borderColor: 'var(--color-black)' }} />
          </div>

          <input name="email" value={form.email} onChange={handleChange} type="email" placeholder="Email *" required className="p-3 border rounded w-full" style={{ backgroundColor: 'var(--color-white)', color: 'var(--color-black)', borderColor: 'var(--color-black)' }} />
          <input name="telephone" value={form.telephone} onChange={handleChange} type="tel" placeholder="Téléphone *" required className="p-3 border rounded w-full" style={{ backgroundColor: 'var(--color-white)', color: 'var(--color-black)', borderColor: 'var(--color-black)' }} />
          <input name="societe" value={form.societe} onChange={handleChange} type="text" placeholder="Société" className="p-3 border rounded w-full" style={{ backgroundColor: 'var(--color-white)', color: 'var(--color-black)', borderColor: 'var(--color-black)' }} />
          <input name="objet" value={form.objet} onChange={handleChange} type="text" placeholder="Objet *" required className="p-3 border rounded w-full" style={{ backgroundColor: 'var(--color-white)', color: 'var(--color-black)', borderColor: 'var(--color-black)' }} />
          <textarea name="message" value={form.message} onChange={handleChange} placeholder="Votre message *" rows="5" required className="p-3 border rounded w-full resize-none" style={{ backgroundColor: 'var(--color-white)', color: 'var(--color-black)', borderColor: 'var(--color-black)' }}></textarea>
          <div className="flex items-start gap-2">
            <input name="consent" type="checkbox" checked={form.consent} onChange={handleChange} />
            <label>J'accepte que mes données soient utilisées pour être recontacté(e).</label>
          </div>
          <div className="g-recaptcha" data-sitekey="6LfjEHQrAAAAAJL1CPME0KI24tMJvzbxFjFpHxOD"></div>
          <button type="submit" className="text-white px-6 py-3 rounded transition" style={{ backgroundColor: 'var(--color-black)', fontFamily: 'var(--font-tinos)' }}>Envoyer</button>
        </form>
      </div>
    );
  }

  ReactDOM.createRoot(document.getElementById('react-contact-form')).render(<ContactForm />);
</script>
</body>
</html>
