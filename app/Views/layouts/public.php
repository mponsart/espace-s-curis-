<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(($pageTitle ?? config('app.name')) . ' - ' . config('app.name')) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f1e7fd',
                            100: '#d8bdfa',
                            500: '#8a4dfd',
                            700: '#592aa9',
                            900: '#290654',
                            950: '#130326'
                        }
                    },
                    fontFamily: {
                        sans: ['Titillium Web', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-brand-950 text-brand-50 font-sans">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,_rgba(138,77,253,0.32),_transparent_35%),radial-gradient(circle_at_bottom_right,_rgba(216,189,250,0.24),_transparent_40%)]"></div>
    <main class="mx-auto flex min-h-screen w-full max-w-6xl flex-col items-center justify-center gap-6 px-4 py-10 sm:px-6 lg:px-8">
        <img src="<?= e(url('assets/images/cloudy.png')) ?>" alt="Logo" class="h-14 w-auto rounded-xl bg-white/10 p-1 ring-1 ring-white/20">
        <?= $content ?>
    </main>
</body>
</html>