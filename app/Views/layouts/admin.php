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
<body class="min-h-screen bg-brand-50 text-brand-950 font-sans">
    <div class="flex min-h-screen flex-col lg:flex-row">
        <aside class="w-full bg-brand-950 px-6 py-8 text-brand-50 lg:min-h-screen lg:w-72">
            <div class="mb-8">
                <img src="<?= e(url('assets/images/cloudy.png')) ?>" alt="Logo" class="h-12 w-auto rounded-xl bg-white/10 p-1 ring-1 ring-white/20">
                <p class="text-sm uppercase tracking-[0.3em] text-brand-100">Admin</p>
                <h1 class="mt-3 text-2xl font-extrabold"><?= e(config('app.name')) ?></h1>
                <p class="mt-2 text-sm text-brand-100/75">Collecte sécurisée des informations bénévoles.</p>
            </div>

            <nav class="space-y-2">
                <a href="<?= e(url('dashboard.php')) ?>" class="block rounded-2xl px-4 py-3 text-sm font-semibold hover:bg-brand-900">Tableau de bord</a>
                <a href="<?= e(url('volunteers.php')) ?>" class="block rounded-2xl px-4 py-3 text-sm font-semibold hover:bg-brand-900">Bénévoles</a>
                <a href="<?= e(url('invite.php')) ?>" class="block rounded-2xl px-4 py-3 text-sm font-semibold hover:bg-brand-900">Créer un lien</a>
                <a href="<?= e(url('export-volunteers.php')) ?>" class="block rounded-2xl px-4 py-3 text-sm font-semibold hover:bg-brand-900">Exporter CSV</a>
                <a href="<?= e(url('export-volunteers-pdf.php')) ?>" class="block rounded-2xl px-4 py-3 text-sm font-semibold hover:bg-brand-900">Exporter PDF</a>
            </nav>

            <?php $user = current_user(); ?>
            <?php if ($user !== null): ?>
                <div class="mt-10 rounded-3xl border border-brand-900 bg-brand-900/80 p-4">
                    <div class="flex items-center gap-3">
                        <img src="<?= e($user['avatar'] ?: 'https://placehold.co/96x96') ?>" alt="Avatar" class="h-12 w-12 rounded-2xl object-cover">
                        <div>
                            <p class="font-semibold"><?= e($user['name']) ?></p>
                            <p class="text-sm text-brand-100/70"><?= e($user['email']) ?></p>
                        </div>
                    </div>
                    <a href="<?= e(url('logout.php')) ?>" class="mt-4 inline-flex rounded-xl border border-brand-700 px-4 py-2 text-sm font-semibold text-brand-50 hover:bg-brand-700">Se déconnecter</a>
                </div>
            <?php endif; ?>
        </aside>

        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-10 lg:py-10">
            <?= $content ?>
        </main>
    </div>
</body>
</html>