<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>404 - Page non trouvée</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- React + Babel -->
    <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

    <!-- Ton fichier de variables -->
    <link rel="stylesheet" href="/Alex2/public/asset/css/variables.css" />

    <!-- Styles supplémentaires -->
    <style>
        body {
        font-family: var(--font-base);
        background-color: var(--color-white);
        color: var(--color-black);
        }

        .typewriter-text::after {
        content: '|';
        animation: blink 1s infinite;
        }

        @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0; }
        }

        .typewriter-text {
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        border-right: 2px solid var(--color-cyan);
        animation: typing 3s steps(40, end) forwards;
        width: 0;
        }

        @keyframes typing {
        from { width: 0 }
        to { width: 100% }
        }

        .terminal-box {
        border: 2px solid transparent;
        background-clip: padding-box;
        border-image: linear-gradient(to right, var(--color-cyan), var(--color-green)) 1;
        }
    </style>
    </head>

    <body>
    <div id="root" class="h-screen flex items-center justify-center px-6"></div>

    <script type="text/babel">
        const Page404 = () => {
        return (
            <div className="text-center max-w-2xl mx-auto">
            <h1 className="text-5xl font-black text-red-600 mb-6" style={{ fontFamily: "var(--font-heading)" }}>
                Erreur 404
            </h1>
            <p className="text-xl mb-8 text-black">
                <span className="typewriter-text">
                {"<Oops/> La page que vous cherchez n'existe pas..."}
                </span>
            </p>

            <div className="bg-[var(--color-white)] text-left text-[var(--color-green)] rounded-xl p-6 font-mono text-sm shadow-lg terminal-box">
                <pre>
    {`> cd /home
    > ls
    404.html    index.php    projet.js

    > open 404.html
    Oops! Fichier introuvable...`}
                </pre>
            </div>

            <a
                href="/Alex2/public"
                className="inline-block mt-10 px-6 py-3 rounded-lg text-white shadow transition duration-300"
                style={{
                backgroundColor: "var(--color-black)",
                fontFamily: "var(--font-base)",
                }}
            >
                ⬅️ Retour à l'accueil
            </a>
            </div>
        );
        };

        const root = ReactDOM.createRoot(document.getElementById("root"));
        root.render(<Page404 />);
    </script>
</body>
</html>
