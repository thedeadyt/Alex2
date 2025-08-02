<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>À propos | &lt;alex²/&gt;</title>
    <link rel="icon" href="<?= BASE_URL ?>/Alex2logo.png" type="image/x-icon">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/Apropos.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- React & ReactDOM + Babel -->
    <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
</head>
<body style="background-color: var(--color-white); color: var(--color-black);">
<?php include __DIR__ . '/../../includes/header.php'; ?>

<section class="py-16 px-6 md:px-20" id="content">
    <div class="text-center max-w-4xl mx-auto mb-16">
        <h1 class="text-5xl font-extrabold tracking-tight mb-6">
            <span style="color: var(--color-green); font-family: var(--font-bounded)">&lt;alex²/&gt;</span>
        </h1>
        <p class="text-lg" style="font-family: var(--font-tinos)">
            Nous concevons des sites sobres, rapides et durables. Simples à utiliser, performants par nature, éco-responsables par conviction.
        </p>
    </div>

    <div class="max-w-5xl mx-auto space-y-12">
        <div>
            <h2 class="text-3xl font-bold mb-4 border-l-4  pl-4" style="border-color: var(--color-green); font-family: var(--font-bounded)">Mission & Valeurs</h2>
            <p class="mb-4"><strong>Notre mission :</strong> Créer des sites web simples, performants et responsables, pensés pour durer et conçus pour avoir un impact minimal sur l’environnement.</p>
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 list-none">
                <li class="p-4 rounded-lg shadow-sm border-l-4" style="background-color: var(--color-white); border-color: var(--color-green); font-family: var(--font-tinos)">
                    <strong>Qualité :</strong> un code propre, optimisé et fiable.
                </li>
                <li class="p-4 rounded-lg shadow-sm border-l-4" style="background-color: var(--color-white); border-color: var(--color-green); font-family: var(--font-tinos)">
                    <strong>Simplicité :</strong> des sites efficaces, utiles, sans superflu.
                </li>
                <li class="p-4 rounded-lg shadow-sm border-l-4" style="background-color: var(--color-white); border-color: var(--color-green); font-family: var(--font-tinos)">
                    <strong>Responsabilité :</strong> sobriété numérique, hébergement éco responsable, optimisation des ressources.
                </li>
                <li class="p-4 rounded-lg shadow-sm border-l-4" style="background-color: var(--color-white); border-color: var(--color-green); font-family: var(--font-tinos)">
                    <strong>Accessibilité :</strong> des solutions adaptées à tous les budgets.
                </li>
            </ul>
        </div>

        <div>
            <h2 class="text-3xl font-bold mb-4 border-l-4  pl-4" style="border-color: var(--color-green); font-family: var(--font-bounded)">Positionnement</h2>
            <p class="mb-2" style="font-family: var(--font-tinos)">
                Nous nous adressons à toute personne ou structure ayant besoin d’un site — personnel, professionnel ou associatif — et qui recherche :
            </p>
            <ul class="list-disc list-inside space-y-1">
                <li>Une solution claire et sans artifice</li>
                <li>Un site éco-conçu avec une faible empreinte carbone</li>
                <li>Un accompagnement humain et transparent</li>
            </ul>
        </div>

        <div>
            <h2 class="text-3xl font-bold mb-4 border-l-4 pl-4" style="border-color: var(--color-green); font-family: var(--font-bounded)">Notre avantage concurrentiel</h2>
            <p style="font-family: var(--font-tinos)">
                Nous créons des sites sobres, rapides et durables, conçus pour minimiser la consommation de ressources tout en offrant une expérience utilisateur fluide. Notre approche allie performance et responsabilité écologique pour garantir une présence web efficace et pérenne.
            </p>
        </div>

        <div>
            <h2 class="text-3xl font-bold mb-4 border-l-4 pl-4" style="border-color: var(--color-green); font-family: var(--font-bounded)">Personnalité & Ton</h2>
            <ul class="list-disc list-inside space-y-1" style="font-family: var(--font-tinos)">
                <li>Professionnel, sans jargon inutile</li>
                <li>Sincère et rigoureux, mais accessible</li>
                <li>Sobres comme nos sites : pas d’effets tape-à-l’œil, mais une vraie solidité technique</li>
                <li>Engagés, sans greenwashing : chaque décision technique est pensée pour réduire l’impact environnemental</li>
            </ul>
        </div>
    </div>

    <!-- REACT -->
    <section class="mt-24 max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-16" style="font-family: var(--font-bounded)">Les fondateurs</h2>
        <div id="Founders"></div>
    </section>
</section>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

