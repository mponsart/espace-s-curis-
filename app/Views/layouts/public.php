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
                        primary:    '#d0bcff',
                        'on-primary': '#381e72',
                        'primary-container': '#4f378b',
                        'on-primary-container': '#eaddff',
                        secondary:  '#cbc2db',
                        'secondary-container': '#4a4458',
                        'on-secondary-container': '#e8def8',
                        surface:    '#141218',
                        'on-surface': '#e6e1e5',
                        'surface-variant': '#49454e',
                        'on-surface-variant': '#cac4d0',
                        'surface-container-lowest': '#0f0d13',
                        'surface-container-low': '#1d1b20',
                        'surface-container': '#211f26',
                        'surface-container-high': '#2b2930',
                        'surface-container-highest': '#36343b',
                        'inverse-surface': '#e6e1e5',
                        'inverse-on-surface': '#313033',
                        'inverse-primary': '#6d2ef5',
                        outline:    '#938f99',
                        'outline-variant': '#49454e',
                        error:      '#f2b8b5',
                        'on-error': '#601410',
                        'error-container': '#8c1d18',
                        'on-error-container': '#f9dedc',
                        success:    '#6dd58c',
                        'success-container': '#0d5927',
                        'on-success-container': '#b3f0c8',
                    },
                    fontFamily: {
                        sans: ['Roboto', 'ui-sans-serif', 'system-ui'],
                    },
                    boxShadow: {
                        'elev1': '0px 1px 2px rgba(0,0,0,0.3), 0px 1px 3px 1px rgba(0,0,0,0.15)',
                        'elev2': '0px 1px 2px rgba(0,0,0,0.3), 0px 2px 6px 2px rgba(0,0,0,0.15)',
                        'elev3': '0px 4px 8px 3px rgba(0,0,0,0.15), 0px 1px 3px rgba(0,0,0,0.3)',
                    },
                    borderRadius: {
                        'xs': '4px', 'sm': '8px', 'md': '12px', 'lg': '16px', 'xl': '28px',
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

        /* State layer */
        .state-layer { position: relative; overflow: hidden; }
        .state-layer::after {
            content: ''; position: absolute; inset: 0;
            background: currentColor; opacity: 0;
            border-radius: inherit; transition: opacity 150ms;
        }
        .state-layer:hover::after  { opacity: .08; }
        .state-layer:focus-visible::after { opacity: .12; }
        .state-layer:active::after { opacity: .12; }

        /* MD3 outlined text field (dark) */
        .md-field { position: relative; }
        .md-field input,
        .md-field select,
        .md-field textarea {
            width: 100%; padding: 16px;
            background: transparent;
            border: 1px solid #938f99;
            border-radius: 4px;
            color: #e6e1e5;
            font-size: 16px;
            font-family: inherit;
            outline: none;
            transition: border-color 150ms, border-width 150ms;
            appearance: none; -webkit-appearance: none;
        }
        .md-field input:focus,
        .md-field select:focus,
        .md-field textarea:focus {
            border-color: #d0bcff;
            border-width: 2px;
        }
        .md-field input:disabled,
        .md-field select:disabled,
        .md-field textarea:disabled {
            border-color: rgba(147,143,153,0.38);
            color: rgba(230,225,229,0.38);
            cursor: not-allowed;
        }
        .md-field label {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%);
            font-size: 16px; color: #938f99;
            pointer-events: none;
            transition: all 150ms;
            background: #141218;
            padding: 0 4px;
        }
        .md-field textarea ~ label { top: 16px; transform: none; }
        .md-field input:focus ~ label,
        .md-field input:not(:placeholder-shown) ~ label,
        .md-field select:focus ~ label,
        .md-field select:not([value=""]) ~ label,
        .md-field textarea:focus ~ label,
        .md-field textarea:not(:placeholder-shown) ~ label {
            top: 0; font-size: 12px;
        }
        .md-field input:focus ~ label,
        .md-field select:focus ~ label,
        .md-field textarea:focus ~ label {
            color: #d0bcff;
        }
        /* Date input always shows the label at top */
        .md-field input[type="date"] ~ label { top: 0; font-size: 12px; }
        .md-field input[type="date"]:focus ~ label { color: #d0bcff; }
        /* Select option styling */
        .md-field select option { background: #211f26; color: #e6e1e5; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #49454e; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #938f99; }
    </style>
</head>
<body class="min-h-screen bg-surface font-sans antialiased text-on-surface">

    <!-- Subtle tonal background -->
    <div class="pointer-events-none fixed inset-0 -z-10"
         style="background: radial-gradient(ellipse 80% 50% at 20% 0%, rgba(109,46,245,0.18) 0%, transparent 60%),
                            radial-gradient(ellipse 60% 40% at 80% 100%, rgba(208,188,255,0.10) 0%, transparent 55%);">
    </div>

    <main class="mx-auto flex min-h-screen w-full max-w-5xl flex-col items-center justify-center gap-8 px-4 py-10 sm:px-6 lg:px-8"
          role="main">

        <!-- Logo + brand -->
        <div class="flex flex-col items-center gap-3 text-center">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-primary-container shadow-elev2">
                <img src="<?= e(url('assets/images/cloudy.png')) ?>"
                     alt="Logo <?= e(config('app.name')) ?>"
                     class="h-10 w-10 object-cover rounded-xl">
            </div>
            <p class="text-sm font-medium text-on-surface-variant tracking-wider uppercase">
                <?= e(config('app.name')) ?>
            </p>
        </div>

        <?= $content ?>
    </main>
</body>
</html>