<?php

// Traitement POST JSON (AJAX) avant toute inclusion HTML
if ($_SERVER["REQUEST_METHOD"] === "POST" && strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
    header('Content-Type: application/json');

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    if (json_last_error() !== JSON_ERROR_NONE || !is_array($input)) {
        echo json_encode(['success' => false, 'message' => 'Aucune donnée JSON valide reçue']);
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

    file_put_contents(__DIR__ . '/debug.log', json_encode([
        'success' => $form_success,
        'timestamp' => date('Y-m-d H:i:s'),
        'input' => $infos
    ]) . "\n", FILE_APPEND);

    echo json_encode([
        'success' => (bool)$form_success,
        'recaptchaError' => false
    ]);
    exit;
}

// GET : affichage du formulaire
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../../includes/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contact</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/Contact.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-gray-100">
  <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md" x-data="contactForm()">
    <h2 class="text-2xl font-bold mb-6 text-center">Contactez-nous</h2>

    <template x-if="success">
      <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
        ✅ Merci, votre message a bien été envoyé !
      </div>
    </template>

    <template x-if="error && recaptchaError">
      <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
        ❌ Erreur reCAPTCHA ou consentement manquant, veuillez réessayer.
      </div>
    </template>

    <template x-if="error && !recaptchaError">
      <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
        ❌ Une erreur est survenue lors de l'envoi du message. Merci de réessayer plus tard.
      </div>
    </template>

    <form @submit.prevent="submitForm" class="space-y-4" novalidate>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input x-model="form.prenom" name="prenom" type="text" placeholder="Prénom" required class="p-3 border rounded w-full" />
        <input x-model="form.nom" name="nom" type="text" placeholder="Nom" required class="p-3 border rounded w-full" />
      </div>
      <input x-model="form.email" name="email" type="email" placeholder="Adresse email" required class="p-3 border rounded w-full" />
      <input x-model="form.telephone" name="telephone" type="tel" placeholder="Téléphone" required class="p-3 border rounded w-full" />
      <input x-model="form.societe" name="societe" type="text" placeholder="Société" class="p-3 border rounded w-full" />
      <input x-model="form.objet" name="objet" type="text" placeholder="Objet de la demande" required class="p-3 border rounded w-full" />
      <textarea x-model="form.message" name="message" placeholder="Votre message" rows="5" required class="p-3 border rounded w-full"></textarea>

      <div class="flex items-start gap-2">
        <input x-model="form.consent" type="checkbox" name="consent" required class="mt-1" />
        <label>J'accepte que mes données soient utilisées pour être recontacté(e).</label>
      </div>

      <div class="g-recaptcha" data-sitekey="6LfjEHQrAAAAAJL1CPME0KI24tMJvzbxFjFpHxOD"></div>

      <button type="submit" class="text-white px-6 py-3 rounded transition" style="background-color: var(--color-black); hover:background-color: var(--color-hover-1)">
        Envoyer
      </button>
    </form>
  </div>

<script>
  window.contactForm = function () {
    return {
      form: {
        prenom: '',
        nom: '',
        societe: '',
        email: '',
        telephone: '',
        objet: '',
        message: '',
        consent: false,
        'g-recaptcha-response': '',
      },
      success: false,
      error: false,
      recaptchaError: false,

      async submitForm() {
        this.success = false;
        this.error = false;
        this.recaptchaError = false;

        if (typeof grecaptcha === 'undefined') {
          this.error = true;
          this.recaptchaError = true;
          alert("reCAPTCHA n'est pas chargé. Rechargez la page.");
          return;
        }

        await grecaptcha.ready(() => {});
        const token = grecaptcha.getResponse();

        if (!token) {
          this.error = true;
          this.recaptchaError = true;
          return;
        }

        this.form['g-recaptcha-response'] = token;

        try {
          const response = await fetch(window.location.href, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(this.form),
          });

          const text = await response.text();
          console.log('Réponse brute du serveur :', text);

          let result = {};
          try {
            result = JSON.parse(text);
          } catch (e) {
            console.error('Erreur JSON :', e);
            this.error = true;
            return;
          }

          if (result.success) {
            this.success = true;
            Object.keys(this.form).forEach(key => this.form[key] = key === 'consent' ? false : '');
            grecaptcha.reset();
          } else {
            this.error = true;
            this.recaptchaError = result.recaptchaError || false;
          }
        } catch (e) {
          console.error("Erreur lors de l'envoi :", e);
          this.error = true;
        }
      }
    }
  }
</script>
</body>
</html>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
