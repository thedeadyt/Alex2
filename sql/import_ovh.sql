-- phpMyAdmin SQL Dump — Compatible OVH MySQL
-- Généré le : dim. 08 fév. 2026
-- Base de données : alex2pro_site → alexdexthedead (OVH)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Suppression des tables existantes
--
DROP TABLE IF EXISTS `temoignages`;
DROP TABLE IF EXISTS `promo_emails`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `projets`;
DROP TABLE IF EXISTS `blog`;

-- --------------------------------------------------------

--
-- Structure de la table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `categorie` varchar(100) NOT NULL,
  `sous_categorie` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `resume` text DEFAULT NULL,
  `contenu` longtext DEFAULT NULL,
  `auteur` varchar(100) DEFAULT 'Alex²',
  `date_publication` datetime DEFAULT current_timestamp(),
  `date_modification` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `publie` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `blog`
--

INSERT INTO `blog` (`id`, `titre`, `slug`, `categorie`, `sous_categorie`, `image`, `resume`, `contenu`, `auteur`, `date_publication`, `date_modification`, `publie`) VALUES
(7, 'Créer un site internet à Tarbes : Guide complet 2026', 'creer-site-internet-tarbes-guide-2026', 'Guides', 'SEO Local', NULL, 'Vous souhaitez créer un site internet à Tarbes ou Lourdes ? Découvrez notre guide complet pour choisir la bonne solution web adaptée à votre entreprise dans les Hautes-Pyrénées.', '<h2>Pourquoi créer un site internet pour votre entreprise à Tarbes ?</h2>\n<p>En 2026, avoir une présence en ligne est devenu indispensable pour toute entreprise des Hautes-Pyrénées. Que vous soyez à Tarbes, Lourdes, ou dans les environs, un site web professionnel vous permet de :</p>\n<ul>\n<li><strong>Être visible 24h/24</strong> : Vos clients peuvent vous trouver à tout moment</li>\n<li><strong>Développer votre activité localement</strong> : Attirer de nouveaux clients dans le 65</li>\n<li><strong>Crédibiliser votre entreprise</strong> : Un site moderne inspire confiance</li>\n<li><strong>Concurrencer les grandes enseignes</strong> : Même avec un petit budget</li>\n</ul>\n\n<h2>Les différents types de sites web pour les entreprises du 65</h2>\n\n<h3>1. Site vitrine simple</h3>\n<p>Idéal pour les artisans, commerçants et TPE de Tarbes-Lourdes. Un site vitrine présente vos services, vos coordonnées et permet à vos clients de vous contacter facilement. Budget accessible, mise en ligne rapide.</p>\n\n<h3>2. Site e-commerce</h3>\n<p>Pour vendre en ligne depuis les Hautes-Pyrénées. Parfait pour les commerces qui souhaitent étendre leur zone de chalandise au-delà de Tarbes et développer la vente à distance.</p>\n\n<h3>3. Site sur mesure</h3>\n<p>Pour les entreprises ayant des besoins spécifiques : réservation en ligne, espace client, intégration avec vos outils métier.</p>\n\n<h2>Comment choisir son prestataire web à Tarbes ?</h2>\n\n<p>Privilégiez un <strong>développeur web local basé à Tarbes ou Lourdes</strong> pour plusieurs raisons :</p>\n<ul>\n<li><strong>Proximité</strong> : Rencontres en présentiel possibles</li>\n<li><strong>Connaissance du territoire</strong> : Meilleur ciblage local</li>\n<li><strong>Réactivité</strong> : Fuseau horaire identique, disponibilité rapide</li>\n<li><strong>Soutien à l\'économie locale</strong> : Favoriser les entreprises du 65</li>\n</ul>\n\n<h2>Le référencement local : indispensable pour être trouvé à Tarbes</h2>\n\n<p>Un beau site ne suffit pas, il faut être visible sur Google ! Le <strong>SEO local</strong> permet d\'apparaître dans les recherches géolocalisées comme \"plombier Tarbes\" ou \"restaurant Lourdes\".</p>\n\n<h3>Les bases du SEO local :</h3>\n<ul>\n<li>Fiche Google Business Profile optimisée</li>\n<li>Mentions de Tarbes, Lourdes, Hautes-Pyrénées dans vos contenus</li>\n<li>Avis clients positifs</li>\n<li>Site rapide et mobile-friendly</li>\n<li>Contenu de qualité régulièrement mis à jour</li>\n</ul>\n\n<h2>Les avantages d\'un développeur web local</h2>\n\n<p>Faire appel à une agence basée dans les Hautes-Pyrénées présente de nombreux avantages :</p>\n<ul>\n<li><strong>Accompagnement personnalisé</strong> : Écoute de vos besoins spécifiques</li>\n<li><strong>Budget adapté</strong> : Solutions sur mesure selon votre entreprise</li>\n<li><strong>Devis transparent</strong> : Sans frais cachés</li>\n<li><strong>Paiement flexible</strong> : Échelonnement possible</li>\n</ul>\n\n<h2>Alex² : Votre agence web locale à Tarbes et Lourdes</h2>\n\n<p>Basés dans les Hautes-Pyrénées, nous accompagnons les entreprises de Tarbes, Lourdes et environs dans leur transformation digitale. Sites modernes, performants, écoresponsables et optimisés pour le référencement local.</p>\n\n<p><strong>Contactez-nous pour un devis gratuit !</strong></p>', 'Alex²', '2026-01-04 17:29:29', '2026-01-04 17:32:15', 1),
(8, 'SEO local Tarbes : Comment être premier sur Google en 2026', 'seo-local-tarbes-google-2026', 'Guides', 'Référencement', NULL, 'Découvrez les meilleures stratégies de référencement local pour dominer les résultats Google à Tarbes, Lourdes et dans les Hautes-Pyrénées. Conseils d\'experts pour booster votre visibilité locale.', '<h2>Qu\'est-ce que le SEO local et pourquoi est-il crucial à Tarbes ?</h2>\n\n<p>Le <strong>SEO local</strong> (référencement naturel local) est l\'ensemble des techniques permettant d\'apparaître en tête des résultats Google pour des recherches géolocalisées. Pour une entreprise à Tarbes ou Lourdes, c\'est LA priorité en 2026.</p>\n\n<p>Exemple concret : Quand quelqu\'un cherche \"boulangerie Tarbes\" ou \"électricien Lourdes\", Google affiche d\'abord les 3 entreprises locales les mieux référencées (le fameux \"Pack Local\").</p>\n\n<h2>Les 3 piliers du SEO local dans les Hautes-Pyrénées</h2>\n\n<h3>1. Google Business Profile : Votre vitrine gratuite</h3>\n\n<p>Votre fiche Google Business est <strong>l\'outil le plus puissant</strong> pour le référencement local à Tarbes. Elle apparaît dans Google Maps et dans les résultats de recherche.</p>\n\n<h4>Comment optimiser votre fiche :</h4>\n<ul>\n<li><strong>Complétez 100% des informations</strong> : adresse exacte à Tarbes/Lourdes, horaires, téléphone, site web</li>\n<li><strong>Choisissez la bonne catégorie</strong> : Soyez précis (\"Plombier\" plutôt que \"Artisan\")</li>\n<li><strong>Ajoutez des photos de qualité</strong> : Locaux, équipe, réalisations</li>\n<li><strong>Publiez régulièrement</strong> : Posts, offres, actualités</li>\n<li><strong>Répondez aux avis</strong> : Tous, positifs comme négatifs</li>\n<li><strong>Utilisez les bons mots-clés</strong> : Tarbes, Lourdes, 65 dans votre description</li>\n</ul>\n\n<h3>2. Les avis clients : La preuve sociale qui convertit</h3>\n\n<p>Les avis Google sont un facteur de classement majeur. Plus vous avez d\'avis positifs récents, mieux vous êtes positionné.</p>\n\n<h4>Stratégie pour obtenir des avis :</h4>\n<ul>\n<li>Demandez systématiquement après chaque prestation réussie</li>\n<li>Envoyez un lien direct vers votre fiche Google</li>\n<li>Répondez à TOUS les avis en moins de 24h</li>\n<li>Affichez une moyenne de 4,5+ étoiles</li>\n</ul>\n\n<p><strong>Astuce Tarbes</strong> : Mentionnez votre ville dans vos réponses aux avis (\"Merci pour votre confiance, ravis d\'avoir pu vous servir à Tarbes !\")</p>\n\n<h3>3. Votre site web : La base technique du SEO</h3>\n\n<p>Votre site doit être <strong>optimisé pour le référencement local</strong> dans les Hautes-Pyrénées :</p>\n\n<h4>Les indispensables :</h4>\n<ul>\n<li><strong>Mentions locales partout</strong> : Tarbes, Lourdes, 65, Hautes-Pyrénées dans vos titres, textes, métadonnées</li>\n<li><strong>Page \"Zone d\'intervention\"</strong> : Listez toutes les villes où vous intervenez (Tarbes, Lourdes, Vic-en-Bigorre, Aureilhan...)</li>\n<li><strong>Coordonnées visibles</strong> : Adresse complète dans le footer de chaque page</li>\n<li><strong>Vitesse de chargement</strong> : Site rapide = meilleur classement Google</li>\n<li><strong>Version mobile parfaite</strong> : 80% des recherches locales sont sur smartphone</li>\n<li><strong>Schema.org LocalBusiness</strong> : Code technique pour aider Google à comprendre votre localisation</li>\n</ul>\n\n<h2>Les recherches locales les plus courantes à Tarbes en 2026</h2>\n\n<p>Voici les types de recherches que font vos clients potentiels :</p>\n<ul>\n<li>\"[votre métier] Tarbes\" (ex: dentiste Tarbes, avocat Tarbes)</li>\n<li>\"[service] près de moi\" (Google utilise la géolocalisation)</li>\n<li>\"[produit] Lourdes\" (ex: pizza Lourdes, matériel informatique Lourdes)</li>\n<li>\"[métier] Hautes-Pyrénées\"</li>\n<li>\"[service] ouvert maintenant Tarbes\"</li>\n</ul>\n\n<h2>Créer du contenu local qui ranke sur Google</h2>\n\n<p>Le contenu est roi en SEO. Pour Tarbes et Lourdes, créez :</p>\n\n<h3>Types de contenus performants :</h3>\n<ul>\n<li><strong>Articles de blog locaux</strong> : \"Top 10 des restaurants à Tarbes\", \"Guide du tourisme à Lourdes\"</li>\n<li><strong>Actualités locales</strong> : Participation à des événements du 65</li>\n<li><strong>Témoignages clients</strong> : Avec mention de leur ville</li>\n<li><strong>Études de cas</strong> : \"Comment nous avons aidé une entreprise de Tarbes à...\"</li>\n<li><strong>FAQ locale</strong> : Répondez aux questions spécifiques à votre zone</li>\n</ul>\n\n<h2>Les erreurs à éviter en SEO local</h2>\n\n<ul>\n<li>Adresse incohérente entre site web, Google et annuaires</li>\n<li>Ne pas répondre aux avis négatifs</li>\n<li>Fiche Google incomplète ou abandonnée</li>\n<li>Site non-responsive (pas adapté mobile)</li>\n<li>Acheter de faux avis (Google pénalise durement)</li>\n<li>Négliger la vitesse du site</li>\n</ul>\n\n<h2>Combien de temps pour voir des résultats à Tarbes ?</h2>\n\n<p>Le SEO local est plus rapide que le SEO national :</p>\n<ul>\n<li><strong>Google Business optimisé</strong> : Résultats visibles en 2-4 semaines</li>\n<li><strong>SEO on-site</strong> : 2-3 mois pour voir une amélioration</li>\n<li><strong>Stratégie complète</strong> : 6 mois pour dominer votre secteur à Tarbes</li>\n</ul>\n\n<h2>Alex² : Votre expert SEO local à Tarbes et Lourdes</h2>\n\n<p>Nous accompagnons les entreprises des Hautes-Pyrénées dans leur stratégie de référencement local. Audit SEO, optimisation Google Business, création de contenu local, suivi mensuel des performances.</p>\n\n<p><strong>Objectif : Vous positionner dans le Top 3 Google à Tarbes et Lourdes</strong></p>\n\n<p>Contactez-nous pour un audit SEO gratuit de votre présence locale !</p>\n\n<h2>Checklist SEO local Tarbes</h2>\n\n<ul>\n<li>Fiche Google Business créée et complétée à 100%</li>\n<li>Au moins 10 avis Google positifs</li>\n<li>Site web mentionnant Tarbes/Lourdes/65 sur chaque page</li>\n<li>Coordonnées NAP (Name, Address, Phone) cohérentes partout</li>\n<li>Site mobile-friendly et rapide</li>\n<li>Présence dans les annuaires locaux (Pages Jaunes, Yelp...)</li>\n<li>Articles de blog avec mots-clés locaux</li>\n<li>Photos géolocalisées sur Google Business</li>\n<li>Réponse à tous les avis en moins de 48h</li>\n<li>Schema markup LocalBusiness intégré</li>\n</ul>\n\n<p><em>Dernière mise à jour : Janvier 2026 - Stratégies testées et approuvées sur le marché tarbais.</em></p>', 'Alex²', '2026-01-04 17:30:25', '2026-01-04 17:30:25', 1),
(9, 'ADH 65 : Comment le web peut servir la solidarité internationale', 'adh65-web-solidarite-internationale', 'Projets', 'Étude de cas', NULL, 'Retour sur la création du site du Festival L\'Eau & L\'Autre pour l\'association AHD 65, entre engagement humanitaire et technologies web modernes.', '<h2>Un projet qui a du sens</h2>\n<p>Quand l\'association <strong>AHD 65</strong> (Action Humanitaire et Développement) nous a contactés pour refondre le site de leur festival annuel <em>L\'Eau & L\'Autre</em>, on a tout de suite accroché. Le projet avait une dimension qui dépasse le simple site vitrine : sensibiliser le public aux enjeux de l\'accès à l\'eau, à l\'éducation et à la santé au Cameroun et au Liban.</p>\n\n<h2>Le défi technique</h2>\n<p>L\'association voulait un site <strong>immersif</strong> qui reflète l\'énergie du festival : concerts, théâtre, conférences, expositions d\'art... Le tout dans un cadre solidaire. Le challenge ? Créer une expérience visuelle forte tout en gardant un site accessible et performant.</p>\n\n<h3>Les choix techniques</h3>\n<p>On a opté pour une stack moderne et légère :</p>\n<ul>\n  <li><strong>Three.js</strong> pour les animations 3D du hero</li>\n  <li><strong>GSAP</strong> (GreenSock) pour les animations au scroll</li>\n  <li><strong>Tailwind CSS v4</strong> pour un design responsive impeccable</li>\n  <li>Des effets de <strong>glassmorphism</strong> (backdrop-filter, blur) pour un rendu moderne et aérien</li>\n</ul>\n\n<h2>La galerie d\'oeuvres</h2>\n<p>Un des points forts du site : la galerie interactive de <strong>51 oeuvres d\'art</strong> exposées lors du festival. Chaque pièce est mise en valeur avec un système de lightbox fluide. Les artistes locaux bénéficient ainsi d\'une vitrine numérique pérenne, bien au-delà de la journée du festival.</p>\n\n<h2>Le programme interactif</h2>\n<p>Le planning de la journée est affiché sous forme de <strong>timeline verticale</strong> avec des icônes SVG personnalisées pour chaque type d\'événement : micro pour les conférences, notes de musique pour les concerts, palette pour les expositions. L\'utilisateur visualise immédiatement le déroulé de la journée.</p>\n\n<h2>Les résultats</h2>\n<p>Le site a été livré pour l\'édition 2025 du festival à Séméac. Les retours ont été très positifs :</p>\n<ul>\n  <li>Un site qui donne envie de participer au festival</li>\n  <li>Les partenaires et sponsors mis en valeur</li>\n  <li>Un outil de communication réutilisable pour les éditions futures</li>\n  <li>Score Lighthouse performance : <strong>92/100</strong></li>\n</ul>\n\n<h2>Ce qu\'on retient</h2>\n<p>Ce projet nous a rappelé pourquoi on fait ce métier. Le web n\'est pas qu\'un outil commercial — c\'est aussi un <strong>amplificateur de causes</strong>. Quand la technologie est au service de la solidarité, les lignes de code prennent un autre sens.</p>\n\n<p>Si vous aussi vous portez un projet associatif ou solidaire et que vous avez besoin d\'un site web à la hauteur de votre engagement, <strong>contactez-nous</strong>. On sera ravis d\'en discuter autour d\'un café à Tarbes ou Lourdes.</p>', 'Alex²', '2025-02-05 10:00:00', '2026-02-08 05:00:56', 1),
(10, 'React 19, Bun 2, Tailwind 4 : ce qui change en 2025 pour les développeurs web', 'react19-bun2-tailwind4-nouveautes-2025', 'Actualités Tech', 'Veille techno', NULL, 'Tour d\'horizon des nouveautés qui transforment le développement web en 2025 : React Server Components, Bun 2.0, Tailwind v4 et l\'IA dans nos workflows.', '<h2>2025, une année charnière pour le dev web</h2>\n<p>L\'écosystème JavaScript n\'arrête jamais de bouger, mais 2025 marque un vrai tournant. Entre la stabilisation de <strong>React 19</strong>, l\'arrivée de <strong>Bun 2.0</strong>, la refonte de <strong>Tailwind CSS v4</strong> et l\'intégration massive de l\'<strong>IA dans nos outils</strong>, on fait le point sur ce qui change concrètement dans notre quotidien de développeurs.</p>\n\n<h2>React 19 : les Server Components deviennent la norme</h2>\n<p>React 19 n\'est pas une révolution visuelle, mais une <strong>révolution architecturale</strong>. Les Server Components (RSC), introduits expérimentalement avec React 18, deviennent le standard :</p>\n<ul>\n  <li><strong>use()</strong> — le nouveau hook pour consommer des promesses et du contexte directement</li>\n  <li><strong>Server Actions</strong> — des fonctions côté serveur appelables depuis le client, adieu les routes API manuelles pour les mutations</li>\n  <li><strong>Formulaires natifs améliorés</strong> — useFormStatus() et useOptimistic() simplifient drastiquement la gestion des formulaires</li>\n  <li><strong>Préchargement des assets</strong> — React gère nativement le prefetch des scripts, styles et fonts</li>\n</ul>\n<p>En pratique, ça veut dire <strong>moins de code client</strong>, des bundles plus légers, et une meilleure expérience utilisateur par défaut.</p>\n\n<h2>Bun 2.0 : le runtime qui bouscule Node.js</h2>\n<p>Bun continue sa montée en puissance. La version 2.0 apporte :</p>\n<ul>\n  <li><strong>Compatibilité Node.js quasi-totale</strong> — la majorité des packages npm fonctionnent sans modification</li>\n  <li><strong>Bun.serve() amélioré</strong> — un serveur HTTP encore plus rapide avec support natif WebSocket</li>\n  <li><strong>Package manager 3x plus rapide</strong> que npm, avec un lockfile binaire</li>\n  <li><strong>Bundler intégré</strong> — plus besoin de webpack ou esbuild pour les cas courants</li>\n</ul>\n<p>Pour nous chez Alex², on l\'utilise de plus en plus en développement local. Le gain de temps sur les install est impressionnant, surtout sur les gros projets.</p>\n\n<h2>Tailwind CSS v4 : la réécriture complète</h2>\n<p>Tailwind v4 est une <strong>réécriture from scratch</strong> du moteur. Le résultat :</p>\n<ul>\n  <li><strong>Oxide Engine</strong> — un nouveau moteur écrit en Rust, 10x plus rapide à compiler</li>\n  <li><strong>Zero-config</strong> — plus besoin de tailwind.config.js dans la plupart des cas, tout se fait en CSS avec @theme</li>\n  <li><strong>CSS natif</strong> — utilise les layers CSS natifs, les custom properties et @property</li>\n  <li><strong>Container Queries</strong> built-in avec la syntaxe @container</li>\n  <li><strong>3D transforms</strong>, gradients améliorés, et color-mix() pour les variantes de couleurs</li>\n</ul>\n<p>C\'est exactement ce qu\'on a utilisé pour le site AHD 65 — la vitesse de compilation et la simplicité de configuration font une vraie différence.</p>\n\n<h2>L\'IA dans le workflow dev : au-delà du hype</h2>\n<p>En 2025, l\'IA n\'est plus un gadget, c\'est un <strong>outil de productivité quotidien</strong> :</p>\n<ul>\n  <li><strong>Claude Code</strong> (Anthropic) — un assistant CLI qui comprend le contexte de votre projet et peut modifier directement le code</li>\n  <li><strong>GitHub Copilot Workspace</strong> — planification et implémentation de features complètes depuis une issue</li>\n  <li><strong>Cursor / Windsurf</strong> — des IDE augmentés par l\'IA qui accélèrent la navigation et le refactoring</li>\n</ul>\n<p>L\'enjeu n\'est plus \"est-ce que l\'IA code bien ?\" mais \"<strong>comment l\'intégrer intelligemment</strong> dans notre processus sans perdre la maîtrise du code\". Chez Alex², on utilise l\'IA comme accélérateur, jamais comme remplacement du savoir-faire.</p>\n\n<h2>Notre avis</h2>\n<p>2025 récompense les développeurs qui investissent dans les <strong>fondamentaux</strong>. Les frameworks changent, mais les principes restent : performance, accessibilité, code maintenable. Les nouveaux outils rendent le développement web plus rapide et plus agréable — à condition de ne pas courir après chaque nouveauté sans comprendre les bases.</p>\n\n<p>Envie de discuter tech ou de lancer un projet avec une stack moderne ? <strong>Contactez-nous</strong>, on adore ça.</p>', 'Alex²', '2025-02-08 14:00:00', '2026-02-08 05:00:56', 1);

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

