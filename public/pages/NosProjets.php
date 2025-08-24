<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

// Récupérer les projets depuis la BDD
$sql = "SELECT id, nom, annee, type, image, description_courte, description_detaillee, lien FROM projets ORDER BY annee DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Projets | &lt;Alex²/&gt;</title>
  <link rel="icon" href="<?= BASE_URL ?>/Alex2logo.png" type="image/x-icon">
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
  <link rel="stylesheet" type="text/css" media="screen" href="<?= BASE_URL ?>/asset/css/NosProjets.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- React & ReactDOM -->
  <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

  <!-- Projets injectés depuis PHP -->
  <script>
    window.projetsFromPHP = <?= json_encode($projets, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
  </script>
</head>

<body style="background-color: var(--color-white); color: var(--color-black);">
  <?php include __DIR__ . '/../../includes/header.php'; ?>

  <section id="content">
    <div id="projets-root" class="px-6 py-10"></div>
  </section>

  <?php include __DIR__ . '/../../includes/footer.php'; ?>

  <!-- React Logic -->
  <script type="text/babel">
    const ProjectCard = ({ projet, onClick }) => (
      <div
        className="bg-white rounded-2xl shadow-md p-4 mx-2 md:mx-0 w-full md:min-w-[300px] md:max-w-sm flex-shrink-0 transition-transform hover:scale-105 cursor-pointer"
        onClick={() => onClick(projet)}
      >
        <img src={projet.image} alt={projet.nom} className="w-32 h-32 object-cover rounded-lg mx-auto mb-4" />
        <h3 className="text-xl font-bold mb-1 text-center">{projet.nom}</h3>
        <p className="text-sm text-gray-500 text-center mb-2">{projet.annee} · {projet.type}</p>
        <p className="text-sm text-gray-700 text-center">{projet.description_courte}</p>
      </div>
    );

    const Modal = ({ projet, onClose }) => {
      if (!projet) return null;

      return (
        <div className="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" onClick={onClose}>
          <div
            className="bg-white rounded-xl w-full max-w-xl mx-4 shadow-xl relative p-6"
            onClick={e => e.stopPropagation()}
          >
            <button
              className="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl"
              onClick={onClose}
            >
              &times;
            </button>
            <img src={projet.image} alt={projet.nom} className="w-full h-64 object-cover rounded-lg mb-4" />
            <h2 className="text-2xl font-bold mb-2">{projet.nom}</h2>
            <p className="text-sm text-gray-500 mb-4">{projet.annee} · {projet.type}</p>
            <p className="text-gray-700 mb-6 whitespace-pre-line">{projet.description_detaillee}</p>
            <a
              href={projet.lien}
              target="_blank"
              rel="noopener noreferrer"
              className="inline-block bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition"
            >
              Voir le projet
            </a>
          </div>
        </div>
      );
    };

    const ScrollStack = () => {
      const [projets, setProjets] = React.useState([]);
      const [selectedProjet, setSelectedProjet] = React.useState(null);
      const [showAll, setShowAll] = React.useState(false);

      React.useEffect(() => {
        setProjets(window.projetsFromPHP || []);
      }, []);

      const isMobile = window.innerWidth < 768;
      const visibleProjets = showAll || !isMobile ? projets : projets.slice(0, 2);

      return (
        <>
          {/* Mobile (stacked) */}
          <div className="block md:hidden space-y-4">
            {visibleProjets.map(projet => (
              <ProjectCard key={projet.id} projet={projet} onClick={setSelectedProjet} />
            ))}
            {!showAll && projets.length > 2 && (
              <div className="text-center mt-4">
                <button
                  className="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition"
                  onClick={() => setShowAll(true)}
                >
                  Afficher plus
                </button>
              </div>
            )}
          </div>
          {/* Desktop (grid responsive) */}
          <div className="hidden md:grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 justify-items-center px-4">
            {projets.map(projet => (
              <ProjectCard key={projet.id} projet={projet} onClick={setSelectedProjet} />
            ))}
          </div>


          {selectedProjet && (
            <Modal projet={selectedProjet} onClose={() => setSelectedProjet(null)} />
          )}
        </>
      );
    };

    ReactDOM.createRoot(document.getElementById('projets-root')).render(<ScrollStack />);
  </script>

</body>
</html>