<!-- Composant React -->
<script type="text/babel">
function FounderCard({ img, name, description, parcours, valeurs, linkedin, instagram }) {
    const cardRef = React.useRef(null);

    React.useEffect(() => {
        const observer = new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting && cardRef.current) {
                cardRef.current.classList.add('animate-fade-in-up');
                observer.unobserve(entry.target);
            }
        }, { threshold: 0.3 });

        if (cardRef.current) observer.observe(cardRef.current);
    }, []);

    return (
        <div
            ref={cardRef}
            className="founder-card opacity-0 transform translate-y-10 transition-all duration-700 border border-gray-200 rounded-2xl shadow-xl p-10 w-full max-w-2xl hover:shadow-2xl text-center"
            style={{ fontFamily: 'var(--font-tinos)', backgroundColor: 'var(--color-white)' }}
        >
            <img src={img} alt={name} className="w-36 h-36 rounded-full object-cover border-4 mb-6 shadow mx-auto" style={{ borderColor: 'var(--color-green)' }} />
            <h3 className="text-3xl font-semibold mb-4" style={{ color: 'var(--color-green)' }}>{name}</h3>
            <p className="text-gray-700 text-base mb-6 max-w-xl mx-auto" dangerouslySetInnerHTML={{ __html: description }}></p>
            <div className="space-y-4 text-left text-sm text-gray-600 max-w-md mx-auto">
                <div>
                    <strong>Parcours :</strong>
                    <ul className="list-disc list-inside ml-2 mt-1">
                        {parcours.map((item, i) => <li key={i}>{item}</li>)}
                    </ul>
                </div>
                <div>
                    <strong>Valeurs :</strong>
                    <ul className="list-disc list-inside ml-2 mt-1">
                        {valeurs.map((item, i) => <li key={i}>{item}</li>)}
                    </ul>
                </div>
            </div>
            <div className="flex justify-center space-x-4 mt-6">
                <a href={linkedin} target="_blank" className="text-gray-500 hover:text-blue-600 transition">
                    <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 8a6 6 0 016 6v6h-4v-6a2 2 0 00-4 0v6h-4v-10h4v1.5A4 4 0 0116 8zM2 9h4v12H2zM4 3a2 2 0 110 4 2 2 0 010-4z"/>
                    </svg>
                </a>
                <a href={instagram} target="_blank" className="text-gray-500 hover:text-pink-500 transition">
                    <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7.75 2C5.678 2 4 3.678 4 5.75v12.5C4 20.322 5.678 22 7.75 22h8.5C18.322 22 20 20.322 20 18.25V5.75C20 3.678 18.322 2 16.25 2h-8.5zM12 17.75A5.75 5.75 0 1117.75 12 5.757 5.757 0 0112 17.75zm0-9.5A3.75 3.75 0 1015.75 12 3.754 3.754 0 0012 8.25zM18 6.5a1 1 0 11-1-1 1 1 0 011 1z"/>
                    </svg>
                </a>
            </div>
        </div>
    );
}

function FoundersSection() {
    const founders = [
        {
            img: "<?= BASE_URL ?>/asset/img/alexandre.webp",
            name: "Alexandre",
            description: "Développeur front-end, Alexandre conçoit des interfaces sobres, accessibles et efficaces. Il est à l’origine de l'identité visuelle et de l’expérience utilisateur de <strong style='color: var(--color-green);'>&lt;alex²/&gt;</strong>.",
            parcours: ["Bac STI2D", "BUT MMI", "Projets web sur mesure"],
            valeurs: ["Créativité", "Accessibilité", "Clarté"],
            linkedin: "https://www.linkedin.com/in/alexandre-bouvy-7809a51b7/",
            instagram: "https://www.instagram.com/le_roi_b_tv/"
        },
        {
            img: "<?= BASE_URL ?>/asset/img/alexis.webp",
            name: "Alexis",
            description: "Développeur back-end, Alexis s’occupe de l’architecture, des bases de données et de la performance. Il veille à la stabilité et à la sobriété technique de <strong style='color: var(--color-green);'>&lt;alex²/&gt;</strong>.",
            parcours: ["Bac STI2D", "BUT MMI", "Projets web sur mesure"],
            valeurs: ["Fiabilité", "Efficacité", "Transparence"],
            linkedin: "https://www.linkedin.com/in/alexis-rodrigues-dos-reis-51b008257/",
            instagram: "https://www.instagram.com/alexisrdr_off/"
        }
    ];

    return (
        <div className="grid md:grid-cols-2 gap-12 place-items-center">
            {founders.map((f, i) => <FounderCard key={i} {...f} />)}
        </div>
    );
}

ReactDOM.createRoot(document.getElementById('Founders')).render(<FoundersSection />);
</script>

</body>
</html>
