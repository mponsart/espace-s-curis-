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
                        accent: {
                            50: '#f4fbff',
                            100: '#def4ff',
                            500: '#0ea5e9',
                            700: '#0369a1',
                            950: '#082f49'
                        }
                    },
                    fontFamily: {
                        sans: ['Manrope', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 font-sans">
    <div class="flex min-h-screen flex-col lg:flex-row">
        <aside class="w-full bg-slate-950 px-6 py-8 text-slate-100 lg:min-h-screen lg:w-72">
            <div class="mb-8">
                <p class="text-sm uppercase tracking-[0.3em] text-sky-300">Admin</p>
                <h1 class="mt-3 text-2xl font-extrabold"><?= e(config('app.name')) ?></h1>
                <p class="mt-2 text-sm text-slate-400">Collecte sécurisée des informations bénévoles.</p>
            </div>

            <nav class="space-y-2">
                <a href="<?= e(url('dashboard.php')) ?>" class="block rounded-2xl px-4 py-3 text-sm font-semibold hover:bg-slate-800">Tableau de bord</a>
                <a href="<?= e(url('volunteers.php')) ?>" class="block rounded-2xl px-4 py-3 text-sm font-semibold hover:bg-slate-800">Bénévoles</a>
                <a href="<?= e(url('invite.php')) ?>" class="block rounded-2xl px-4 py-3 text-sm font-semibold hover:bg-slate-800">Créer un lien</a>
                <a href="<?= e(url('export-volunteers.php')) ?>" class="block rounded-2xl px-4 py-3 text-sm font-semibold hover:bg-slate-800">Exporter CSV</a>
            </nav>

            <?php $user = current_user(); ?>
            <?php if ($user !== null): ?>
                <div class="mt-10 rounded-3xl border border-slate-800 bg-slate-900/80 p-4">
                    <div class="flex items-center gap-3">
                        <img src="<?= e($user['avatar'] ?: 'https://placehold.co/96x96') ?>" alt="Avatar" class="h-12 w-12 rounded-2xl object-cover">
                        <div>
                            <p class="font-semibold"><?= e($user['name']) ?></p>
                            <p class="text-sm text-slate-400"><?= e($user['email']) ?></p>
                        </div>
                    </div>
                    <a href="<?= e(url('logout.php')) ?>" class="mt-4 inline-flex rounded-xl border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-200 hover:bg-slate-800">Se déconnecter</a>
                </div>
            <?php endif; ?>
        </aside>

        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-10 lg:py-10">
            <?= $content ?>
        </main>
    </div>
</body>
</html>