CREATE TABLE `projets` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `annee` varchar(10) NOT NULL,
  `type` varchar(100) NOT NULL,
  `image` text NOT NULL,
  `images` longtext DEFAULT NULL,
  `description_courte` text NOT NULL,
  `description_detaillee` text NOT NULL,
  `lien` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`id`, `nom`, `slug`, `annee`, `type`, `image`, `images`, `description_courte`, `description_detaillee`, `lien`) VALUES
(22, 'Festival L\'Eau & L\'Autre - AHD65', 'ahd65-festival', '2025', 'Site vitrine', 'asset/img/projets/ahd65-icon.svg', '[]', 'Site événementiel pour le festival humanitaire L\'Eau & L\'Autre de l\'association AHD 65 à Séméac, avec animations 3D et design glassmorphism.', 'Refonte complète du site du Festival L\'Eau & L\'Autre, organisé par l\'association AHD 65 oeuvrant pour l\'accès à l\'eau, l\'éducation et la santé au Cameroun et au Liban. Le site présente la programmation du festival (concerts, théâtre, conférences), une galerie d\'oeuvres d\'art (51 pièces), les partenaires et sponsors, ainsi qu\'un système de dons. Construit avec des technologies modernes : animations Three.js pour le hero 3D, GSAP pour les animations au scroll, effets glassmorphism avec backdrop-filter, et Tailwind CSS v4. Le design est immersif avec des particules canvas et des transitions fluides.', 'https://adh65-festival.fr/'),
(23, 'Amicale Tarbaise d\'Escrime', 'amicale-tarbaise-escrime', '2024', 'Site vitrine', 'asset/img/projets/escrime-logo.png', '[]', 'Site web complet pour le club d\'escrime de Tarbes avec gestion des compétitions, inscriptions et actualités multilingue.', 'Site vitrine professionnel pour l\'Amicale Tarbaise d\'Escrime, club d\'escrime historique de Tarbes. Le site comprend une page d\'accueil avec vidéo en arrière-plan, une section compétitions avec palmarès et médailles, un formulaire d\'inscription en ligne, les actualités presse du club, et les informations pratiques (horaires, tarifs). Le site est multilingue (FR/EN/ES) avec un sélecteur de langue dynamique, propose un mode sombre/clair, et affiche les partenaires institutionnels (FFE, Mairie de Tarbes, Région Occitanie). Backend PHP avec architecture MVC.', 'https://alex2-server.fr/AmicalTarbaiseescrime/'),
(24, 'MovieMi', 'moviemi', '2024', 'Application web', 'asset/img/projets/moviemi-logo.png', '[]', 'Plateforme de vote et classement de films avec système de points, statistiques en temps réel et catalogue de 300+ films.', 'MovieMi est une application web de vote et classement de films. Les utilisateurs créent un compte, sélectionnent leur top 3 de films favoris parmi un catalogue de plus de 300 films avec affiches, et accumulent des points selon un barème (25 pts pour le 1er, 18 pts pour le 2ème, 15 pts pour le 3ème). Les résultats sont affichés en temps réel via des graphiques Chart.js interactifs. L\'application inclut l\'authentification par sessions, la recherche de films avec Select2, des profils utilisateurs, et un design responsive Bootstrap. Backend PHP avec PDO et base MySQL.', 'https://alex2-server.fr/MovieMi/'),
(25, 'Novatis', 'novatis', '2025', 'Marketplace', 'asset/img/projets/novatis-logo.png', '[]', 'Plateforme de mise en relation entre clients et prestataires de services avec messagerie temps réel, avis et gestion de commandes.', 'Novatis est une marketplace professionnelle complète connectant clients et prestataires de services. La plateforme offre : authentification sécurisée (classique + OAuth), profils prestataires avec portfolios, catalogue de services avec recherche et filtres avancés, messagerie en temps réel entre utilisateurs, système de commandes avec suivi, avis et notation, notifications, support multilingue (FR/EN) via i18next, et thème sombre/clair. Architecture MVC avec PHP 8+, frontend React 18 avec Tailwind CSS 3, base de données MySQL 8, et pattern Repository pour l\'accès aux données. Version 2.0.', 'https://alex2-server.fr/novatis/public/'),
(26, 'Portfolio Ray Kpolom', 'portfolio-ray', '2024', 'Portfolio', 'asset/img/projets/portfolio-ray-icon.svg', '[]', 'Portfolio créatif pour un graphiste et artiste 3D avec effets de scroll 3D, filtrage de projets et back-office d\'administration.', 'Portfolio professionnel de Ray Kpolom, graphiste et artiste 3D. Le site propose une galerie de projets avec effets de défilement 3D et filtrage par catégorie (graphisme, 3D, branding), un support bilingue FR/EN avec traduction automatique via Google Translate API, et un back-office complet d\'administration pour gérer les projets (CRUD, upload d\'images par drag-and-drop ou URL, statuts : terminé, en cours, concept). Construit avec React 18, Tailwind CSS 3, et un backend PHP avec API REST et stockage JSON. Design glassmorphism avec animations fluides et mise en page responsive adaptative (1 à 3 colonnes).', 'https://kpolom-ray.alwaysdata.net/');

