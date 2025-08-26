<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
// Inclure seulement 2 projets pour la page d'accueil
$sql = "SELECT id, nom, annee, type, image, description_courte, description_detaillee, lien FROM projets ORDER BY annee DESC LIMIT 2";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$projetsAccueil = $stmt->fetchAll(PDO::FETCH_ASSOC);
$services = [];
$stmt = $pdo->query("SELECT * FROM services");
if ($stmt) {
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Accueil | &lt;Alex²/&gt;</title>
    <link rel="icon" href="./Alex2logo.png" type="image/x-icon">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='<?= BASE_URL ?>/asset/css/index.css'>
    <!-- React & ReactDOM -->
    <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <script>
      if (!sessionStorage.getItem('animation_done')) {
        sessionStorage.setItem('animation_done', 'true');
        window.location.href = "<?= BASE_URL ?>/animation";
      }
    </script>
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">
  <?php
  include __DIR__ . '/../includes/header.php';
  ?>
  <section id="content">
    <!-- Description -->
    <section id="description" class="py-20 px-6 text-center overflow-hidden">
      <div class="max-w-5xl mx-auto space-y-12">
        <!-- Titre avec machine à écrire (sans clignotement) -->
        <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-black text-center px-4 leading-snug md:leading-tight" style="font-family: var(--font-bounded);">
          
          <!-- Version PC (une seule ligne) -->
          <span class="typewriter-text single-typing hover-effect">
            &lt;Alex²/&gt; — écrire du code qui a du sens
          </span>

          <!-- Version Mobile (multi lignes avec curseur séquentiel) -->
          <span class="multi-typing">
            <span class="typewriter-line line1 hover-effect">&lt;Alex²/&gt; — écrire</span>
            <span class="typewriter-line line2 hover-effect">du code</span>
            <span class="typewriter-line line3 hover-effect">qui a du sens</span>
          </span>
        </h2>

        <!-- Bloc animé -->
        <div class="md:flex md:items-center md:justify-center gap-12 animate-fade-in-up">
          <div class="text-left md:w-1/2 space-y-4 text-gray-700 text-lg" style="font-family: var(--font-tinos);">
            <p>
              Chez <strong class="text-black">&lt;Alex²/&gt;</strong>, chaque balise, chaque classe, chaque requête est pensée pour faire <span class="text-green-600 font-semibold">mieux avec moins</span>.
            </p>
            <p>
              Notre code est <span class="bg-green-100 text-green-800 font-medium px-1 rounded">lisible</span>, <span class="bg-green-100 text-green-800 font-medium px-1 rounded">maintenable</span> et <span class="bg-green-100 text-green-800 font-medium px-1 rounded">durable</span> : pas de frameworks inutiles, pas d’effets tape-à-l’œil, juste l’essentiel.
            </p>
            <p>
              Comme un bon terminal : rapide, précis, et silencieux.
            </p>
          </div>

<div class="mt-6 md:mt-0 md:w-1/2 w-full px-4">
  <div class="bg-white/70 backdrop-blur-md rounded-lg border border-gray-300 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-x-auto p-5">
    <pre class="text-sm sm:text-base font-mono text-left text-gray-900 leading-relaxed whitespace-pre-wrap">
<span class="text-green-600">// Notre philosophie</span>
<span class="text-blue-600">function</span> <span class="text-black">buildWebsite</span>() {
    <span class="text-purple-600">return</span> <span class="text-black">[</span>"performance", "accessibilité", "sobriété"<span class="text-black">];</span>
}
    </pre>
  </div>
</div>


        </div>
      </div>
    </section>


    <!-- Projet -->
    <section id="projet" class="text-center py-8">
      <h2 class="text-3xl font-bold mb-4">Projet</h2>
      <div id="projets-accueil-root" class="px-4 py-6"></div>
      <div class="mt-6">
        <a href="<?= BASE_URL ?>/Nos-Réalisations" class="inline-block bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition">
          Voir tous les projets
        </a>
      </div>

      <script>
        const BASE_URL = "<?= BASE_URL ?>";
        window.projetsAccueil = <?= json_encode($projetsAccueil, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
      </script>
    </section>

    <!-- Services -->
    <section id="services" class="text-center py-16 px-6">
      <h2 class="text-4xl font-bold mb-12">Services</h2>

      <div id="react-bubbles" class="grid grid-cols-2 md:grid-cols-4 gap-10 max-w-6xl mx-auto"></div>

      <div class="mt-12">
        <a href="<?= BASE_URL ?>/Services"
          class="inline-block text-white px-6 py-3 rounded-full font-medium shadow-md hover:shadow-lg transition duration-300"
          style="background: linear-gradient(to right, var(--color-green), var(--color-cyan)); font-family: var(--font-tinos);">
          Voir tous les services
        </a>
      </div>

      <script>
        window.servicesFromPHP = <?= json_encode([
          ['name' => 'site_vitrine_simple'],
          ['name' => 'site_vitrine_personnalise'],
          ['name' => 'maintenance_mensuelle'],
          ['name' => 'seo_mensuel'],
        ]) ?>;
      </script>
    </section>

  </section>
  <?php
  include __DIR__ . '/../includes/footer.php';
  ?>
  <script>
    document.querySelectorAll(".typewriter-line").forEach((line, index, lines) => {
  line.addEventListener("animationend", (e) => {
    if (e.animationName.startsWith("typing")) {
      // Supprime le curseur de la ligne terminée (sauf la dernière)
      if (index < lines.length - 1) {
        line.style.borderRight = "none";
      }
    }
  });
});

  </script>
  <script type="text/babel">
    const ProjectCard = ({ projet, onClick }) => (
      <div
        className="bg-white rounded-2xl shadow-md p-4 mx-2 w-full md:min-w-[300px] md:max-w-sm flex-shrink-0 transition-transform hover:scale-105 cursor-pointer"
        onClick={() => onClick(projet)}
      >
        <img src={`${BASE_URL}${projet.image}`} alt={projet.nom} className="w-32 h-32 object-cover rounded-lg mx-auto mb-4" />
        <h3 className="text-xl font-bold mb-1 text-center">{projet.nom}</h3>
        <p className="text-sm text-gray-500 text-center mb-2">{projet.annee} · {projet.type}</p>
        <p className="text-sm text-gray-700 text-center">{projet.description_courte}</p>
      </div>
    );

    const Modal = ({ projet, onClose }) => {
      if (!projet) return null;
      return (
        <div className="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" onClick={onClose}>
          <div className="bg-white rounded-xl w-full max-w-xl mx-4 shadow-xl relative p-6" onClick={e => e.stopPropagation()}>
            <button className="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl" onClick={onClose}>
              &times;
            </button>
            <img src={`${BASE_URL}${projet.image}`} alt={projet.nom} className="w-full h-64 object-cover rounded-lg mb-4" />
            <h2 className="text-2xl font-bold mb-2">{projet.nom}</h2>
            <p className="text-sm text-gray-500 mb-4">{projet.annee} · {projet.type}</p>
            <p className=" mb-6 whitespace-pre-line">{projet.description_detaillee}</p>
            <a href={projet.lien} target="_blank" rel="noopener noreferrer" className="inline-block bg-black px-6 py-2 rounded-lg hover:bg-gray-800 transition" style={{ color: "var(--color-white)" }}>
              Voir le projet
            </a>
          </div>
        </div>
      );
    };

    const AccueilProjets = () => {
      const [selectedProjet, setSelectedProjet] = React.useState(null);
      const projets = window.projetsAccueil || [];

      return (
        <>
          <div className="flex flex-col md:flex-row justify-center items-center gap-6">
            {projets.map(projet => (
              <ProjectCard key={projet.id} projet={projet} onClick={setSelectedProjet} />
            ))}
          </div>
          {selectedProjet && <Modal projet={selectedProjet} onClose={() => setSelectedProjet(null)} />}
        </>
      );
    };

    ReactDOM.createRoot(document.getElementById("projets-accueil-root")).render(<AccueilProjets />);
  </script>
  <script type="text/babel">
    const ServiceBubble = ({ name }) => {
      const displayName = name.replace(/_/g, " ").replace(/\b\w/g, l => l.toUpperCase());

      return (
        <div className="service-bubble mx-auto cursor-pointer hover:scale-[1.08] transition-transform duration-300">
          <span className="service-name" style={{ color: "var(--color-white)" }}>{displayName}</span>
        </div>
      );
    };

    const ServicesGrid = () => {
      const services = window.servicesFromPHP || [];
      return (
        <>
          {services.map((service, index) => (
            <ServiceBubble key={index} name={service.name} />
          ))}
        </>
      );
    };

    ReactDOM.createRoot(document.getElementById("react-bubbles")).render(<ServicesGrid />);
  </script>
</body>
</html>
