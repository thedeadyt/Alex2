<?php
session_start();

// Charger la config AVANT de l'utiliser
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: " . BASE_URL . "login");
    exit;
}

header('Content-Type: text/html; charset=utf-8');

// Charger uniquement les données du site public
$data = [];

// Portfolio (projets publics affichés sur le site)
$stmt = $pdo->query("SELECT * FROM projets ORDER BY annee DESC");
$data['projets'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Services (services affichés sur le site)
$stmt = $pdo->query("SELECT * FROM services");
$data['services'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Blog (articles de blog)
$stmt = $pdo->query("SELECT * FROM blog ORDER BY date_publication DESC");
$data['blog'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Témoignages (tous, y compris inactifs)
$stmt = $pdo->query("SELECT * FROM temoignages ORDER BY date_creation DESC");
$data['temoignages'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Encodage en JSON pour React
$jsonData = json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard - Gestion du site</title>
<link rel="icon" href="<?= BASE_URL ?>Alex2logo.png" type="image/x-icon">
<script src="https://cdn.tailwindcss.com"></script>
<script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
<link rel="stylesheet" href="<?= BASE_URL ?>asset/css/variables.css?v=10">
</head>
<body class="h-screen flex flex-col" style="background-color: var(--color-light-gray); font-family: var(--font-tinos);">

<header class="shadow p-4 flex justify-between items-center" style="background-color: var(--color-white);">
    <div class="flex items-center gap-3">
        <img src="<?= BASE_URL ?>Alex2logo.png" alt="Alex² Logo" class="h-10 w-10">
        <h2 class="text-2xl font-black" style="font-family: var(--font-bounded); color: var(--color-black);">
            Dashboard - <?= htmlspecialchars($_SESSION["username"]) ?>
        </h2>
    </div>
    <a href="../pages/logout.php" class="px-4 py-2 rounded hover:opacity-80 transition" style="background-color: var(--color-green); color: var(--color-white); font-family: var(--font-tinos);">
        Déconnexion
    </a>
</header>

<div id="root" class="flex-1 flex overflow-hidden"></div>
<script>window.BASE_URL = "<?= BASE_URL ?>";</script>

<script type="text/babel">
const { useState } = React;
const BASE_URL = window.BASE_URL || '/Alex2/';
const phpData = <?= $jsonData ?>;

// Sidebar
function Sidebar({ setView, currentView }) {
    const menu = [
        { name: 'Portfolio', icon: '📂' },
        { name: 'Services', icon: '⚙️' },
        { name: 'Blog', icon: '📝' },
        { name: 'Avis', icon: '⭐' }
    ];
    return (
        <div className="w-64 flex flex-col p-4" style={{ backgroundColor: "var(--color-black)", color: "var(--color-white)" }}>
            <h1 className="text-3xl font-black mb-8" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-green)" }}>
                📋 Menu
            </h1>
            {menu.map(item => (
                <button
                    key={item.name}
                    onClick={() => setView(item.name)}
                    className={`text-left px-4 py-3 mb-2 rounded transition ${
                        currentView === item.name ? 'shadow-lg' : 'hover:opacity-80'
                    }`}
                    style={{
                        backgroundColor: currentView === item.name ? "var(--color-green)" : "transparent",
                        color: currentView === item.name ? "var(--color-white)" : "var(--color-white)",
                        fontFamily: "var(--font-tinos)",
                        border: currentView === item.name ? "none" : "1px solid var(--color-dark-gray)"
                    }}
                >
                    {item.icon} {item.name}
                </button>
            ))}
        </div>
    );
}

// Services Table
function ServicesTable({ services, onEdit, onDelete }) {
    return (
        <div className="overflow-auto rounded-lg shadow bg-white p-4">
            <table className="min-w-full divide-y divide-gray-200">
                <thead className="bg-gray-50">
                    <tr>
                        <th className="px-4 py-2 text-left font-medium text-gray-700">ID</th>
                        <th className="px-4 py-2 text-left font-medium text-gray-700">Nom</th>
                        <th className="px-4 py-2 text-left font-medium text-gray-700">Lignes</th>
                        <th className="px-4 py-2 text-left font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody className="divide-y divide-gray-100">
                    {services.map((service, idx) => (
                        <tr key={service.id} className={idx % 2 === 0 ? 'bg-gray-50' : 'bg-white'}>
                            <td className="px-4 py-2">{service.id}</td>
                            <td className="px-4 py-2 font-bold">{service.name}</td>
                            <td className="px-4 py-2 text-sm text-gray-600">
                                {[service.line1, service.line2, service.line3, service.line4, service.line5]
                                    .filter(Boolean)
                                    .join(' • ')}
                            </td>
                            <td className="px-4 py-2 flex gap-2">
                                <button
                                    onClick={() => onEdit(service)}
                                    className="px-3 py-1 bg-yellow-400 rounded hover:bg-yellow-500"
                                >
                                    ✏️ Modifier
                                </button>
                                <button
                                    onClick={() => onDelete(service.id)}
                                    className="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                >
                                    🗑️ Supprimer
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}

// Blog Table
function BlogTable({ articles, onEdit, onDelete }) {
    const [filtreCategorie, setFiltreCategorie] = useState('Tous');
    const [rechercheTexte, setRechercheTexte] = useState('');
    const [articlesFiltres, setArticlesFiltres] = useState(articles);
    const [categories, setCategories] = useState(['Tous']);

    React.useEffect(() => {
        // Extraire toutes les catégories uniques
        const uniqueCategories = ['Tous', ...new Set(articles.map(a => a.categorie))];
        setCategories(uniqueCategories);
    }, [articles]);

    React.useEffect(() => {
        let filtered = articles;

        // Filtrer par catégorie
        if (filtreCategorie !== 'Tous') {
            filtered = filtered.filter(a => a.categorie === filtreCategorie);
        }

        // Filtrer par recherche texte (titre, résumé, auteur, sous-catégorie)
        if (rechercheTexte.trim()) {
            const searchLower = rechercheTexte.toLowerCase();
            filtered = filtered.filter(a =>
                a.titre.toLowerCase().includes(searchLower) ||
                (a.resume && a.resume.toLowerCase().includes(searchLower)) ||
                (a.auteur && a.auteur.toLowerCase().includes(searchLower)) ||
                (a.sous_categorie && a.sous_categorie.toLowerCase().includes(searchLower))
            );
        }

        setArticlesFiltres(filtered);
    }, [filtreCategorie, rechercheTexte, articles]);

    const formatDate = (dateStr) => {
        const date = new Date(dateStr);
        return date.toLocaleDateString('fr-FR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    };

    return (
        <div className="space-y-4">
            {/* Barre de recherche */}
            <div className="flex gap-3 items-center">
                <div className="flex-1">
                    <input
                        type="text"
                        value={rechercheTexte}
                        onChange={(e) => setRechercheTexte(e.target.value)}
                        placeholder="🔍 Rechercher par titre, résumé, auteur ou sous-catégorie..."
                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                        style={{ fontFamily: "var(--font-tinos)" }}
                    />
                </div>
                {rechercheTexte && (
                    <button
                        onClick={() => setRechercheTexte('')}
                        className="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                    >
                        ✕ Effacer
                    </button>
                )}
            </div>

            {/* Filtres par catégorie */}
            <div>
                <p className="text-sm text-gray-600 mb-2" style={{ fontFamily: "var(--font-tinos)" }}>
                    Filtrer par catégorie :
                </p>
                <div className="flex gap-2 flex-wrap">
                    {categories.map(cat => (
                        <button
                            key={cat}
                            onClick={() => setFiltreCategorie(cat)}
                            className={`px-4 py-2 rounded transition ${
                                filtreCategorie === cat
                                    ? 'bg-green-500 text-white shadow-md'
                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                            }`}
                            style={{
                                backgroundColor: filtreCategorie === cat ? 'var(--color-green)' : undefined,
                                fontFamily: "var(--font-tinos)"
                            }}
                        >
                            {cat} ({articles.filter(a => cat === 'Tous' || a.categorie === cat).length})
                        </button>
                    ))}
                </div>
            </div>

            {/* Résultats */}
            <div className="flex justify-between items-center">
                <p className="text-sm text-gray-600" style={{ fontFamily: "var(--font-tinos)" }}>
                    {articlesFiltres.length} article{articlesFiltres.length > 1 ? 's' : ''} trouvé{articlesFiltres.length > 1 ? 's' : ''}
                </p>
            </div>

            <div className="overflow-auto rounded-lg shadow bg-white p-4">
                <table className="min-w-full divide-y divide-gray-200">
                <thead className="bg-gray-50">
                    <tr>
                        <th className="px-4 py-2 text-left font-medium text-gray-700">Image</th>
                        <th className="px-4 py-2 text-left font-medium text-gray-700">Titre</th>
                        <th className="px-4 py-2 text-left font-medium text-gray-700">Catégorie</th>
                        <th className="px-4 py-2 text-left font-medium text-gray-700">Date</th>
                        <th className="px-4 py-2 text-left font-medium text-gray-700">Statut</th>
                        <th className="px-4 py-2 text-left font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody className="divide-y divide-gray-100">
                    {articlesFiltres.map((article, idx) => (
                        <tr key={article.id} className={idx % 2 === 0 ? 'bg-gray-50' : 'bg-white'}>
                            <td className="px-4 py-2">
                                {article.image && (
                                    <img src={BASE_URL + article.image.replace(/^\//, '')} alt={article.titre} className="h-12 w-12 object-cover rounded" />
                                )}
                            </td>
                            <td className="px-4 py-2 font-bold">{article.titre}</td>
                            <td className="px-4 py-2">
                                <div className="flex flex-col gap-1">
                                    <span className="px-2 py-1 rounded-full text-xs" style={{backgroundColor: 'var(--color-green)', color: 'white'}}>
                                        {article.categorie}
                                    </span>
                                    {article.sous_categorie && (
                                        <span className="px-2 py-1 rounded-full text-xs bg-gray-200 text-gray-700">
                                            {article.sous_categorie}
                                        </span>
                                    )}
                                </div>
                            </td>
                            <td className="px-4 py-2 text-sm text-gray-600">{formatDate(article.date_publication)}</td>
                            <td className="px-4 py-2">
                                <span className={`px-2 py-1 rounded-full text-xs ${article.publie ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-800'}`}>
                                    {article.publie ? '✓ Publié' : '✗ Brouillon'}
                                </span>
                            </td>
                            <td className="px-4 py-2 flex gap-2">
                                <button
                                    onClick={() => onEdit(article)}
                                    className="px-3 py-1 bg-yellow-400 rounded hover:bg-yellow-500"
                                >
                                    ✏️ Modifier
                                </button>
                                <button
                                    onClick={() => onDelete(article.id)}
                                    className="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                >
                                    🗑️ Supprimer
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
            </div>
        </div>
    );
}

// Portfolio Grid
function PortfolioGrid({ projets, onEdit, onDelete }) {
    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {projets.map(p => (
                <div key={p.id} className="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col hover:shadow-2xl transition">
                    <div className="h-48 w-full flex items-center justify-center" style={{ background: '#f3f4f6' }}>
                        <img src={BASE_URL + p.image.replace(/^\//, '')} alt={p.nom} className="max-h-full max-w-full object-contain p-4"/>
                    </div>
                    <div className="p-4 flex flex-col flex-1">
                        <h3 className="font-bold text-lg mb-1">{p.nom}</h3>
                        <p className="text-sm text-gray-500 mb-2">{p.annee} • {p.type}</p>
                        <p className="text-gray-700 text-sm flex-1 mb-3">{p.description_courte}</p>
                        {p.lien && (
                            <a
                                href={p.lien}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="text-blue-500 hover:underline mb-3 text-sm"
                            >
                                🔗 Voir le projet
                            </a>
                        )}
                        <div className="flex justify-end gap-2">
                            <button
                                onClick={() => onEdit(p)}
                                className="px-3 py-1 bg-yellow-400 rounded hover:bg-yellow-500"
                            >
                                ✏️
                            </button>
                            <button
                                onClick={() => onDelete(p.id)}
                                className="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                            >
                                🗑️
                            </button>
                        </div>
                    </div>
                </div>
            ))}
        </div>
    );
}

// Modal Service
function ServiceModal({ visible, onClose, onSubmit, data }) {
    const [formData, setFormData] = useState(data || {});

    React.useEffect(() => {
        setFormData(data || {});
    }, [data]);

    if (!visible) return null;

    const handleChange = e => setFormData({ ...formData, [e.target.name]: e.target.value });

    const handleSubmit = e => {
        e.preventDefault();
        onSubmit(formData);
    };

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div className="bg-white p-6 rounded-lg w-96 max-h-[90vh] overflow-y-auto">
                <h2 className="text-xl font-bold mb-4">
                    {data ? "✏️ Modifier" : "➕ Ajouter"} Service
                </h2>
                <form onSubmit={handleSubmit} className="space-y-3">
                    <input
                        type="text"
                        name="name"
                        value={formData.name || ''}
                        onChange={handleChange}
                        placeholder="Nom du service"
                        className="w-full border p-2 rounded"
                        required
                    />
                    <input
                        type="text"
                        name="line1"
                        value={formData.line1 || ''}
                        onChange={handleChange}
                        placeholder="Ligne 1"
                        className="w-full border p-2 rounded"
                    />
                    <input
                        type="text"
                        name="line2"
                        value={formData.line2 || ''}
                        onChange={handleChange}
                        placeholder="Ligne 2"
                        className="w-full border p-2 rounded"
                    />
                    <input
                        type="text"
                        name="line3"
                        value={formData.line3 || ''}
                        onChange={handleChange}
                        placeholder="Ligne 3"
                        className="w-full border p-2 rounded"
                    />
                    <input
                        type="text"
                        name="line4"
                        value={formData.line4 || ''}
                        onChange={handleChange}
                        placeholder="Ligne 4"
                        className="w-full border p-2 rounded"
                    />
                    <input
                        type="text"
                        name="line5"
                        value={formData.line5 || ''}
                        onChange={handleChange}
                        placeholder="Ligne 5"
                        className="w-full border p-2 rounded"
                    />
                    <div className="flex justify-end gap-2 mt-4">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                        >
                            Annuler
                        </button>
                        <button
                            type="submit"
                            className="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                        >
                            {data ? "Modifier" : "Ajouter"}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}

// Modal Projet
function ProjetModal({ visible, onClose, onSubmit, data }) {
    const [formData, setFormData] = useState(data || {});
    const [newGalleryFiles, setNewGalleryFiles] = useState([]);
    const [newGalleryPreviews, setNewGalleryPreviews] = useState([]);
    const [removedImages, setRemovedImages] = useState([]);

    React.useEffect(() => {
        setFormData(data || {});
        setNewGalleryFiles([]);
        setNewGalleryPreviews([]);
        setRemovedImages([]);
    }, [data]);

    if (!visible) return null;

    const handleChange = e => setFormData({ ...formData, [e.target.name]: e.target.value });

    const parsedImages = Array.isArray(formData.images) ? formData.images : (() => { try { return JSON.parse(formData.images || '[]'); } catch { return []; } })();
    const existingGallery = parsedImages.filter(img => !removedImages.includes(img));

    const handleGalleryAdd = (e) => {
        const files = Array.from(e.target.files);
        setNewGalleryFiles(prev => [...prev, ...files]);
        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = () => setNewGalleryPreviews(prev => [...prev, reader.result]);
            reader.readAsDataURL(file);
        });
        e.target.value = '';
    };

    const removeExistingImage = (imgPath) => {
        setRemovedImages(prev => [...prev, imgPath]);
    };

    const removeNewImage = (index) => {
        setNewGalleryFiles(prev => prev.filter((_, i) => i !== index));
        setNewGalleryPreviews(prev => prev.filter((_, i) => i !== index));
    };

    const handleSubmit = e => {
        e.preventDefault();
        const submitData = { ...formData };
        if (removedImages.length > 0) submitData.remove_images = removedImages;
        if (newGalleryFiles.length > 0) submitData._galleryFiles = newGalleryFiles;
        submitData.images = existingGallery;
        onSubmit(submitData);
    };

    const BASE_IMG = window.BASE_URL || '/Alex2/';

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div className="bg-white p-6 rounded-lg w-[520px] max-h-[90vh] overflow-y-auto">
                <h2 className="text-xl font-bold mb-4">
                    {data ? "✏️ Modifier" : "➕ Ajouter"} Projet Portfolio
                </h2>
                <form onSubmit={handleSubmit} className="space-y-3">
                    <input
                        type="text"
                        name="nom"
                        value={formData.nom || ''}
                        onChange={handleChange}
                        placeholder="Nom du projet"
                        className="w-full border p-2 rounded"
                        required
                    />
                    <div className="grid grid-cols-2 gap-3">
                        <input
                            type="number"
                            name="annee"
                            value={formData.annee || ''}
                            onChange={handleChange}
                            placeholder="Année"
                            className="w-full border p-2 rounded"
                            required
                        />
                        <input
                            type="text"
                            name="type"
                            value={formData.type || ''}
                            onChange={handleChange}
                            placeholder="Type (PHP, React...)"
                            className="w-full border p-2 rounded"
                        />
                    </div>

                    {/* Image principale */}
                    <div>
                        <label className="block text-sm font-semibold text-gray-700 mb-1">Image principale (logo/thumbnail)</label>
                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            onChange={e => setFormData({ ...formData, image: e.target.files[0] })}
                            className="w-full border p-2 rounded"
                        />
                        {formData.image && typeof formData.image === 'string' && (
                            <img src={BASE_IMG + formData.image.replace(/^\//, '')} alt="Actuelle" className="mt-2 h-16 rounded object-cover" />
                        )}
                    </div>

                    {/* Galerie mockups */}
                    <div>
                        <label className="block text-sm font-semibold text-gray-700 mb-1">
                            Captures d'écran / Mockups (PC, mobile...)
                        </label>
                        <input
                            type="file"
                            accept="image/*"
                            multiple
                            onChange={handleGalleryAdd}
                            className="w-full border p-2 rounded"
                        />
                        <div className="grid grid-cols-4 gap-2 mt-2">
                            {existingGallery.map((img, i) => (
                                <div key={'ex-'+i} className="relative group">
                                    <img src={BASE_IMG + img.replace(/^\//, '')} alt="" className="w-full h-20 object-cover rounded" />
                                    <button
                                        type="button"
                                        onClick={() => removeExistingImage(img)}
                                        className="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                    >×</button>
                                </div>
                            ))}
                            {newGalleryPreviews.map((src, i) => (
                                <div key={'new-'+i} className="relative group">
                                    <img src={src} alt="" className="w-full h-20 object-cover rounded border-2 border-green-400" />
                                    <button
                                        type="button"
                                        onClick={() => removeNewImage(i)}
                                        className="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                    >×</button>
                                </div>
                            ))}
                        </div>
                    </div>

                    <textarea
                        name="description_courte"
                        value={formData.description_courte || ''}
                        onChange={handleChange}
                        placeholder="Description courte"
                        className="w-full border p-2 rounded"
                        rows="3"
                    />
                    <textarea
                        name="description_detaillee"
                        value={formData.description_detaillee || ''}
                        onChange={handleChange}
                        placeholder="Description détaillée"
                        className="w-full border p-2 rounded"
                        rows="5"
                    />
                    <input
                        type="url"
                        name="lien"
                        value={formData.lien || ''}
                        onChange={handleChange}
                        placeholder="Lien vers le projet"
                        className="w-full border p-2 rounded"
                    />
                    <div className="flex justify-end gap-2 mt-4">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                        >
                            Annuler
                        </button>
                        <button
                            type="submit"
                            className="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                        >
                            {data ? "Modifier" : "Ajouter"}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}

// Modal Blog
function BlogModal({ visible, onClose, onSubmit, data }) {
    const [formData, setFormData] = useState(data || {});
    const [showSuggestions, setShowSuggestions] = useState(false);
    const [showSousSuggestions, setShowSousSuggestions] = useState(false);
    const [allCategories, setAllCategories] = useState(['Tutoriels', 'Actualités Tech']);
    const [allSousCategories, setAllSousCategories] = useState([]);

    React.useEffect(() => {
        // Si c'est un nouvel article (pas de data), initialiser avec des valeurs par défaut
        const initialData = data || { categorie: '', auteur: 'Alex²', publie: 1 };
        setFormData(initialData);

        // Récupérer toutes les catégories et sous-catégories existantes
        fetch("<?= BASE_URL ?>api/blog.php")
            .then(res => res.json())
            .then(articles => {
                const categories = [...new Set(articles.map(a => a.categorie))];
                setAllCategories(categories.length > 0 ? categories : ['Tutoriels', 'Actualités Tech']);

                const sousCategories = [...new Set(articles.map(a => a.sous_categorie).filter(Boolean))];
                setAllSousCategories(sousCategories);
            })
            .catch(() => setAllCategories(['Tutoriels', 'Actualités Tech']));
    }, [data]);

    if (!visible) return null;

    const handleChange = e => setFormData({ ...formData, [e.target.name]: e.target.value });

    const handleCategorieChange = e => {
        setFormData({ ...formData, categorie: e.target.value });
        setShowSuggestions(e.target.value.length > 0);
    };

    const handleSousCategorieChange = e => {
        setFormData({ ...formData, sous_categorie: e.target.value });
        setShowSousSuggestions(e.target.value.length > 0);
    };

    const selectCategory = (cat) => {
        setFormData({ ...formData, categorie: cat });
        setShowSuggestions(false);
    };

    const selectSousCategory = (sousCat) => {
        setFormData({ ...formData, sous_categorie: sousCat });
        setShowSousSuggestions(false);
    };

    const filteredCategories = allCategories.filter(cat =>
        cat.toLowerCase().includes((formData.categorie || '').toLowerCase())
    );

    const filteredSousCategories = allSousCategories.filter(sousCat =>
        sousCat.toLowerCase().includes((formData.sous_categorie || '').toLowerCase())
    );

    const handleSubmit = e => {
        e.preventDefault();

        // Valider que la catégorie n'est pas vide
        if (!formData.categorie || formData.categorie.trim() === '') {
            alert('Veuillez saisir une catégorie principale');
            return;
        }

        console.log('Données envoyées:', formData);
        onSubmit(formData);
    };

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div className="bg-white p-6 rounded-lg w-[600px] max-h-[90vh] overflow-y-auto">
                <h2 className="text-xl font-bold mb-4">
                    {data ? "✏️ Modifier" : "➕ Ajouter"} Article de Blog
                </h2>
                <form onSubmit={handleSubmit} className="space-y-3">
                    <input
                        type="text"
                        name="titre"
                        value={formData.titre || ''}
                        onChange={handleChange}
                        placeholder="Titre de l'article"
                        className="w-full border p-2 rounded"
                        required
                    />
                    <div className="grid grid-cols-2 gap-3">
                        <div className="relative">
                            <label className="block text-sm font-medium text-gray-700 mb-1">Catégorie principale</label>
                            <input
                                type="text"
                                name="categorie"
                                value={formData.categorie || ''}
                                onChange={handleCategorieChange}
                                onFocus={() => setShowSuggestions(true)}
                                onBlur={() => setTimeout(() => setShowSuggestions(false), 200)}
                                placeholder="Ex: Tutoriels, Actualités Tech"
                                className="w-full border p-2 rounded"
                                required
                            />
                            {showSuggestions && filteredCategories.length > 0 && (
                                <div className="absolute z-10 w-full bg-white border border-gray-300 rounded-b shadow-lg max-h-40 overflow-y-auto">
                                    {filteredCategories.map((cat, i) => (
                                        <div
                                            key={i}
                                            onClick={() => selectCategory(cat)}
                                            className="px-3 py-2 hover:bg-gray-100 cursor-pointer"
                                        >
                                            {cat}
                                        </div>
                                    ))}
                                </div>
                            )}
                        </div>
                        <div className="relative">
                            <label className="block text-sm font-medium text-gray-700 mb-1">Sous-catégorie (optionnel)</label>
                            <input
                                type="text"
                                name="sous_categorie"
                                value={formData.sous_categorie || ''}
                                onChange={handleSousCategorieChange}
                                onFocus={() => setShowSousSuggestions(true)}
                                onBlur={() => setTimeout(() => setShowSousSuggestions(false), 200)}
                                placeholder="Ex: PHP, JavaScript, React"
                                className="w-full border p-2 rounded"
                            />
                            {showSousSuggestions && filteredSousCategories.length > 0 && (
                                <div className="absolute z-10 w-full bg-white border border-gray-300 rounded-b shadow-lg max-h-40 overflow-y-auto">
                                    {filteredSousCategories.map((sousCat, i) => (
                                        <div
                                            key={i}
                                            onClick={() => selectSousCategory(sousCat)}
                                            className="px-3 py-2 hover:bg-gray-100 cursor-pointer"
                                        >
                                            {sousCat}
                                        </div>
                                    ))}
                                </div>
                            )}
                        </div>
                    </div>
                    <p className="text-xs text-gray-500">Tapez une catégorie ou créez-en une nouvelle. Ajoutez une sous-catégorie pour un tri plus précis.</p>
                    <input
                        type="file"
                        name="image"
                        onChange={e => setFormData({ ...formData, image: e.target.files[0] })}
                        className="w-full border p-2 rounded"
                    />
                    {formData.image && typeof formData.image === 'string' && (
                        <img src={BASE_URL + formData.image.replace(/^\//, '')} alt="Aperçu" className="h-24 w-24 object-cover rounded" />
                    )}
                    <textarea
                        name="resume"
                        value={formData.resume || ''}
                        onChange={handleChange}
                        placeholder="Résumé (affiché sur la page blog)"
                        className="w-full border p-2 rounded"
                        rows="3"
                    />
                    <textarea
                        name="contenu"
                        value={formData.contenu || ''}
                        onChange={handleChange}
                        placeholder="Contenu complet de l'article (HTML supporté)"
                        className="w-full border p-2 rounded"
                        rows="8"
                    />
                    <input
                        type="text"
                        name="auteur"
                        value={formData.auteur || 'Alex²'}
                        onChange={handleChange}
                        placeholder="Auteur"
                        className="w-full border p-2 rounded"
                    />
                    <label className="flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="publie"
                            checked={formData.publie !== 0 && formData.publie !== false}
                            onChange={e => setFormData({ ...formData, publie: e.target.checked ? 1 : 0 })}
                            className="w-4 h-4"
                        />
                        <span>Publier l'article</span>
                    </label>
                    <div className="flex justify-end gap-2 mt-4">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                        >
                            Annuler
                        </button>
                        <button
                            type="submit"
                            className="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                        >
                            {data ? "Modifier" : "Ajouter"}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}

// Temoignages Table
function TemoignagesTable({ temoignages, onToggle, onDelete }) {
    const formatDate = (dateStr) => {
        const date = new Date(dateStr);
        return date.toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' });
    };

    const Stars = ({ count }) => (
        <div className="flex gap-0.5">
            {[...Array(5)].map((_, i) => (
                <svg key={i} className={`w-4 h-4 ${i < count ? 'text-amber-400' : 'text-gray-300'}`} fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            ))}
        </div>
    );

    const pending = temoignages.filter(t => !t.actif);
    const active = temoignages.filter(t => t.actif);

    return (
        <div className="space-y-6">
            {pending.length > 0 && (
                <div>
                    <h3 className="text-xl font-black mb-3 flex items-center gap-2" style={{ fontFamily: "var(--font-bounded)" }}>
                        <span className="w-3 h-3 rounded-full bg-amber-400 animate-pulse" />
                        En attente de validation ({pending.length})
                    </h3>
                    <div className="space-y-3">
                        {pending.map(t => (
                            <div key={t.id} className="bg-amber-50 border-2 border-amber-200 rounded-xl p-5">
                                <div className="flex justify-between items-start mb-2">
                                    <div>
                                        <span className="font-black" style={{ fontFamily: "var(--font-bounded)" }}>{t.nom}</span>
                                        {t.entreprise && <span className="text-gray-500 ml-2">— {t.entreprise}</span>}
                                    </div>
                                    <span className="text-xs text-gray-500">{formatDate(t.date_creation)}</span>
                                </div>
                                <p className="text-gray-700 mb-3" style={{ fontFamily: "var(--font-tinos)" }}>{t.texte}</p>
                                <div className="flex items-center justify-between">
                                    <Stars count={parseInt(t.note) || 5} />
                                    <div className="flex gap-2">
                                        <button onClick={() => onToggle(t.id, 1)} className="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition text-sm font-semibold">
                                            Approuver
                                        </button>
                                        <button onClick={() => onDelete(t.id)} className="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm font-semibold">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            )}

            <div>
                <h3 className="text-xl font-black mb-3" style={{ fontFamily: "var(--font-bounded)" }}>
                    Avis publiés ({active.length})
                </h3>
                <div className="overflow-auto rounded-lg shadow bg-white p-4">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="px-4 py-2 text-left font-medium text-gray-700">Nom</th>
                                <th className="px-4 py-2 text-left font-medium text-gray-700">Entreprise</th>
                                <th className="px-4 py-2 text-left font-medium text-gray-700">Avis</th>
                                <th className="px-4 py-2 text-left font-medium text-gray-700">Note</th>
                                <th className="px-4 py-2 text-left font-medium text-gray-700">Date</th>
                                <th className="px-4 py-2 text-left font-medium text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-100">
                            {active.map((t, idx) => (
                                <tr key={t.id} className={idx % 2 === 0 ? 'bg-gray-50' : 'bg-white'}>
                                    <td className="px-4 py-2 font-bold">{t.nom}</td>
                                    <td className="px-4 py-2 text-sm text-gray-600">{t.entreprise || '—'}</td>
                                    <td className="px-4 py-2 text-sm text-gray-700 max-w-xs truncate">{t.texte}</td>
                                    <td className="px-4 py-2"><Stars count={parseInt(t.note) || 5} /></td>
                                    <td className="px-4 py-2 text-sm text-gray-500">{formatDate(t.date_creation)}</td>
                                    <td className="px-4 py-2 flex gap-2">
                                        <button onClick={() => onToggle(t.id, 0)} className="px-3 py-1 bg-yellow-400 rounded hover:bg-yellow-500 text-sm">
                                            Masquer
                                        </button>
                                        <button onClick={() => onDelete(t.id)} className="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                            Supprimer
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

// Dashboard Principal
function Dashboard() {
    const [view, setView] = useState("Portfolio");
    const [data, setData] = useState({
        projets: phpData.projets || [],
        services: phpData.services || [],
        blog: phpData.blog || [],
        temoignages: phpData.temoignages || []
    });
    const [modalVisible, setModalVisible] = useState(false);
    const [editData, setEditData] = useState(null);

    const buildApiUrl = (type, id = null) => {
        const map = { "Portfolio": "projets", "Services": "services", "Blog": "blog", "Avis": "temoignages" };
        const key = map[type];
        const baseUrl = "<?= BASE_URL ?>";
        if (type === "Avis" && !id) return `${baseUrl}api/${key}.php?all=1`;
        return id ? `${baseUrl}api/${key}.php?id=${id}` : `${baseUrl}api/${key}.php`;
    };

    const refreshData = async (type) => {
        try {
            const res = await fetch(buildApiUrl(type));
            const json = await res.json();
            const key = type === "Portfolio" ? "projets" : type === "Services" ? "services" : type === "Avis" ? "temoignages" : "blog";
            setData(prev => ({ ...prev, [key]: json }));
        } catch (err) {
            console.error("Erreur refresh:", err);
        }
    };

    const handleToggleAvis = async (id, actif) => {
        try {
            await fetch(buildApiUrl("Avis"), {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id, actif })
            });
            await refreshData("Avis");
        } catch (err) {
            console.error("Erreur toggle:", err);
        }
    };

    const handleDeleteAvis = async (id) => {
        if (!confirm("Supprimer cet avis ?")) return;
        try {
            await fetch(buildApiUrl("Avis", id), { method: "DELETE" });
            await refreshData("Avis");
        } catch (err) {
            console.error("Erreur delete avis:", err);
        }
    };

    const handleAdd = () => {
        setEditData(null);
        setModalVisible(true);
    };

    const handleEdit = (item) => {
        setEditData(item);
        setModalVisible(true);
    };

    const handleDelete = async (id) => {
        if (!confirm("Confirmer la suppression ?")) return;

        try {
            const res = await fetch(buildApiUrl(view, id), {
                method: "DELETE",
                headers: { "Content-Type": "application/json" }
            });

            const json = await res.json();
            if (res.ok) {
                alert(json.message || "Supprimé !");
                await refreshData(view);
            } else {
                alert(`Erreur : ${json.message || json.error}`);
            }
        } catch (err) {
            console.error("Erreur DELETE:", err);
            alert("Erreur réseau");
        }
    };

    // Convertir un fichier en base64 (Promise)
    const fileToBase64 = (file) => new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result);
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });

    const handleSubmit = async (formData) => {
        try {
            const method = editData ? "PUT" : "POST";
            const url = editData ? buildApiUrl(view, editData.id) : buildApiUrl(view);

            // Extraire les fichiers galerie du formData
            const galleryFiles = formData._galleryFiles || [];
            delete formData._galleryFiles;

            // Portfolio ou Blog avec image
            if ((view === "Portfolio" || view === "Blog") && formData.image instanceof File) {
                if (editData) {
                    // PUT : convertir image principale + galerie en base64
                    formData.image = await fileToBase64(formData.image);
                    if (galleryFiles.length > 0) {
                        formData.new_images = await Promise.all(galleryFiles.map(f => fileToBase64(f)));
                    }
                    const res = await fetch(url, {
                        method: "PUT",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify(formData)
                    });
                    const saved = await res.json();
                    if (!res.ok) return alert(saved.error || "Erreur");
                    await refreshData(view);
                    setModalVisible(false);
                    setEditData(null);
                    return;
                } else {
                    // POST : FormData avec fichiers
                    let body = new FormData();
                    for (let key in formData) {
                        if (key === 'images' || key === 'remove_images' || key === 'new_images') continue;
                        body.append(key, formData[key]);
                    }
                    galleryFiles.forEach(f => body.append('images[]', f));
                    const res = await fetch(url, { method, body });
                    const saved = await res.json();
                    if (!res.ok) return alert(saved.error || "Erreur");
                    await refreshData(view);
                    setModalVisible(false);
                    return;
                }
            }

            // PUT sans nouvelle image principale mais avec galerie
            if (view === "Portfolio" && editData && galleryFiles.length > 0) {
                formData.new_images = await Promise.all(galleryFiles.map(f => fileToBase64(f)));
            }

            // Autres cas (Service ou Portfolio/Blog sans nouvelle image)
            const res = await fetch(url, {
                method,
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(formData)
            });

            const saved = await res.json();
            if (!res.ok) return alert(saved.error || "Erreur");

            await refreshData(view);
            setModalVisible(false);
            setEditData(null);
        } catch (err) {
            console.error("Erreur SUBMIT:", err);
            alert("Erreur réseau: " + err.message);
        }
    };

    return (
        <div className="flex flex-1 overflow-auto">
            <Sidebar setView={setView} currentView={view} />
            <div className="flex-1 p-8">
                <div className="mb-6 flex justify-between items-center">
                    <h2 className="text-4xl font-black" style={{ fontFamily: "var(--font-bounded)", color: "var(--color-black)" }}>
                        {view === "Portfolio" ? "📂 Portfolio" : view === "Services" ? "⚙️ Services" : view === "Avis" ? "⭐ Avis Clients" : "📝 Blog"}
                    </h2>
                    {view !== "Avis" && (
                        <button
                            onClick={handleAdd}
                            className="px-6 py-3 rounded-lg shadow-lg hover:opacity-80 transition"
                            style={{ backgroundColor: "var(--color-green)", color: "var(--color-white)", fontFamily: "var(--font-tinos)" }}
                        >
                            ➕ Ajouter {view === "Portfolio" ? "un projet" : view === "Services" ? "un service" : "un article"}
                        </button>
                    )}
                </div>

                {view === "Portfolio" && (
                    <PortfolioGrid
                        projets={data.projets}
                        onEdit={handleEdit}
                        onDelete={handleDelete}
                    />
                )}

                {view === "Services" && (
                    <ServicesTable
                        services={data.services}
                        onEdit={handleEdit}
                        onDelete={handleDelete}
                    />
                )}

                {view === "Blog" && (
                    <BlogTable
                        articles={data.blog}
                        onEdit={handleEdit}
                        onDelete={handleDelete}
                    />
                )}

                {view === "Avis" && (
                    <TemoignagesTable
                        temoignages={data.temoignages}
                        onToggle={handleToggleAvis}
                        onDelete={handleDeleteAvis}
                    />
                )}

                {view === "Portfolio" && (
                    <ProjetModal
                        visible={modalVisible}
                        onClose={() => setModalVisible(false)}
                        onSubmit={handleSubmit}
                        data={editData}
                    />
                )}

                {view === "Services" && (
                    <ServiceModal
                        visible={modalVisible}
                        onClose={() => setModalVisible(false)}
                        onSubmit={handleSubmit}
                        data={editData}
                    />
                )}

                {view === "Blog" && (
                    <BlogModal
                        visible={modalVisible}
                        onClose={() => setModalVisible(false)}
                        onSubmit={handleSubmit}
                        data={editData}
                    />
                )}
            </div>
        </div>
    );
}

ReactDOM.createRoot(document.getElementById('root')).render(<Dashboard />);
</script>

</body>
</html>
