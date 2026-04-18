<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(($pageTitle ?? config('app.name')) . ' - ' . config('app.name')) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,400..700,0..1,-50..200&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary:    '#6d2ef5',
                        'on-primary': '#ffffff',
                        'primary-container': '#ecdcff',
                        'on-primary-container': '#22006c',
                        secondary:  '#625b71',
                        'on-secondary': '#ffffff',
                        'secondary-container': '#e8def8',
                        'on-secondary-container': '#1d192b',
                        tertiary:   '#7e5260',
                        'tertiary-container': '#ffd8e4',
                        'on-tertiary-container': '#31111d',
                        surface:    '#fffbff',
                        'on-surface': '#1c1b1f',
                        'surface-variant': '#e7e0eb',
                        'on-surface-variant': '#49454e',
                        'surface-container-lowest': '#ffffff',
                        'surface-container-low': '#f7f2fa',
                        'surface-container': '#f1ecf4',
                        'surface-container-high': '#ece6f0',
                        'surface-container-highest': '#e6e0e9',
                        'inverse-surface': '#313033',
                        'inverse-on-surface': '#f4eff4',
                        outline:    '#7a7289',
                        'outline-variant': '#cac4d0',
                        error:      '#b3261e',
                        'on-error': '#ffffff',
                        'error-container': '#f9dedc',
                        'on-error-container': '#410e0b',
                        success:    '#1a6b34',
                        'success-container': '#b3f0c8',
                        'on-success-container': '#002110',
                    },
                    fontFamily: {
                        sans: ['Roboto', 'ui-sans-serif', 'system-ui'],
                    },
                    boxShadow: {
                        'elev1': '0px 1px 2px rgba(0,0,0,0.3), 0px 1px 3px 1px rgba(0,0,0,0.15)',
                        'elev2': '0px 1px 2px rgba(0,0,0,0.3), 0px 2px 6px 2px rgba(0,0,0,0.15)',
                        'elev3': '0px 4px 8px 3px rgba(0,0,0,0.15), 0px 1px 3px rgba(0,0,0,0.3)',
                        'elev4': '0px 6px 10px 4px rgba(0,0,0,0.15), 0px 2px 3px rgba(0,0,0,0.3)',
                    },
                    borderRadius: {
                        'xs': '4px', 'sm': '8px', 'md': '12px', 'lg': '16px', 'xl': '28px', '2xl': '9999px',
                    },
                }
            }
        };
    </script>

    <style>
        .material-symbols-rounded {
            font-family: 'Material Symbols Rounded';
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            font-size: 24px;
            line-height: 1;
            user-select: none;
        }
        .sym-filled { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }

        /* State layer (hover/focus/pressed) */
        .state-layer {
            position: relative; overflow: hidden;
        }
        .state-layer::after {
            content: ''; position: absolute; inset: 0;
            background: currentColor; opacity: 0;
            border-radius: inherit;
            transition: opacity 150ms;
        }
        .state-layer:hover::after  { opacity: .08; }
        .state-layer:focus-visible::after { opacity: .12; }
        .state-layer:active::after { opacity: .12; }

        /* Drawer slide animation */
        #nav-drawer { transition: transform 300ms cubic-bezier(0.05, 0.7, 0.1, 1); }
        #drawer-overlay { transition: opacity 300ms; }

        /* Active nav pill */
        .nav-active {
            background-color: #e8def8;
            color: #1d192b;
        }
        .nav-active .nav-icon { font-variation-settings: 'FILL' 1, 'wght' 600, 'GRAD' 0, 'opsz' 24; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cac4d0; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #7a7289; }
    </style>
</head>
<body class="bg-surface-container-low font-sans antialiased text-on-surface">

    <!-- ── Drawer overlay (mobile only) ────────────────────────────────── -->
    <div id="drawer-overlay"
         onclick="closeDrawer()"
         class="fixed inset-0 z-40 bg-black/30 opacity-0 pointer-events-none lg:hidden"
         aria-hidden="true"></div>

    <div class="flex h-screen overflow-hidden">

        <!-- ── Navigation Drawer ────────────────────────────────────────── -->
        <?php
            $currentPage = basename($_SERVER['SCRIPT_NAME'] ?? '');
            $activeNavMap = [
                'dashboard.php'              => 'dashboard.php',
                'volunteers.php'             => 'volunteers.php',
                'volunteer.php'              => 'volunteers.php',
                'invite.php'                 => 'invite.php',
                'export-volunteers.php'      => 'export-volunteers.php',
                'export-volunteers-pdf.php'  => 'export-volunteers-pdf.php',
            ];
            $activeNav = $activeNavMap[$currentPage] ?? '';
            $navItems  = [
                'dashboard.php'              => ['icon' => 'dashboard',       'label' => 'Tableau de bord'],
                'volunteers.php'             => ['icon' => 'group',            'label' => 'Bénévoles'],
                'invite.php'                 => ['icon' => 'add_link',         'label' => 'Créer un lien'],
                'export-volunteers.php'      => ['icon' => 'table_view',       'label' => 'Exporter CSV'],
                'export-volunteers-pdf.php'  => ['icon' => 'picture_as_pdf',   'label' => 'Exporter PDF'],
            ];
        ?>

        <aside id="nav-drawer"
               class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col bg-surface-container-low
                      lg:static lg:translate-x-0 lg:z-auto lg:shrink-0"
               aria-label="Navigation principale">

            <!-- Drawer header -->
            <div class="flex items-center gap-3 px-5 py-5 shrink-0">
                <img src="<?= e(url('assets/images/cloudy.png')) ?>"
                     alt="Logo"
                     class="h-10 w-10 rounded-xl object-cover">
                <div>
                    <p class="text-xs font-medium uppercase tracking-widest text-on-surface-variant leading-none mb-0.5">Admin</p>
                    <h1 class="text-base font-bold text-on-surface leading-tight"><?= e(config('app.name')) ?></h1>
                </div>
            </div>

            <div class="mx-4 h-px bg-outline-variant shrink-0"></div>

            <!-- Nav items -->
            <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-0.5" role="navigation">
                <?php foreach ($navItems as $file => $item):
                    $isActive = ($activeNav === $file);
                ?>
                <a href="<?= e(url($file)) ?>"
                   class="state-layer flex h-14 items-center gap-3 rounded-2xl px-4 text-sm font-medium
                          <?= $isActive ? 'nav-active' : 'text-on-surface-variant hover:bg-on-surface/5' ?>"
                   <?= $isActive ? 'aria-current="page"' : '' ?>>
                    <span class="material-symbols-rounded nav-icon text-[1.375rem] shrink-0
                                 <?= $isActive ? 'text-on-secondary-container' : 'text-on-surface-variant' ?>">
                        <?= $item['icon'] ?>
                    </span>
                    <span class="<?= $isActive ? 'font-semibold text-on-secondary-container' : '' ?>">
                        <?= $item['label'] ?>
                    </span>
                </a>
                <?php endforeach; ?>
            </nav>

            <div class="mx-4 h-px bg-outline-variant shrink-0"></div>

            <!-- User profile -->
            <?php $user = current_user(); ?>
            <?php if ($user !== null): ?>
            <div class="p-3 shrink-0">
                <div class="flex items-center gap-3 rounded-xl bg-surface-container px-3 py-2.5">
                    <img src="<?= e($user['avatar'] ?: 'https://placehold.co/96x96') ?>"
                         alt="Avatar"
                         class="h-9 w-9 rounded-full object-cover ring-2 ring-outline-variant">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-on-surface truncate"><?= e($user['name']) ?></p>
                        <p class="text-xs text-on-surface-variant">Administrateur</p>
                    </div>
                    <a href="<?= e(url('logout.php')) ?>"
                       class="state-layer flex h-9 w-9 items-center justify-center rounded-full
                              text-on-surface-variant hover:text-error hover:bg-error/8"
                       title="Se déconnecter"
                       aria-label="Se déconnecter">
                        <span class="material-symbols-rounded text-xl">logout</span>
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </aside>

        <!-- ── Main column (Top App Bar + content) ──────────────────────── -->
        <div class="flex flex-1 flex-col min-w-0 overflow-hidden">

            <!-- Mobile Top App Bar -->
            <header class="flex h-16 shrink-0 items-center gap-2 bg-surface-container-low px-2 shadow-elev1 lg:hidden"
                    role="banner">
                <button onclick="openDrawer()"
                        class="state-layer flex h-10 w-10 items-center justify-center rounded-full text-on-surface-variant"
                        aria-label="Ouvrir le menu"
                        aria-expanded="false"
                        aria-controls="nav-drawer">
                    <span class="material-symbols-rounded">menu</span>
                </button>
                <img src="<?= e(url('assets/images/cloudy.png')) ?>" alt="" class="h-7 w-7 rounded-lg">
                <span class="text-base font-semibold text-on-surface truncate"><?= e(config('app.name')) ?></span>
            </header>

            <!-- Page content -->
            <main id="main-content" class="flex-1 overflow-y-auto" role="main" tabindex="-1">
                <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                    <?= $content ?>
                </div>
            </main>
        </div>
    </div>

    <script>
        function openDrawer() {
            const drawer  = document.getElementById('nav-drawer');
            const overlay = document.getElementById('drawer-overlay');
            const btn     = document.querySelector('[aria-controls="nav-drawer"]');

            overlay.classList.remove('pointer-events-none', 'opacity-0');
            overlay.classList.add('opacity-100');
            drawer.classList.remove('-translate-x-full');
            if (btn) btn.setAttribute('aria-expanded', 'true');
        }

        function closeDrawer() {
            const drawer  = document.getElementById('nav-drawer');
            const overlay = document.getElementById('drawer-overlay');
            const btn     = document.querySelector('[aria-controls="nav-drawer"]');

            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            drawer.classList.add('-translate-x-full');
            if (btn) btn.setAttribute('aria-expanded', 'false');
            setTimeout(() => overlay.classList.add('pointer-events-none'), 300);
        }

        // Close drawer on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeDrawer();
        });
    </script>
</body>
</html>