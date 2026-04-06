<section class="space-y-8">
    <?php require app()->basePath('app/Views/partials/flash.php'); ?>

    <div class="rounded-[2rem] bg-gradient-to-r from-brand-950 via-brand-900 to-brand-700 p-8 text-white shadow-xl shadow-brand-900/35">
        <p class="text-sm uppercase tracking-[0.35em] text-brand-100">Administration</p>
        <h2 class="mt-4 text-3xl font-extrabold sm:text-4xl">Bonjour <?= e($user['name']) ?></h2>
        <p class="mt-3 max-w-2xl text-sm text-slate-200 sm:text-base">Gérez les invitations, suivez les réponses et exportez les fiches bénévoles depuis un espace simple et sécurisé.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <article class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-medium text-slate-500">Total des bénévoles</p>
            <p class="mt-3 text-4xl font-extrabold text-slate-900"><?= e((string) $totalVolunteers) ?></p>
        </article>
        <article class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-medium text-slate-500">Invitations rapides</p>
            <a href="<?= e(url('invite.php')) ?>" class="mt-4 inline-flex rounded-2xl bg-brand-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-700/30 hover:bg-brand-700">Créer un lien d'invitation</a>
        </article>
        <article class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-medium text-slate-500">Export</p>
            <a href="<?= e(url('export-volunteers.php')) ?>" class="mt-4 inline-flex rounded-2xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Télécharger le CSV</a>
        </article>
    </div>

    <section class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h3 class="text-xl font-bold text-slate-900">Dernières fiches créées</h3>
                <p class="text-sm text-slate-500">Aperçu des fiches bénévoles les plus récentes.</p>
            </div>
            <a href="<?= e(url('volunteers.php')) ?>" class="text-sm font-semibold text-brand-700 hover:text-brand-900">Voir tout</a>
        </div>

        <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Nom</th>
                        <th class="px-4 py-3 font-semibold">Email</th>
                        <th class="px-4 py-3 font-semibold">Créé le</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php foreach ($recentVolunteers as $volunteer): ?>
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-900"><?= e(trim(($volunteer['first_name'] ?? '') . ' ' . ($volunteer['last_name'] ?? ''))) ?: 'Invitation en attente' ?></td>
                            <td class="px-4 py-3 text-slate-600"><?= e($volunteer['email']) ?></td>
                            <td class="px-4 py-3 text-slate-600"><?= e($volunteer['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($recentVolunteers === []): ?>
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-slate-500">Aucun bénévole pour le moment.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</section>