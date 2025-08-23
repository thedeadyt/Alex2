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

$tables = ['clients','projects','projets','invoices','services','project_notes'];
$data = [];

foreach($tables as $table){
    if($table === 'services' || $table === 'projets'){
        $stmt = $pdo->query("SELECT * FROM $table");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE user_id=?");
        $stmt->execute([$user_id]);
    }
    $data[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$jsonData = json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Tableau de bord Admin</title>

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
    Factures: { 'ID':'id','Type':'type','Numéro':'number','Client':'client_id','Projet':'project_id','Montant':'amount','Statut':'status' },
    Services: { 'ID':'id','Nom':'name','Line1':'line1','Line2':'line2','Line3':'line3','Line4':'line4','Line5':'line5' },
    Notes: { 'ID':'id','Projet':'project_id','Contenu':'content' }
};

const cardsMap = {
    Clients: 'clients',
    'Projets en cours': 'projects',
    'Projet portfolio': 'projets',
    Factures: 'invoices',
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
function ModalForm({ visible, onClose, onSubmit, data, type, clients }) {
    const [formData, setFormData] = useState(data || {});
    const [search, setSearch] = useState('');
    useEffect(()=>setFormData(data || {}),[data]);

    if(!visible) return null;

    const handleChange = e => setFormData({...formData,[e.target.name]:e.target.value});
    const handleSubmit = e => { e.preventDefault(); onSubmit(formData); onClose(); };

    const fields = Object.values(columnsMap[type]).filter(f => f !== 'id');
    const filteredClients = clients?.filter(c => c.company.toLowerCase().includes(search.toLowerCase())) || [];

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div className="bg-white p-6 rounded-lg w-96">
                <h2 className="text-xl font-bold mb-4">{data?"Modifier":"Ajouter"} {type}</h2>
                <form onSubmit={handleSubmit} className="space-y-3">
                    {fields.map(f => {
                        if(f==='client_id' && type==="Projets en cours"){
                            return (
                                <div key={f}>
                                    <input
                                        type="text"
                                        placeholder="Rechercher un client..."
                                        value={search}
                                        onChange={e => setSearch(e.target.value)}
                                        className="w-full border p-2 rounded mb-1"
                                    />
                                    <select
                                        name={f}
                                        value={formData[f] || ''}
                                        onChange={handleChange}
                                        className="w-full border p-2 rounded"
                                        required
                                    >
                                        <option value="">Sélectionnez un client</option>
                                        {filteredClients.map(c => (
                                            <option key={c.id} value={c.id}>{c.company}</option>
                                        ))}
                                    </select>
                                </div>
                            )
                        }
                        return <input key={f} name={f} value={formData[f]||''} onChange={handleChange} placeholder={f} className="w-full border p-2 rounded" required />
                    })}
                    <div className="flex justify-end gap-2">
                        <button type="button" onClick={onClose} className="px-4 py-2 bg-gray-300 rounded">Annuler</button>
                        <button type="submit" className="px-4 py-2 bg-green-500 text-white rounded">{data?"Modifier":"Ajouter"}</button>
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
    const endOfMonth = new Date(date.getFullYear(), date.getMonth()+1, 0);
    const days = [];
    for(let d=startOfMonth; d<=endOfMonth; d.setDate(d.getDate()+1)) days.push(new Date(d));
    return (
        <div className="bg-white p-4 rounded-xl shadow w-full">
            <h3 className="font-bold mb-2">Calendrier</h3>
            <div className="grid grid-cols-7 gap-1 text-center">
                {['L','M','M','J','V','S','D'].map((d, idx) => (
                    <div key={d+idx} className="font-bold">{d}</div>
                ))}
                {days.map((d,i)=>{
                    const dayProjects = projects.filter(p => new Date(p.deadline).toDateString()===d.toDateString());
                    return (
                        <div key={i} className="border h-12 flex items-center justify-center relative">
                            {d.getDate()}
                            {dayProjects.length>0 && <span className="bg-red-500 w-2 h-2 rounded-full absolute bottom-1 right-1"></span>}
                        </div>
                    )
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
            <h3 className="font-bold mb-2">Horloge</h3>
            <span className="text-2xl font-mono">{time.toLocaleTimeString()}</span>
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
    const weekProjects = projects.filter(p => {
        const d = new Date(p.deadline);
        return d >= now && d <= endWeek;
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

// Dashboard
function Dashboard() {
    const [view,setView] = useState('Tableau de bord');
    const [data,setData] = useState(phpData);
    const [modalVisible,setModalVisible] = useState(false);
    const [editData,setEditData] = useState(null);
    const [currentType,setCurrentType] = useState('');

    const handleAdd = type => { setCurrentType(type); setEditData(null); setModalVisible(true); };
    const handleEdit = (type,item) => { setCurrentType(type); setEditData(item); setModalVisible(true); };
    
    const handleDelete = async (type,id) => {
        if(!confirm("Confirmer la suppression ?")) return;
        try {
            const res = await fetch(`api/${type.toLowerCase().replace(/ /g,'_')}.php`,{
                method:'DELETE',
                headers:{'Content-Type':'application/json'},
                body:JSON.stringify({id})
            });
            const json = await res.json();
            const key = type.toLowerCase().replace(/ /g,'_');
            setData({...data,[key]:data[key].filter(d=>d.id!==id)});
        } catch(err) { console.error('Erreur DELETE:', err); }
    };

    const handleSubmit = async (formData) => {
        try {
            const method = editData?'PUT':'POST';
            const res = await fetch(`api/${currentType.toLowerCase().replace(/ /g,'_')}.php`,{
                method,
                headers:{'Content-Type':'application/json'},
                body:JSON.stringify(formData)
            });
            const text = await res.text();
            let saved;
            try { saved = JSON.parse(text); } 
            catch(e){ console.error('Réponse non JSON:', text); return; }
            const key = currentType.toLowerCase().replace(/ /g,'_');
            setData({...data,[key]:editData?data[key].map(d=>d.id===saved.id?saved:d):[...data[key],saved]});
        } catch(err){ console.error('Erreur SUBMIT:', err); }
    };

    const TableWithActions = ({ type, rows }) => (
        <div>
            <button onClick={()=>handleAdd(type)} className="mb-4 px-4 py-2 bg-blue-500 text-white rounded">Ajouter {type}</button>
            <Table type={type} data={rows} onEdit={item=>handleEdit(type,item)} onDelete={id=>handleDelete(type,id)} />
        </div>
    );

    const cards = Object.entries(cardsMap).map(([title,key],idx)=>({
        title, count:data[key]?.length||0, color:['green','cyan','purple','yellow','blue','black'][idx%6], key:title
    }));

    return (
        <div className="flex flex-1 overflow-auto">
            <Sidebar setView={setView} />
            <div className="flex-1 p-8 flex flex-col gap-8">
                {/* Widgets uniquement sur le dashboard */}
                {view==='Tableau de bord' && <WeekProjects projects={data.projects} />}
                {view==='Tableau de bord' && 
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {cards.map(card=>(<Card key={card.title} {...card} onClick={()=>setView(card.key)} />))}
                    </div>
                }
                {view==='Tableau de bord' &&
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-6">
                        <CalendarWidget projects={data.projects} />
                        <ClockWidget />
                        <UrgentProjects projects={data.projects} />
                    </div>
                }

                {/* Tables */}
                {view==='Clients' && <TableWithActions type="Clients" rows={data.clients} />}
                {view==='Projets en cours' && <TableWithActions type="Projets en cours" rows={data.projects} />}
                {view==='Projet portfolio' && <TableWithActions type="Projet portfolio" rows={data.projets} />}
                {view==='Factures' && <TableWithActions type="Factures" rows={data.invoices} />}
                {view==='Services' && <TableWithActions type="Services" rows={data.services} />}
                {view==='Notes' && <TableWithActions type="Notes" rows={data.project_notes} />}

                <ModalForm visible={modalVisible} onClose={()=>setModalVisible(false)} onSubmit={handleSubmit} data={editData} type={currentType} clients={data.clients} />
            </div>
        </div>
    );
}

ReactDOM.createRoot(document.getElementById('root')).render(<Dashboard />);
</script>


</body>
</html>
