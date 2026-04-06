<section class="space-y-6">
    <?php require app()->basePath('app/Views/partials/flash.php'); ?>

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900">Bénévoles</h2>
            <p class="mt-2 text-sm text-slate-500">Liste complète des invitations et des réponses reçues.</p>
        </div>
        <a href="<?= e(url('invite.php')) ?>" class="inline-flex rounded-2xl bg-brand-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-700/30 hover:bg-brand-700">Créer un lien</a>
    </div>

    <div class="overflow-hidden rounded-[2rem] bg-white shadow-sm ring-1 ring-slate-200">
        <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-4 py-3 font-semibold">Statut</th>
                    <th class="px-4 py-3 font-semibold">Nom</th>
                    <th class="px-4 py-3 font-semibold">Email</th>
                    <th class="px-4 py-3 font-semibold">Expiration</th>
                    <th class="px-4 py-3 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                <?php foreach ($volunteers as $volunteer): ?>
                    <tr>
                        <td class="px-4 py-4">
                            <?php if ((int) $volunteer['is_completed'] === 1): ?>
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">Complété</span>
                            <?php else: ?>
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">En attente</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-4 font-medium text-slate-900"><?= e(trim(($volunteer['first_name'] ?? '') . ' ' . ($volunteer['last_name'] ?? ''))) ?: 'Invitation en attente' ?></td>
                        <td class="px-4 py-4 text-slate-600"><?= e($volunteer['email']) ?></td>
                        <td class="px-4 py-4 text-slate-600"><?= e($volunteer['token_expires_at']) ?></td>
                        <td class="px-4 py-4">
                            <div class="flex flex-wrap gap-2">
                                <a href="<?= e(url('volunteer.php?id=' . (int) $volunteer['id'])) ?>" class="rounded-xl border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100">Voir</a>
                                <form method="post" action="<?= e(url('delete-volunteer.php')) ?>" onsubmit="return confirm('Supprimer cette fiche ?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= e((string) $volunteer['id']) ?>">
                                    <button type="submit" class="rounded-xl border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if ($volunteers === []): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-slate-500">Aucune fiche bénévole pour l'instant.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($pagination['pages'] > 1): ?>
        <nav class="flex items-center justify-center gap-2">
            <?php for ($page = 1; $page <= $pagination['pages']; $page++): ?>
                <a href="?page=<?= e((string) $page) ?>" class="rounded-xl px-4 py-2 text-sm font-semibold <?= $page === $pagination['page'] ? 'bg-brand-900 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-brand-50' ?>">
                    <?= e((string) $page) ?>
                </a>
            <?php endfor; ?>
        </nav>
    <?php endif; ?>
</section>