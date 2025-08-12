<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mentions légales | &lt;alex²/&gt;</title>
  <link rel="icon" href="<?= BASE_URL ?>/Alex2logo.png" type="image/x-icon">
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- React CDN -->
  <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
</head>

<body style="background-color: var(--color-white); color: var(--color-black);">
  <?php include __DIR__ . '/../../includes/header.php'; ?>

  <section class="py-16 px-6 md:px-20 max-w-5xl mx-auto" id="content">
    <h1 class="text-4xl font-bold mb-8 text-center">
        <span style="color: var(--color-green);">&lt;alex²/&gt;</span> — Mentions légales
    </h1>

    <!-- React Root -->
    <div id="mentions-react-root"></div>
  </section>

  <script type="text/babel">
    const { useState } = React;

    function ToggleSection({ title, children }) {
      const [open, setOpen] = useState(false);
      return (
        <div className="border-l-4 pl-4 mb-6" style={{ borderColor: "var(--color-green)" }}>
          <h2
            onClick={() => setOpen(!open)}
            className={`text-xl font-semibold cursor-pointer ${open ? "text-[var(--color-accent-2)]" : "hover:text-[var(--color-accent-2)]"}`}
          >
            {title}
          </h2>
          {open && <div className="mt-2">{children}</div>}
        </div>
      );
    }

    function MentionsLegalesReact() {
      return (
        <div className="text-base leading-relaxed">
        <ToggleSection title="1. Éditeur du site">
          <p>
            Le site <strong style={{ color: "var(--color-green)" }}>&lt;alex²/&gt;</strong> est coédité par deux auto-entrepreneurs indépendants :
          </p>

          <p className="mt-4 font-semibold">1. Alexis Rodrigues Dos Reis</p>
          <ul className="list-disc list-inside ml-4">
            <li>Statut : Auto-entrepreneur</li>
            <li>SIRET : 123 456 789 00000</li>
            <li>Adresse : 8 Rue Charles Baudelaire, 65100 Lourdes, France</li>
            <li>Email : <a href="mailto:contact.alex2.dev@gmail.com" className="text-[var(--color-green)] underline">contact.alex2.dev@gmail.com</a></li>
          </ul>

          <p className="mt-4 font-semibold">2. Alexandre Bouvy</p>
          <ul className="list-disc list-inside ml-4">
            <li>Statut : Auto-entrepreneur</li>
            <li>SIRET : 987 654 321 00000</li>
            <li>Adresse : 123 Rue Exemple, 75000 Paris, France</li>
            <li>Email : <a href="mailto:contact.alex2.dev@gmail.com" className="text-[var(--color-green)] underline">contact.alex2.dev@gmail.com</a></li>
          </ul>

          <p className="mt-4">
            Chacun exerce son activité de manière indépendante et assure sa propre facturation.
          </p>

          <p className="mt-2">
            Pour toute question générale concernant le site <strong style={{ color: "var(--color-green)" }}>&lt;alex²/&gt;</strong>, vous pouvez écrire à :  
            <a href="mailto:contact.alex2.dev@gmail.com" className="text-[var(--color-green)] underline">contact.alex2.dev@gmail.com</a>.<br />
            Chaque demande sera redirigée vers la personne concernée.
          </p>
        </ToggleSection>
          <ToggleSection title="2. Hébergement">
            <p>Le site est hébergé par :</p>
            <ul className="list-disc list-inside mt-2">
              <li>Nom de l’hébergeur : OVH</li>
              <li>Adresse : 2 Rue Kellermann, 59100 Roubaix, France</li>
              <li>Téléphone : 1007</li>
              <li>Site : <a href="https://www.ovhcloud.com" className="text-[var(--color-green)] underline" target="_blank">www.ovhcloud.com</a></li>
            </ul>
          </ToggleSection>

          <ToggleSection title="3. Propriété intellectuelle">
            <p>
              L’ensemble des contenus (textes, images, vidéos, logos, etc.) présents sur ce site sont la propriété exclusive de &lt;alex²/&gt;, sauf mentions contraires. Toute reproduction, distribution ou modification est interdite sans autorisation préalable.
            </p>
            <p className="mt-2">
              Les marques, logos ou contenus de tiers restent la propriété de leurs détenteurs respectifs.
            </p>
          </ToggleSection>

          <ToggleSection title="4. Données personnelles">
            <p>
              Ce site ne collecte pas de données personnelles autres que celles strictement nécessaires au fonctionnement et à la navigation, conformément à notre <a href="<?= BASE_URL ?>/Politique-de-confidentialité" className="text-[var(--color-green)] underline">politique de confidentialité</a>.
            </p>
          </ToggleSection>

          <ToggleSection title="5. Responsabilité">
            <p>
              &lt;alex²/&gt; s’efforce d’assurer l’exactitude et la mise à jour des informations présentes sur ce site, mais ne peut garantir leur exhaustivité. L’utilisateur utilise ces informations sous sa responsabilité exclusive.
            </p>
          </ToggleSection>

          <ToggleSection title="6. Contact">
            <p>
              Pour toute question relative aux présentes mentions légales, vous pouvez nous écrire à : <a href="mailto:contact.alex2.dev@gmail.com" className="text-[var(--color-green)] underline">contact.alex2.dev@gmail.com</a>.
            </p>
          </ToggleSection>
        </div>
      );
    }

    ReactDOM.createRoot(document.getElementById("mentions-react-root")).render(<MentionsLegalesReact />);
  </script>

  <?php include __DIR__ . '/../../includes/footer.php'; ?>
</body>
</html>
