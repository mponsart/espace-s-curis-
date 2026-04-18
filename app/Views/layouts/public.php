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
                    },
                    borderRadius: {
                        'xs': '4px', 'sm': '8px', 'md': '12px', 'lg': '16px', 'xl': '28px',
                    },
                }
            }
        };
    </script>

    <style>
        :root { --md-surface: #f1ecf4; }
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

        /* MD3 outlined text field (light) */
        .md-field { position: relative; }
        .md-field input,
        .md-field select,
        .md-field textarea {
            width: 100%; padding: 16px;
            background: transparent;
            border: 1px solid #7a7289;
            border-radius: 4px;
            color: #1c1b1f;
            font-size: 16px;
            font-family: inherit;
            outline: none;
            transition: border-color 150ms, border-width 150ms;
            appearance: none; -webkit-appearance: none;
        }
        .md-field input:focus,
        .md-field select:focus,
        .md-field textarea:focus {
            border-color: #6d2ef5;
            border-width: 2px;
        }
        .md-field input:disabled,
        .md-field select:disabled,
        .md-field textarea:disabled {
            border-color: rgba(122,114,137,0.38);
            color: rgba(28,27,31,0.38);
            cursor: not-allowed;
        }
        .md-field label {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%);
            font-size: 16px; color: #49454e;
            pointer-events: none;
            transition: all 150ms;
            background: var(--md-surface);
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
            color: #6d2ef5;
        }
        /* Date input always shows the label at top */
        .md-field input[type="date"] ~ label { top: 0; font-size: 12px; }
        .md-field input[type="date"]:focus ~ label { color: #6d2ef5; }
        /* Select option styling */
        .md-field select option { background: #f1ecf4; color: #1c1b1f; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cac4d0; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #7a7289; }
    </style>
</head>
<body class="min-h-screen bg-surface-container-low font-sans antialiased text-on-surface">

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