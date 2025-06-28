<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- ✅ Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- ✅ Alpine.js CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body style="background-color: #e8e8e8;">
    <div class="header">
        <!-- ✅ Navbar -->
        <nav x-data="{ open: false }" class="bg-white shadow px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Logo + Nom -->
            <div class="flex items-center space-x-2">
            <img src="../public/asset/img/logo.png" alt="Logo" class="w-9 h-9" />
            <span class="text-xl font-bold" style="color: #1f2020;">&lt;Alex²/&gt;</span>
            </div>

            <!-- Burger (mobile) -->
            <div class="md:hidden">
            <button @click="open = !open" class="text-gray-700 focus:outline-none">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            </div>

            <!-- Nav desktop (cachée en mobile) -->
            <div class="hidden md:flex space-x-4 relative" x-data="navAnim()" @mouseover.away="hovering = false" x-init="init()">
            <!-- Ligne animée -->
            <div
                class="absolute nav-underline rounded z-0 transition-all duration-300 ease-in-out"
                :style="{
                width: highlight.width + 'px',
                left: highlight.left + 'px',
                backgroundColor: '#1f2020',
                top: '50%',
                transform: 'translateY(-50%)',
                height: '1.8em'
                }"
            ></div>

            <!-- Liens nav -->
            <template x-for="(item, i) in items" :key="i">
                <a
                :href="item.href"
                class="nav-button text-gray-800 cursor-pointer relative px-1"
                :class="{ 'text-[#e8e8e8]': activeIndex === i, 'text-gray-800': activeIndex !== i }"
                @click.prevent="setActive(i, $event)"
                x-ref="btn"
                >
                <span x-text="item.name" class="relative z-10"></span>
                </a>
            </template>
            </div>
        </div>

        <!-- Menu mobile affiché sous le logo -->
        <div x-show="open" x-transition class="md:hidden mt-3 space-y-2">
            <a href="#accueil" class="block border border-gray-300 px-4 py-2 rounded shadow" style="color: #1f2020;">Accueil</a>
            <a href="#projets" class="block border border-gray-300 px-4 py-2 rounded shadow" style="color: #1f2020;">Projets réalisés</a>
            <a href="#services" class="block border border-gray-300 px-4 py-2 rounded shadow" style="color: #1f2020;">Nos services</a>
            <a href="#apropos" class="block border border-gray-300 px-4 py-2 rounded shadow" style="color: #1f2020;">À propos de l'entreprise</a>
            <a href="#contact" class="block border border-gray-300 px-4 py-2 rounded shadow" style="color: #1f2020;">Contact</a>
        </div>

        <!-- Alpine.js animation nav desktop -->
        <script>
            function navAnim() {
            const padding = 10;
            return {
                items: [
                { name: 'Accueil', href: '#accueil' },
                { name: 'Projets réalisés', href: '#projets' },
                { name: 'Nos services', href: '#services' },
                { name: "À propos de l'entreprise", href: '#apropos' },
                { name: 'Contact', href: '#contact' }
                ],
                highlight: { left: 0, width: 0 },
                activeIndex: 0,
                hovering: false,
                open: false,

                setActive(index, event) {
                this.activeIndex = index;
                const el = event.currentTarget.querySelector('span');
                this.highlight.left = el.offsetLeft + event.currentTarget.offsetLeft - padding;
                this.highlight.width = el.offsetWidth + padding * 2;
                },

                updateHighlight(index) {
                const buttons = this.$el.querySelectorAll('.nav-button');
                if (buttons.length > 0) {
                    const el = buttons[index].querySelector('span');
                    this.highlight.left = el.offsetLeft + buttons[index].offsetLeft - padding;
                    this.highlight.width = el.offsetWidth + padding * 2;
                }
                },

                init() {
                this.$nextTick(() => {
                    this.updateHighlight(this.activeIndex);
                });
                }
            }
            }
        </script>
            <style>
            .text-default {
                color: #1f2020; /* Couleur texte normal */
            }
            .text-active {
                color: #e8e8e8; /* Couleur texte actif */
            }
            .nav-underline {
                pointer-events: none;
                padding-left: 10px;   /* Espace à gauche */
                padding-right: 10px;  /* Espace à droite */
                box-sizing: border-box; /* Inclure le padding dans la largeur */
            }
            </style>
        </nav>
    </div>
</body>
</html>