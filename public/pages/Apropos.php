<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../../includes/header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>À propos | &lt;alex²/&gt;</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/Apropos.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
    <section class="py-16 px-6 md:px-20" style="background-color: var(--color-white); color: var(--color-black);" id="content">
        <!-- Titre principal -->
        <div class="text-center max-w-4xl mx-auto mb-16">
            <h1 class="text-5xl font-extrabold tracking-tight mb-6"><span style="color: var(--color-green);">&lt;alex²/&gt;</span></h1>
            <p class="text-lg text-gray-600">
            Nous concevons des sites sobres, rapides et durables. Simples à utiliser, performants par nature, éco-responsables par conviction.
            </p>
        </div>

        <!-- Mission & Valeurs -->
        <div class="max-w-5xl mx-auto space-y-12">
            <div>
            <h2 class="text-3xl font-bold mb-4 border-l-4  pl-4"style="border-color: var(--color-green);">Mission & Valeurs</h2>
            <p class="mb-4 text-gray-700"><strong>Notre mission :</strong> Créer des sites web simples, performants et responsables, pensés pour durer et conçus pour avoir un impact minimal sur l’environnement.</p>
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 list-none">
                <li class="bg-gray-50 p-4 rounded-lg shadow-sm border-l-4" style="border-color: var(--color-green);">
                <strong>Qualité :</strong> un code propre, optimisé et fiable.
                </li>
                <li class="bg-gray-50 p-4 rounded-lg shadow-sm border-l-4 "style="border-color: var(--color-green);">
                <strong>Simplicité :</strong> des sites efficaces, utiles, sans superflu.
                </li>
                <li class="bg-gray-50 p-4 rounded-lg shadow-sm border-l-4 "style="border-color: var(--color-green);">
                <strong>Responsabilité :</strong> sobriété numérique, hébergement éco responsable, optimisation des ressources.
                </li>
                <li class="bg-gray-50 p-4 rounded-lg shadow-sm border-l-4 "style="border-color: var(--color-green);">
                <strong>Accessibilité :</strong> des solutions adaptées à tous les budgets.
                </li>
            </ul>
            </div>

            <!-- Positionnement -->
            <div>
            <h2 class="text-3xl font-bold mb-4 border-l-4  pl-4" style="border-color: var(--color-green);">Positionnement</h2>
            <p class="text-gray-700 mb-2">
                Nous nous adressons à toute personne ou structure ayant besoin d’un site — personnel, professionnel ou associatif — et qui recherche :
            </p>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>Une solution claire et sans artifice</li>
                <li>Un site éco-conçu avec une faible empreinte carbone</li>
                <li>Un accompagnement humain et transparent</li>
            </ul>
            </div>

            <!-- Avantage Concurrentiel -->
            <div>
            <h2 class="text-3xl font-bold mb-4 border-l-4 pl-4" style="border-color: var(--color-green);">Notre avantage concurrentiel</h2>
            <p class="text-gray-700">
                Nous créons des sites sobres, rapides et durables, conçus pour minimiser la consommation de ressources tout en offrant une expérience utilisateur fluide. Notre approche allie performance et responsabilité écologique pour garantir une présence web efficace et pérenne.
            </p>
            </div>

            <!-- Ton & Personnalité -->
            <div>
            <h2 class="text-3xl font-bold mb-4 border-l-4 pl-4"style="border-color: var(--color-green);">Personnalité & Ton</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>Professionnel, sans jargon inutile</li>
                <li>Sincère et rigoureux, mais accessible</li>
                <li>Sobres comme nos sites : pas d’effets tape-à-l’œil, mais une vraie solidité technique</li>
                <li>Engagés, sans greenwashing : chaque décision technique est pensée pour réduire l’impact environnemental</li>
            </ul>
            </div>
        </div>
        <section x-data x-init="() => {
            const cards = document.querySelectorAll('.founder-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });

            cards.forEach(card => observer.observe(card));
        }" class="mt-24 max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-16">Les fondateurs</h2>

            <div class="grid md:grid-cols-2 gap-12 place-items-center">
                <!-- Alexandre -->
                <div class="founder-card opacity-0 transform translate-y-10 transition-all duration-700 bg-white border border-gray-200 rounded-2xl shadow-xl p-10 w-full max-w-2xl hover:shadow-2xl text-center">
                    <img src="<?= BASE_URL ?>/asset/img/alexandre.webp" alt="Alexandre" class="w-36 h-36 rounded-full object-cover border-4 mb-6 shadow mx-auto"style="border-color: var(--color-green);">
                    <h3 class="text-3xl font-semibold text-blue-600 mb-4"style="color: var(--color-green);">Alexandre</h3>
                    <p class="text-gray-700 text-base mb-6 max-w-xl mx-auto">
                        Développeur front-end, Alexandre conçoit des interfaces sobres, accessibles et efficaces. Il est à l’origine de l'identité visuelle et de l’expérience utilisateur de <strong style="color: var(--color-green);">&lt;alex²/&gt;</strong>.
                    </p>
                    <div class="space-y-4 text-left text-sm text-gray-600 max-w-md mx-auto">
                        <div>
                            <strong>Parcours :</strong>
                            <ul class="list-disc list-inside ml-2 mt-1">
                                <li>Bac STI2D</li>
                                <li>BUT MMI</li>
                                <li>Projets web sur mesure</li>
                            </ul>
                        </div>
                        <div>
                            <strong>Valeurs :</strong>
                            <ul class="list-disc list-inside ml-2 mt-1">
                                <li>Créativité</li>
                                <li>Accessibilité</li>
                                <li>Clarté</li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex justify-center space-x-4 mt-6">
                        <a href="https://www.linkedin.com/in/alexandre-bouvy-7809a51b7/" target="_blank" class="text-gray-500 hover:text-blue-600 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 8a6 6 0 016 6v6h-4v-6a2 2 0 00-4 0v6h-4v-10h4v1.5A4 4 0 0116 8zM2 9h4v12H2zM4 3a2 2 0 110 4 2 2 0 010-4z"/>
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/le_roi_b_tv/" target="_blank" class="text-gray-500 hover:text-pink-500 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7.75 2C5.678 2 4 3.678 4 5.75v12.5C4 20.322 5.678 22 7.75 22h8.5C18.322 22 20 20.322 20 18.25V5.75C20 3.678 18.322 2 16.25 2h-8.5zM12 17.75A5.75 5.75 0 1117.75 12 5.757 5.757 0 0112 17.75zm0-9.5A3.75 3.75 0 1015.75 12 3.754 3.754 0 0012 8.25zM18 6.5a1 1 0 11-1-1 1 1 0 011 1z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Alexis -->
                <div class="founder-card opacity-0 transform translate-y-10 transition-all duration-700 bg-white border border-gray-200 rounded-2xl shadow-xl p-10 w-full max-w-2xl hover:shadow-2xl text-center">
                    <img src="<?= BASE_URL ?>/asset/img/alexis.webp" alt="Alexis" class="w-36 h-36 rounded-full object-cover border-4 mb-6 shadow mx-auto" style="border-color: var(--color-green);">
                    <h3 class="text-3xl font-semibold mb-4"style="color: var(--color-green);">Alexis</h3>
                    <p class="text-gray-700 text-base mb-6 max-w-xl mx-auto">
                        Développeur back-end, Alexis s’occupe de l’architecture, des bases de données et de la performance. Il veille à la stabilité et à la sobriété technique de <strong style="color: var(--color-green);">&lt;alex²/&gt;</strong>.
                    </p>
                    <div class="space-y-4 text-left text-sm text-gray-600 max-w-md mx-auto">
                        <div>
                            <strong>Parcours :</strong>
                            <ul class="list-disc list-inside ml-2 mt-1">
                                <li>Bac STI2D</li>
                                <li>BUT MMI</li>
                                <li>Projets web sur mesure</li>
                            </ul>
                        </div>
                        <div>
                            <strong>Valeurs :</strong>
                            <ul class="list-disc list-inside ml-2 mt-1">
                                <li>Fiabilité</li>
                                <li>Efficacité</li>
                                <li>Transparence</li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex justify-center space-x-4 mt-6">
                        <a href="https://www.linkedin.com/in/alexis-rodrigues-dos-reis-51b008257/" target="_blank" class="text-gray-500 hover:text-blue-600 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 8a6 6 0 016 6v6h-4v-6a2 2 0 00-4 0v6h-4v-10h4v1.5A4 4 0 0116 8zM2 9h4v12H2zM4 3a2 2 0 110 4 2 2 0 010-4z"/>
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/alexisrdr_off/" target="_blank" class="text-gray-500 hover:text-pink-500 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7.75 2C5.678 2 4 3.678 4 5.75v12.5C4 20.322 5.678 22 7.75 22h8.5C18.322 22 20 20.322 20 18.25V5.75C20 3.678 18.322 2 16.25 2h-8.5zM12 17.75A5.75 5.75 0 1117.75 12 5.757 5.757 0 0112 17.75zm0-9.5A3.75 3.75 0 1015.75 12 3.754 3.754 0 0012 8.25zM18 6.5a1 1 0 11-1-1 1 1 0 011 1z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <?php
include __DIR__ . '/../../includes/footer.php';
?>
</body>
</html>

