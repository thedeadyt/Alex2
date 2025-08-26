<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: " . BASE_URL . "/login");
    exit;
}

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: text/html; charset=utf-8');

$user_id = $_SESSION["user_id"];

$tables = ['clients','projects','projets','services','project_notes'];
$data = [];

foreach($tables as $table){
    if ($table === 'services' || $table === 'projets') {
        // 🔹 Ces tables ne sont pas liées à l’utilisateur
        $stmt = $pdo->query("SELECT * FROM $table");
        $data[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } elseif ($table === 'projects') {
        // 🔹 Jointure pour récupérer aussi le client lié au projet
        $stmt = $pdo->prepare("
          SELECT p.*, c.name AS client_name, c.company AS client_company
          FROM projects p
          JOIN clients c ON p.client_id = c.id
          WHERE p.user_id = ?

        ");
        $stmt->execute([$user_id]);
        $data[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } elseif ($table === 'project_notes') {
        // 🔹 Jointure pour récupérer aussi le nom du projet associé
        $stmt = $pdo->prepare("
            SELECT pn.*, p.title AS project_title
            FROM project_notes pn
            JOIN projects p ON pn.project_id = p.id
            WHERE pn.user_id = ?
            ORDER BY pn.created_at DESC
        ");
        $stmt->execute([$user_id]);
        $data[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } else {
        // 🔹 Tables liées directement à l’utilisateur (ex: clients)
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $data[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Encodage en JSON pour React
$jsonData = json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Tableau de bord Admin</title>
<link rel="icon" href="<?= BASE_URL ?>/Alex2logo.png" type="image/x-icon">
<script src="https://cdn.tailwindcss.com"></script>
<script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
<link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
</head>
<body class="bg-gray-100 font-sans h-screen flex flex-col">

<header class="bg-white shadow p-4 flex justify-between items-center">
    <h2 class="text-xl font-bold">Bienvenue <?= htmlspecialchars($_SESSION["username"]) ?></h2>
    <a href="../pages/logout.php" class="text-red-500 hover:underline">Déconnexion</a>
</header>

<div id="root" class="flex-1 flex overflow-hidden"></div>

<script type="text/babel">
const { useState, useEffect } = React;
const phpData = <?= $jsonData ?>;

const columnsMap = {
    Clients: { 'ID':'id','Nom':'name','Société':'company','Email':'email','Téléphone':'phone','Adresse':'address' },
    'Projets en cours': { 'ID':'id','Titre':'title','Client':'client_name','Statut':'status','Deadline':'deadline' },
    'Projet portfolio': { 'ID':'id','Nom':'nom','Année':'annee','Type':'type','Image':'image','Description courte':'description_courte','Description détaillée':'description_detaillee','Lien':'lien' },
    Services: { 'ID':'id','Nom':'name','Line1':'line1','Line2':'line2','Line3':'line3','Line4':'line4','Line5':'line5' },
    Notes: { 'ID':'id', 'Projet':'project_title', 'Contenu':'content', 'Créé le':'created_at' }
};

const cardsMap = {
    Clients: 'clients',
    'Projets en cours': 'projects',
    'Projet portfolio': 'projets',
    Services: 'services',
    Notes: 'project_notes'
};

// Sidebar
function Sidebar({ setView }) {
    const menu = Object.keys(cardsMap);
    menu.unshift('Tableau de bord');
    return (
        <div className="w-64 bg-gray-900 text-white flex flex-col p-4">
            <h1 className="text-2xl font-bold mb-8">Tableau de bord</h1>
            {menu.map(item => (
                <button key={item} onClick={() => setView(item)} className="text-left px-4 py-2 mb-2 rounded hover:bg-gray-700 transition">{item}</button>
            ))}
        </div>
    );
}

// Card
function Card({ title, count, color, onClick }) {
    const colors = { green:"bg-green-500", cyan:"bg-cyan-500", black:"bg-gray-900", purple:"bg-purple-500", yellow:"bg-yellow-500", blue:"bg-blue-500" };
    return (
        <div onClick={onClick} className={`cursor-pointer p-12 rounded-xl shadow-lg flex flex-col justify-center items-center ${colors[color]} text-white hover:scale-105 transform transition`}>
            <span className="text-4xl font-bold">{count}</span>
            <span className="text-xl mt-4">{title}</span>
        </div>
    );
}

// Table
function Table({ type, data, onEdit, onDelete }) {
    const columns = Object.keys(columnsMap[type]);
    const fields = Object.values(columnsMap[type]);
    return (
        <div className="overflow-auto rounded-lg shadow bg-white p-4">
            <table className="min-w-full divide-y divide-gray-200">
                <thead className="bg-gray-50">
                    <tr>
                        {columns.map(col => <th key={col} className="px-4 py-2 text-left font-medium text-gray-700">{col}</th>)}
                        <th className="px-4 py-2 text-left font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody className="divide-y divide-gray-100">
                    {data.map((row, idx) => (
                        <tr key={row.id} className={idx % 2 === 0 ? 'bg-gray-50' : 'bg-white'}>
                            {fields.map(f => <td key={f} className="px-4 py-2">{row[f]}</td>)}
                            <td className="px-4 py-2 flex gap-2">
                                <button onClick={()=>onEdit(row)} className="px-2 py-1 bg-yellow-400 rounded">Modifier</button>
                                <button onClick={()=>onDelete(row.id)} className="px-2 py-1 bg-red-500 text-white rounded">Supprimer</button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}

// Modal Form
// Modal Form
function ModalForm({ visible, onClose, onSubmit, data, type, clientId }) {
    const [formData, setFormData] = useState(data || { client_id: clientId });
    const [projects, setProjects] = useState([]);

    useEffect(() => {
        setFormData(data || { client_id: clientId });

        if (type === "Notes") {
            fetch("api/projects.php")
                .then(res => res.json())
                .then(setProjects);
        }
    }, [data, clientId, type]);

    if (!visible) return null;

    const handleChange = e =>
        setFormData({ ...formData, [e.target.name]: e.target.value });
    const handleSubmit = e => {
        e.preventDefault();
        onSubmit(formData);
        onClose();
    };

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div className="bg-white p-6 rounded-lg w-96">
                <h2 className="text-xl font-bold mb-4">
                    {data ? "Modifier" : "Ajouter"} {type}
                </h2>
                <form onSubmit={handleSubmit} className="space-y-3">

                    {/* Clients */}
                    {type === "Clients" && (
                        <>
                            <input type="text" name="name" value={formData.name || ''} onChange={handleChange} placeholder="Nom" className="w-full border p-2 rounded" required />
                            <input type="text" name="company" value={formData.company || ''} onChange={handleChange} placeholder="Société" className="w-full border p-2 rounded" />
                            <input type="email" name="email" value={formData.email || ''} onChange={handleChange} placeholder="Email" className="w-full border p-2 rounded" />
                            <input type="text" name="phone" value={formData.phone || ''} onChange={handleChange} placeholder="Téléphone" className="w-full border p-2 rounded" />
                            <textarea name="address" value={formData.address || ''} onChange={handleChange} placeholder="Adresse" className="w-full border p-2 rounded" />
                        </>
                    )}

                    {/* Projets en cours */}
                    {type === "Projets en cours" && (
                        <>
                            <select name="client_id" value={formData.client_id || ""} onChange={handleChange} className="w-full border p-2 rounded mb-2" required>
                                <option value="">-- Choisir un client --</option>
                                {phpData.clients.map(c => (
                                    <option key={c.id} value={c.id}>{c.name} ({c.company})</option>
                                ))}
                            </select>
                            <select name="status" value={formData.status || ""} onChange={handleChange} className="w-full border p-2 rounded mb-2" required>
                                <option value="">-- Choisir un statut --</option>
                                <option value="En cours">En cours</option>
                                <option value="Terminé">Terminé</option>
                                <option value="À faire">À faire</option>
                            </select>
                            <input type="date" name="deadline" value={formData.deadline || ''} onChange={handleChange} className="w-full border p-2 rounded" required />
                            <input type="text" name="title" value={formData.title || ''} onChange={handleChange} placeholder="Titre du projet" className="w-full border p-2 rounded" required />
                        </>
                    )}

{/* Projet portfolio */}
{type === "Projet portfolio" && (
    <>
        <input type="text" name="nom" value={formData.nom || ''} onChange={handleChange} placeholder="Nom" className="w-full border p-2 rounded" required />
        <input type="number" name="annee" value={formData.annee || ''} onChange={handleChange} placeholder="Année" className="w-full border p-2 rounded" required />
        <input type="text" name="type" value={formData.type || ''} onChange={handleChange} placeholder="Type" className="w-full border p-2 rounded" />
        <input type="file" name="image" onChange={e => setFormData({ ...formData, image: e.target.files[0] })} className="w-full border p-2 rounded" />
        <textarea name="description_courte" value={formData.description_courte || ''} onChange={handleChange} placeholder="Description courte" className="w-full border p-2 rounded" />
        <textarea name="description_detaillee" value={formData.description_detaillee || ''} onChange={handleChange} placeholder="Description détaillée" className="w-full border p-2 rounded" />
        <input type="url" name="lien" value={formData.lien || ''} onChange={handleChange} placeholder="Lien projet" className="w-full border p-2 rounded" />
    </>
)}

                    {/* Services */}
                    {type === "Services" && (
                        <>
                            <input type="text" name="name" value={formData.name || ''} onChange={handleChange} placeholder="Nom" className="w-full border p-2 rounded" required />
                            <input type="text" name="line1" value={formData.line1 || ''} onChange={handleChange} placeholder="Ligne 1" className="w-full border p-2 rounded" />
                            <input type="text" name="line2" value={formData.line2 || ''} onChange={handleChange} placeholder="Ligne 2" className="w-full border p-2 rounded" />
                            <input type="text" name="line3" value={formData.line3 || ''} onChange={handleChange} placeholder="Ligne 3" className="w-full border p-2 rounded" />
                            <input type="text" name="line4" value={formData.line4 || ''} onChange={handleChange} placeholder="Ligne 4" className="w-full border p-2 rounded" />
                            <input type="text" name="line5" value={formData.line5 || ''} onChange={handleChange} placeholder="Ligne 5" className="w-full border p-2 rounded" />
                        </>
                    )}

                    {/* Notes */}
                    {type === "Notes" && (
                        <>
                            <select name="project_id" value={formData.project_id || ""} onChange={handleChange} className="w-full border p-2 rounded mb-2" required>
                                <option value="">-- Choisir un projet --</option>
                                {projects.map(p => (
                                    <option key={p.id} value={p.id}>{p.title}</option>
                                ))}
                            </select>
                            <textarea name="content" value={formData.content || ''} onChange={handleChange} placeholder="Contenu de la note" className="w-full border p-2 rounded" required />
                        </>
                    )}

                    <div className="flex justify-end gap-2">
                        <button type="button" onClick={onClose} className="px-4 py-2 bg-gray-300 rounded">Annuler</button>
                        <button type="submit" className="px-4 py-2 bg-green-500 text-white rounded">{data ? "Modifier" : "Ajouter"}</button>
                    </div>
                </form>
            </div>
        </div>
    );
}
// Widgets
function CalendarWidget({ projects }) {
    const [date, setDate] = useState(new Date());

    const startOfMonth = new Date(date.getFullYear(), date.getMonth(), 1);
    const endOfMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0);

    // Générer les jours du mois
    const days = [];
    for (let d = new Date(startOfMonth); d <= endOfMonth; d.setDate(d.getDate() + 1)) {
        days.push(new Date(d));
    }

    // Navigation mois précédent/suivant
    const prevMonth = () => setDate(new Date(date.getFullYear(), date.getMonth() - 1, 1));
    const nextMonth = () => setDate(new Date(date.getFullYear(), date.getMonth() + 1, 1));

    const monthNames = [
        "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
        "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
    ];

    return (
        <div className="bg-white p-4 rounded-xl shadow w-full">
            <div className="flex justify-between items-center mb-4">
                <button onClick={prevMonth} className="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">◀</button>
                <h3 className="font-bold text-lg">
                    {monthNames[date.getMonth()]} {date.getFullYear()}
                </h3>
                <button onClick={nextMonth} className="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">▶</button>
            </div>

            <div className="grid grid-cols-7 gap-1 text-center">
                {['L','M','M','J','V','S','D'].map((d, idx) => (
                    <div key={d+idx} className="font-bold">{d}</div>
                ))}
                {days.map((d, i) => {
                    const dayProjects = projects.filter(
                        p => new Date(p.deadline).toDateString() === d.toDateString()
                    );
                    return (
                        <div
                            key={i}
                            className="border h-12 flex items-center justify-center relative"
                        >
                            {d.getDate()}
                            {dayProjects.length > 0 && (
                                <span className="bg-red-500 w-2 h-2 rounded-full absolute bottom-1 right-1"></span>
                            )}
                        </div>
                    );
                })}
            </div>
        </div>
    );
}


function ClockWidget() {
    const [time,setTime] = useState(new Date());
    useEffect(()=> { const interval = setInterval(()=>setTime(new Date()),1000); return ()=>clearInterval(interval); },[]);
    return (
        <div className="bg-white p-4 rounded-xl shadow flex flex-col items-center justify-center w-full">
            <span 
                className="text-2xl" 
                style={{ fontFamily: "var(--font-heading)" }}
                >
                {time.toLocaleTimeString()}
            </span>

        </div>
    );
}

function UrgentProjects({ projects }) {
    const now = new Date();
    const endOfMonth = new Date(now.getFullYear(), now.getMonth()+1,0);
    const urgent = projects.filter(p => { const d=new Date(p.deadline); return d>=now && d<=endOfMonth; });
    if(urgent.length===0) return <div className="bg-white p-4 rounded-xl shadow w-full">Pas de projet urgent ce mois</div>;
    return (
        <div className="bg-white p-4 rounded-xl shadow w-full">
            <h3 className="font-bold mb-2">Projets finissant ce mois</h3>
            <ul className="list-disc pl-5">{urgent.map(p=><li key={p.id}>{p.title} - {new Date(p.deadline).toLocaleDateString()}</li>)}</ul>
        </div>
    );
}

function WeekProjects({ projects }) {
    const now = new Date();
    const endWeek = new Date();
    endWeek.setDate(now.getDate() + 7);

    // Filtrer les projets non terminés ET dans la semaine
    const weekProjects = projects.filter(p => {
        const d = new Date(p.deadline);
        return d >= now && d <= endWeek && p.status !== "Terminé";
    });

    return (
        <div className="bg-white p-4 rounded-xl shadow w-full mb-6">
            <h3 className="font-bold mb-2 text-red-700">Projets urgents cette semaine</h3>
            {weekProjects.length === 0 ? (
                <p>Aucun projet urgent cette semaine</p>
            ) : (
                <ul className="list-disc pl-5">
                    {weekProjects.map(p => (
                        <li key={p.id}>{p.title} - {new Date(p.deadline).toLocaleDateString()}</li>
                    ))}
                </ul>
            )}
        </div>
    );
}

// Portfolio Grid
function PortfolioGrid({ projets, onEdit, onDelete }) {
    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {projets.map(p => (
                <div key={p.id} className="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                    <img src={p.image} alt={p.nom} className="h-48 w-full object-cover"/>
                    <div className="p-4 flex flex-col flex-1">
                        <h3 className="font-bold text-lg mb-1">{p.nom} ({p.annee})</h3>
                        <p className="text-sm text-gray-600 mb-2">{p.type}</p>
                        <p className="text-gray-700 text-sm flex-1">{p.description_courte}</p>
                        {p.lien && (
                            <a href={p.lien} target="_blank" rel="noopener noreferrer" className="mt-2 text-blue-500 hover:underline">
                                Voir le projet
                            </a>
                        )}
                        <div className="flex justify-end mt-2 gap-2">
                            <button onClick={() => onEdit(p)} className="px-2 py-1 bg-yellow-400 rounded">Modifier</button>
                            <button onClick={() => onDelete(p.id)} className="px-2 py-1 bg-red-500 text-white rounded">Supprimer</button>
                        </div>
                    </div>
                </div>
            ))}
        </div>
    );
}
// Dashboard
function Dashboard() {
  const [loading, setLoading] = useState(false);

  // 🔹 Mapping des noms visibles -> fichiers API
  const apiMap = {
    "Clients": "clients",
    "Projets en cours": "projects",   // correspond à projects.php
    "Projet portfolio": "projets",    // correspond à projets.php
    "Services": "services",
    "Notes": "project_notes"
  };

  const buildApiUrl = (type, id = null) => {
    const key = apiMap[type] || type.toLowerCase().replace(/ /g, "_");
    return id ? `api/${key}.php?id=${id}` : `api/${key}.php`;
  };

  const refreshType = async (type) => {
    try {
      setLoading(true);
      const res = await fetch(buildApiUrl(type));
      const json = await res.json();
      const key = apiMap[type] || type.toLowerCase().replace(/ /g, "_");
      setData(prev => ({ ...prev, [key]: json }));
    } catch (err) {
      console.error("Erreur refresh", type, err);
    } finally {
      setLoading(false);
    }
  };

  const [view, setView] = useState("Tableau de bord");
  const [data, setData] = useState({
    clients: phpData.clients || [],
    projects: phpData.projects || [],
    services: phpData.services || [],
    projets: phpData.projets || [],
    project_notes: phpData.project_notes || []
  });
  const [modalVisible, setModalVisible] = useState(false);
  const [editData, setEditData] = useState(null);
  const [currentType, setCurrentType] = useState("");

  const handleAdd = (type) => {
    setCurrentType(type);
    setEditData(null);
    setModalVisible(true);
  };

  const handleEdit = (type, item) => {
    setCurrentType(type);
    setEditData(item);
    setModalVisible(true);
  };

  const handleDelete = async (type, id) => {
    if (!id) return alert("ID manquant !");
    if (!confirm("Confirmer la suppression ?")) return;

    try {
      const res = await fetch(buildApiUrl(type, id), {
        method: "DELETE",
        headers: { "Content-Type": "application/json" }
      });

      const json = await res.json();

      if (res.ok) {
        alert(json.message || "Supprimé !");
        await refreshType(type);
      } else {
        alert(`Erreur : ${json.message || json.error || "Inconnue"}`);
      }
    } catch (err) {
      console.error("Erreur DELETE:", err);
      alert("Erreur réseau");
    }
  };

const handleSubmit = async (formData) => {
    try {
        const method = editData ? "PUT" : "POST";
        const url = editData
            ? buildApiUrl(currentType, editData.id)
            : buildApiUrl(currentType);

        let body;
        let headers = {};

        // Pour Projet Portfolio avec image
        if (currentType === "Projet portfolio") {
            body = new FormData();
            for (let key in formData) {
                if (formData[key] instanceof File) {
                    body.append(key, formData[key]);
                } else {
                    body.append(key, formData[key]);
                }
            }
            // Ne PAS définir Content-Type, le navigateur le fait automatiquement
        } else {
            body = JSON.stringify(formData);
            headers["Content-Type"] = "application/json";
        }

        const res = await fetch(url, { method, body, headers });
        const saved = await res.json();

        if (!res.ok) {
            alert(`Erreur : ${saved.message || saved.error || "Inconnue"}`);
            return;
        }

        await refreshType(currentType);
        setEditData(null);
        setModalVisible(false);
    } catch (err) {
        console.error("Erreur SUBMIT:", err);
        alert("Erreur réseau : " + err.message);
    }
};


  const TableWithActions = ({ type, rows }) => (
    <div>
      <button
        onClick={() => handleAdd(type)}
        className="mb-4 px-4 py-2 bg-blue-500 text-white rounded"
      >
        Ajouter {type}
      </button>
      <Table
        type={type}
        data={rows}
        onEdit={(item) => handleEdit(type, item)}
        onDelete={(id) => handleDelete(type, id)}
      />
    </div>
  );

  const cards = Object.entries(cardsMap).map(([title, key], idx) => ({
    title,
    count: data[key]?.length || 0,
    color: ["green", "cyan", "purple", "yellow", "blue", "black"][idx % 6],
    key: title
  }));

  return (
    <div className="flex flex-1 overflow-auto">
      <Sidebar setView={setView} />
      <div className="flex-1 p-8 flex flex-col gap-8">
        {view === "Tableau de bord" && <WeekProjects projects={data.projects} />}
        {view === "Tableau de bord" && (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {cards.map((card) => (
              <Card
                key={card.title}
                {...card}
                onClick={() => setView(card.key)}
              />
            ))}
          </div>
        )}
        {view === "Tableau de bord" && (
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-6">
            <CalendarWidget projects={data.projects.filter(p => p.status !== "Terminé")} />
            <ClockWidget />
            <UrgentProjects projects={data.projects.filter(p => p.status !== "Terminé")} />
          </div>
        )}

        {view === "Clients" && (
          <TableWithActions type="Clients" rows={data.clients} />
        )}
        {view === "Projets en cours" && (
          <TableWithActions type="Projets en cours" rows={data.projects} />
        )}
        {view === "Projet portfolio" && (
          <div>
            <button
              onClick={() => handleAdd("Projet portfolio")}
              className="mb-4 px-4 py-2 bg-blue-500 text-white rounded"
            >
              Ajouter Projet
            </button>
            <PortfolioGrid
              projets={data.projets}
              onEdit={(item) => handleEdit("Projet portfolio", item)}
              onDelete={(id) => handleDelete("Projet portfolio", id)}
            />
          </div>
        )}
        {view === "Services" && (
          <TableWithActions type="Services" rows={data.services} />
        )}
        {view === "Notes" && (
            <TableWithActions type="Notes" rows={data.project_notes} />
        )}


        <ModalForm
          visible={modalVisible}
          onClose={() => setModalVisible(false)}
          onSubmit={handleSubmit}
          data={editData}
          type={currentType}
          clients={data.clients}
        />
      </div>
    </div>
  );
}


ReactDOM.createRoot(document.getElementById('root')).render(<Dashboard />);
</script>


</body>
</html>
