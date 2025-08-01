<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<header>
    <nav x-data="{ open: false }" class="shadow px-6 py-4" style="background-color: var(--color-white); color: var(--color-black);">
        <!-- Ligne principale -->
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Logo + Nom -->
            <a href="<?= BASE_URL ?>/index.php" class="flex items-center space-x-2">
                <img src="<?= BASE_URL ?>/asset/img/logo.png" alt="Logo" class="w-12 h-12" />
                <span class="text-l font-bold" style="color: var(--color-black); font-family: var(--font-heading);">&lt;Alex²/&gt;</span>
            </a>

            <!-- Burger (mobile) -->
            <div class="md:hidden">
                <button @click="open = !open" class="text-gray-700 focus:outline-none">
                    <svg x-show="!open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" style="stroke: var(--color-black);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" style="stroke: var(--color-black);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Nav desktop -->
            <div class="hidden md:flex space-x-6 relative"
                 x-data="navAnim()"
                 x-init="init()"
                 @mouseover.away="hovering = false"
                 style="font-family: var(--font-base);">
                <div class="absolute nav-underline z-0 rounded transition-all duration-500 ease-out"
                     :style="{
                        width: highlight.width + 'px',
                        left: highlight.left + 'px',
                        backgroundColor: 'var(--color-black)',
                        top: '50%',
                        transform: 'translateY(-50%)',
                        height: '2em',
                        borderRadius: '0.5rem'
                    }"></div>

                <template x-for="(item, i) in items" :key="i">
                    <a :href="item.href"
                       class="nav-button relative px-1 font-medium transition-colors duration-300"
                       :style="{ color: activeIndex === i ? 'var(--color-white)' : 'var(--color-black)' }"
                       @mouseenter="setActive(i, $event)"
                       x-ref="btn">
                        <span x-text="item.name" class="relative z-10"></span>
                    </a>
                </template>
            </div>
        </div>

        <!-- Menu mobile -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden mt-4 space-y-2">
            <a href="<?= BASE_URL ?>/" class="block bg-white px-4 py-2 rounded shadow" style="color: var(--color-black); font-family: var(--font-base);">Accueil</a>
            <a href="<?= BASE_URL ?>/pages/NosProjets" class="block bg-white px-4 py-2 rounded shadow" style="color: var(--color-black); font-family: var(--font-base);">Projets réalisés</a>
            <a href="<?= BASE_URL ?>/pages/Services" class="block bg-white px-4 py-2 rounded shadow" style="color: var(--color-black); font-family: var(--font-base);">Nos services</a>
            <a href="<?= BASE_URL ?>/pages/Apropos" class="block bg-white px-4 py-2 rounded shadow" style="color: var(--color-black); font-family: var(--font-base);">À propos</a>
            <a href="<?= BASE_URL ?>/pages/Contact" class="block bg-white px-4 py-2 rounded shadow" style="color: var(--color-black); font-family: var(--font-base);">Contact</a>
        </div>
    </nav>

    <script>
        function navAnim() {
            const padding = 12;
            return {
                items: [
                    { name: 'Accueil', href: '<?= BASE_URL ?>/', file: 'index.php' },
                    { name: 'Projets réalisés', href: '<?= BASE_URL ?>/pages/NosProjets', file: 'NosProjets.php' },
                    { name: 'Nos services', href: '<?= BASE_URL ?>/pages/Services', file: 'Services.php' },
                    { name: 'À propos', href: '<?= BASE_URL ?>/pages/Apropos', file: 'Apropos.php' },
                    { name: 'Contact', href: '<?= BASE_URL ?>/pages/Contact', file: 'Contact.php' }
                ],
                highlight: { left: 0, width: 0 },
                activeIndex: 0,
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
                    const current = '<?= $currentPage ?>';
                    const foundIndex = this.items.findIndex(item => item.file === current);
                    if (foundIndex !== -1) {
                        this.activeIndex = foundIndex;
                    }
                    this.$nextTick(() => this.updateHighlight(this.activeIndex));
                }
            }
        }
    </script>

    <style>
        .nav-underline {
            pointer-events: none;
        }
    </style>
</header>
