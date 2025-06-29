<?php
// contact.php (ou ton fichier de contact)

require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../../includes/header.php';

// Gérer la requête AJAX JSON uniquement
if ($_SERVER["REQUEST_METHOD"] === "POST" && strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        echo json_encode(['success' => false, 'message' => 'Aucune donnée reçue']);
        exit;
    }

    $recaptcha_secret = '6LcYx3ErAAAAAO7B6EMBSPhEyjhfAjl_gzba6a0s';
    $recaptcha_response = $input['g-recaptcha-response'] ?? '';
    $remote_ip = $_SERVER['REMOTE_ADDR'];
    $consent = isset($input['consent']) && $input['consent'] === true;

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response&remoteip=$remote_ip");
    $captcha = json_decode($response);

    if (!$captcha->success || !$consent) {
        echo json_encode(['success' => false, 'recaptchaError' => true]);
        exit;
    }

    require 'SendMailFunction.php';

    $infos = [
        'nom' => htmlspecialchars($input["nom"] ?? ''),
        'prenom' => htmlspecialchars($input["prenom"] ?? ''),
        'email' => htmlspecialchars($input["email"] ?? ''),
        'telephone' => htmlspecialchars($input["telephone"] ?? ''),
        'entreprise' => htmlspecialchars($input["societe"] ?? ''),
        'sujet' => htmlspecialchars($input["objet"] ?? ''),
        'message' => htmlspecialchars($input["message"] ?? ''),
    ];

    $form_success = EnvoieMailFormulaire($infos);

    if ($form_success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'recaptchaError' => false]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contact</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-gray-100">

  <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md" x-data="contactForm()">
    <h2 class="text-2xl font-bold mb-6 text-center">Contactez-nous</h2>

    <!-- Messages -->
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

      <input x-model="form.societe" name="societe" type="text" placeholder="Société" class="p-3 border rounded w-full" />
      <input x-model="form.email" name="email" type="email" placeholder="Adresse email" required class="p-3 border rounded w-full" />
      <input x-model="form.telephone" name="telephone" type="tel" placeholder="Téléphone" required class="p-3 border rounded w-full" />
      <input x-model="form.objet" name="objet" type="text" placeholder="Objet de la demande" required class="p-3 border rounded w-full" />
      <textarea x-model="form.message" name="message" placeholder="Votre message" rows="5" required class="p-3 border rounded w-full"></textarea>

      <div class="flex items-start gap-2">
        <input x-model="form.consent" type="checkbox" name="consent" required class="mt-1" />
        <label>J'accepte que mes données soient utilisées pour être recontacté(e).</label>
      </div>

      <div class="my-4">
        <div class="g-recaptcha" data-sitekey="6LcYx3ErAAAAANQjmtOFmVXeeD-YUKsPQ0ug9RQP"></div>
      </div>

      <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
        Envoyer
      </button>
    </form>
  </div>

<script>
function contactForm() {
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
      this.form['g-recaptcha-response'] = grecaptcha.getResponse();

      this.success = false;
      this.error = false;
      this.recaptchaError = false;

      if (!this.form['g-recaptcha-response']) {
        this.error = true;
        this.recaptchaError = true;
        return;
      }

      try {
        const response = await fetch(window.location.href, {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify(this.form),
        });

        const result = await response.json();

        if (result.success) {
          this.success = true;
          this.error = false;

          // Reset form
          Object.keys(this.form).forEach(key => this.form[key] = (key === 'consent' ? false : ''));
          grecaptcha.reset();
        } else {
          this.error = true;
          this.recaptchaError = result.recaptchaError || false;
        }
      } catch {
        this.error = true;
        this.recaptchaError = false;
      }
    }
  }
}
</script>

</body>
</html>

<?php
include __DIR__ . '/../../includes/footer.php';
?>
