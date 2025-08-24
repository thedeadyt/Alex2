<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Politique de confidentialité | &lt;Alex²/&gt;</title>
  <link rel="icon" href="<?= BASE_URL ?>/Alex2logo.png" type="image/x-icon">
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- React & ReactDOM -->
  <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">
  <?php
  include __DIR__ . '/../../includes/header.php';
  ?>
  <section class="py-16 px-6 md:px-20 max-w-5xl mx-auto" id="content">
    <h1 class="text-4xl font-bold mb-8 text-center">
      <span style="color: var(--color-green);">&lt;alex²/&gt;</span> — Politique de confidentialité
    </h1>

    <div id="privacy-root"></div>
  </section>
  <?php
  include __DIR__ . '/../../includes/footer.php';
  ?>
  <script type="text/babel">

function Section({ title, children }) {
  const [open, setOpen] = React.useState(false);

  return (
    <div className="border-l-4 pl-4 mb-6" style={{ borderColor: "var(--color-green)" }}>
      <h2
        onClick={() => setOpen(!open)}
        className={`text-xl font-semibold cursor-pointer ${
          open ? 'text-[var(--color-accent-2)]' : 'hover:text-[var(--color-accent-2)]'
        }`}
      >
        {title}
      </h2>
      {open && <div className="mt-2">{children}</div>}
    </div>
  );
}

function PrivacyPolicy() {
  return (
    <div className="space-y-6 text-base leading-relaxed">
      <Section title="1. Introduction">
        <p>
          La présente politique de confidentialité décrit comment <strong style={{ color: 'var(--color-green)' }}>&lt;alex²/&gt;</strong> collecte, utilise et protège vos données personnelles lors de votre navigation sur ce site.
        </p>
      </Section>

      <Section title="2. Données collectées">
        <ul className="list-disc list-inside">
          <li>Données techniques : adresse IP, type de navigateur, temps de visite.</li>
          <li>Données transmises volontairement : via le formulaire de contact, email, etc.</li>
        </ul>
      </Section>

      <Section title="3. Utilisation des données">
        <p>Les données collectées sont utilisées uniquement pour :</p>
        <ul className="list-disc list-inside mt-2">
          <li>Améliorer l’expérience utilisateur.</li>
          <li>Répondre aux demandes via le formulaire de contact.</li>
          <li>Assurer la sécurité et le bon fonctionnement du site.</li>
        </ul>
      </Section>

      <Section title="4. Cookies">
        <p>Le site utilise des cookies nécessaires au bon fonctionnement du site. Aucun cookie tiers à des fins publicitaires n’est utilisé.</p>
      </Section>

      <Section title="5. Conservation des données">
        <p>Les données sont conservées pendant la durée nécessaire aux finalités pour lesquelles elles sont collectées, dans le respect de la législation en vigueur.</p>
      </Section>

      <Section title="6. Vos droits">
        <p>Conformément au RGPD, vous disposez des droits suivants :</p>
        <ul className="list-disc list-inside mt-2">
          <li>Droit d’accès, de rectification, d’opposition et de suppression de vos données.</li>
          <li>Droit à la portabilité et à la limitation du traitement.</li>
          <li>Droit d’introduire une réclamation auprès de la CNIL.</li>
        </ul>
      </Section>

      <Section title="7. Contact">
        <p>
          Pour exercer vos droits ou poser une question, vous pouvez nous contacter à l’adresse :
          <a href="mailto:contact.alex2.dev@gmail.com" className="text-[var(--color-green)] underline"> contact.alex2.dev@gmail.com</a>.
        </p>
      </Section>
    </div>
  );
}

ReactDOM.createRoot(document.getElementById('privacy-root')).render(<PrivacyPolicy />);
</script>

</body>
</html>