-- --------------------------------------------------------

--
-- Structure de la table `promo_emails`
--

CREATE TABLE `promo_emails` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code_promo` varchar(20) NOT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  `utilise` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `line1` varchar(255) DEFAULT NULL,
  `line2` varchar(255) DEFAULT NULL,
  `line3` varchar(255) DEFAULT NULL,
  `line4` varchar(255) DEFAULT NULL,
  `line5` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `name`, `line1`, `line2`, `line3`, `line4`, `line5`) VALUES
(1, 'Site vitrine simple', 'Création de site vitrine moderne et responsive', '> Création de site vitrine simple', '> Responsive, rapide, moderne', '> Adapté à votre activité', '> Statut : DISPONIBLE'),
(2, 'Site vitrine sur mesure', 'Design personnalisé avec fonctionnalités avancées', '> Création de site vitrine personnalisé', '> Design sur mesure & fonctionnalités avancées', '> Accompagnement UX/UI', '> Statut : DISPONIBLE'),
(3, 'Portfolio professionnel', 'Mise en valeur de vos projets et compétences', '> Création de site personnel ou portfolio', '> Présentation claire de vos compétences', '> Intégration LinkedIn, contact', '> Statut : DISPONIBLE'),
(4, 'Maintenance & Support', 'Suivi mensuel de votre site web', '> Maintenance mensuelle', '> Sauvegardes, mises à jour, support', '> Monitoring performance & sécurité', '> Statut : DISPONIBLE'),
(5, 'Audit SEO', 'Analyse complète et optimisation technique', '> Audit SEO ponctuel', '> Optimisation technique & sémantique', '> Amélioration des balises & contenus', '> Statut : DISPONIBLE'),
(6, 'Référencement mensuel', 'Suivi continu de vos performances SEO', '> Suivi SEO mensuel', '> Analyse de performance & recommandations', '> Reporting & ajustements continus', '> Statut : DISPONIBLE'),
(7, 'Conseil UX/UI', 'Stratégie digitale et expérience utilisateur', '> Conseil en UX/UI ou stratégie digitale', '> Recommandations ergonomiques', '> Accompagnement sur l\'expérience utilisateur', '> Statut : DISPONIBLE'),
(8, 'Identité visuelle', 'Création de votre image de marque', '> Création d\'identité visuelle', '> Logo, palette de couleurs, typographie', '> Kit complet pour le web & print', '> Statut : DISPONIBLE');

-- --------------------------------------------------------

--
-- Structure de la table `temoignages`
--

CREATE TABLE `temoignages` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `entreprise` varchar(100) DEFAULT NULL,
  `texte` text NOT NULL,
  `note` int(11) DEFAULT 5,
  `date_collaboration` varchar(50) DEFAULT NULL,
  `actif` tinyint(1) DEFAULT 1,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_categorie` (`categorie`),
  ADD KEY `idx_date` (`date_publication`),
  ADD KEY `idx_sous_categorie` (`sous_categorie`);

--
-- Index pour la table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_slug` (`slug`);

--
-- Index pour la table `promo_emails`
--
ALTER TABLE `promo_emails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_code` (`code_promo`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `temoignages`
--
ALTER TABLE `temoignages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `projets`
--
ALTER TABLE `projets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `promo_emails`
--
ALTER TABLE `promo_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `temoignages`
--
ALTER TABLE `temoignages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
