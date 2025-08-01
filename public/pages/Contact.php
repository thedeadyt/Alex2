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
    echo json_encode([
        'success' => (bool)$form_success,
        'recaptchaError' => false
    ]);
    exit;
}

// GET : affichage du formulaire
require_once __DIR__ . '/../../config/config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contact | &lt;alex²/&gt;</title>
  <link rel="icon" href="<?= BASE_URL ?>/Alex2logo.png" type="image/x-icon">
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/Contact.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- React & ReactDOM -->
  <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<br>
<body style="background-color: var(--color-white); color: var(--color-black);">
  <?php
  include __DIR__ . '/../../includes/header.php';
  ?>
  <div
  class="mx-auto p-6 sm:p-8 rounded-xl shadow-md max-w-full w-full px-4 sm:px-6 md:max-w-2xl" x-data="contactForm()" style="background-color: var(--color-white); color: var(--color-black);" id="content">
  <h2 class="text-2xl font-bold mb-6 text-center" style="font-family: var(--font-bounded)">Contactez-nous</h2>

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
      <input x-model="form.prenom" name="prenom" type="text" placeholder="Prénom *" required class="p-3 border rounded w-full" style="background-color: var(--color-white); color: var(--color-black); border-color: var(--color-black)"/>
      <input x-model="form.nom" name="nom" type="text" placeholder="Nom *" required class="p-3 border rounded w-full" style="background-color: var(--color-white); color: var(--color-black); border-color: var(--color-black)"/>
    </div>

    <input x-model="form.email" name="email" type="email" placeholder="Adresse email *" required class="p-3 border rounded w-full" style="background-color: var(--color-white); color: var(--color-black); border-color: var(--color-black)"/>
    <input x-model="form.telephone" name="telephone" type="tel" placeholder="Téléphone *" required class="p-3 border rounded w-full" style="background-color: var(--color-white); color: var(--color-black); border-color: var(--color-black)"/>
    <input x-model="form.societe" name="societe" type="text" placeholder="Société" class="p-3 border rounded w-full" style="background-color: var(--color-white); color: var(--color-black); border-color: var(--color-black)"/>
    <input x-model="form.objet" name="objet" type="text" placeholder="Objet de la demande *" required class="p-3 border rounded w-full" style="background-color: var(--color-white); color: var(--color-black); border-color: var(--color-black)"/>
    <textarea x-model="form.message" name="message" placeholder="Votre message *" rows="5" required class="p-3 border rounded w-full resize-none" style="background-color: var(--color-white); color: var(--color-black); border-color: var(--color-black)"></textarea>

    <div class="flex items-start gap-2" style="font-family: var(--font-tinos)">
      <input x-model="form.consent" type="checkbox" name="consent" required class="mt-1"/>
      <label>J'accepte que mes données soient utilisées pour être recontacté(e).</label>
    </div>

    <div class="g-recaptcha" data-sitekey="6LfjEHQrAAAAAJL1CPME0KI24tMJvzbxFjFpHxOD"></div>

      <button type="submit" class="text-white px-6 py-3 rounded transition" style="background-color: var(--color-black); font-family: var(--font-tinos)">
        Envoyer
      </button>
    </form>
  </div>

  <br>
<div style="background-color: var(--color-white); color: var(--color-black); font-family: var(--font-tinos)"
  x-data="{ open: true }"
  class="mx-auto rounded-xl shadow-md p-6 md:p-8 w-[90vw] max-w-[1200px] flex flex-col md:flex-row gap-6 md:gap-12"
>

  <!-- Carte -->
  <iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d391.91388894218875!2d-0.025944830846995486!3d43.09618670956462!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd57d677cb5a0c7f%3A0xfcead0c8cffff259!2s8%20Rue%20Charles%20Baudelaire%2C%2065100%20Lourdes!5e1!3m2!1sfr!2sfr!4v1751382382544!5m2!1sfr!2sfr"
    class="w-full md:w-[600px] h-[240px] md:h-[360px] rounded-lg border-0"
    allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"
  ></iframe>

  <!-- Bouton toggle visible sur mobile -->
  <button @click="open = !open" class="md:hidden bg-black hover:bg-gray-800 text-white rounded-md px-4 py-2 self-start">
    <span x-text="open ? 'Masquer les infos' : 'Afficher les infos'"></span>
  </button>

  <!-- Infos contact -->
  <div
    x-show="open"
    x-transition
    class="flex-grow font-sans"
  >
    <h2 class="text-2xl font-semibold mb-4" style="font-family: var(--font-bounded)">Contactez-nous</h2>
    <p class="mb-3" style="font-family: var(--font-tinos)"><strong>Adresse :</strong><br>8 Rue Charles Baudelaire,<br>65100 Lourdes</p>
    <p class="mb-3" style="font-family: var(--font-tinos)">
      <strong>Téléphone :</strong><br>
      <a href="tel:+33768882766" class="text-blue-600 hover:underline">+33 7 68 88 27 66</a><br>
      <a href="tel:+33686825714" class="text-blue-600 hover:underline">+33 6 86 82 57 14</a>
    </p>
    <p class="mb-3" style="font-family: var(--font-tinos)">
      <strong>Email :</strong><br>
      <a href="mailto:contact.alex2.dev@gmail.com" class="text-blue-600 hover:underline">contact.alex2.dev@gmail.com</a>
    </p>
    <p style="font-family: var(--font-tinos)"><strong>Horaires de contact :</strong><br>Du lundi au vendredi, 9h - 18h</p>
  </div>
</div>

</div>
<br>
<?php
  include __DIR__ . '/../../includes/footer.php';
  ?>
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


