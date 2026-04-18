<section class="space-y-6">
    <?php require app()->basePath('app/Views/partials/flash.php'); ?>

    <!-- ── Page header ──────────────────────────────────────────────────── -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-on-surface">Bénévoles</h2>
            <p class="mt-1 text-sm text-on-surface-variant">Liste complète des invitations et des réponses reçues.</p>
        </div>
        <!-- FAB / Primary action -->
        <a href="<?= e(url('invite.php')) ?>"
           class="state-layer inline-flex items-center gap-2 self-start rounded-xl bg-primary px-5 py-3
                  text-sm font-semibold text-on-primary shadow-elev2 transition-shadow hover:shadow-elev3 sm:self-auto">
            <span class="material-symbols-rounded text-xl">add_link</span>
            Créer un lien
        </a>
    </div>

    <!-- ── Data table ────────────────────────────────────────────────────── -->
    <div class="overflow-hidden rounded-xl bg-surface-container-lowest shadow-elev1">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm" role="table">
                <thead>
                    <tr class="bg-surface-container border-b border-outline-variant">
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Statut</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Nom</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Expiration</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($volunteers as $volunteer): ?>
                    <tr class="border-t border-outline-variant transition-colors hover:bg-surface-container-low">
                        <td class="px-6 py-4">
                            <?php if ((int) $volunteer['is_completed'] === 1): ?>
                                <!-- Completed chip -->
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-success-container px-3 py-1 text-xs font-semibold text-on-success-container">
                                    <span class="material-symbols-rounded text-sm"
                                          style="font-variation-settings:'FILL' 1,'wght' 600,'GRAD' 0,'opsz' 20">check_circle</span>
                                    Complété
                                </span>
                            <?php else: ?>
                                <!-- Pending chip -->
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-tertiary-container px-3 py-1 text-xs font-semibold text-on-tertiary-container">
                                    <span class="material-symbols-rounded text-sm"
                                          style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 20">schedule</span>
                                    En attente
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 font-medium text-on-surface">
                            <?php $name = trim(($volunteer['first_name'] ?? '') . ' ' . ($volunteer['last_name'] ?? '')); ?>
                            <?php if ($name !== ''): ?>
                                <?= e($name) ?>
                            <?php else: ?>
                                <span class="italic text-on-surface-variant">Invitation en attente</span>
                            <?php endif; ?></td>
                        <td class="px-6 py-4 text-on-surface-variant"><?= e($volunteer['email']) ?></td>
                        <td class="px-6 py-4 text-on-surface-variant"><?= e($volunteer['token_expires_at']) ?></td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="<?= e(url('volunteer.php?id=' . (int) $volunteer['id'])) ?>"
                                   class="state-layer inline-flex items-center gap-1.5 rounded-full border border-outline
                                          px-3 py-1.5 text-xs font-medium text-on-surface-variant hover:bg-on-surface/5"
                                   aria-label="Voir la fiche de <?= e(trim(($volunteer['first_name'] ?? '') . ' ' . ($volunteer['last_name'] ?? ''))) ?: 'ce bénévole' ?>">
                                    <span class="material-symbols-rounded text-sm">visibility</span>
                                    Voir
                                </a>
                                <form method="post"
                                      action="<?= e(url('delete-volunteer.php')) ?>"
                                      onsubmit="return confirm('Supprimer cette fiche définitivement ?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= e((string) $volunteer['id']) ?>">
                                    <button type="submit"
                                            class="state-layer inline-flex items-center gap-1.5 rounded-full border border-error-container
                                                   px-3 py-1.5 text-xs font-medium text-error hover:bg-error/8"
                                            aria-label="Supprimer la fiche de <?= e(trim(($volunteer['first_name'] ?? '') . ' ' . ($volunteer['last_name'] ?? ''))) ?: 'ce bénévole' ?>">
                                        <span class="material-symbols-rounded text-sm">delete</span>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if ($volunteers === []): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-14 text-center">
                            <span class="material-symbols-rounded mx-auto mb-3 block text-5xl text-on-surface-variant/30"
                                  style="font-variation-settings:'FILL' 0,'wght' 300,'GRAD' 0,'opsz' 48">group</span>
                            <p class="text-sm text-on-surface-variant">Aucune fiche bénévole pour l'instant.</p>
                            <a href="<?= e(url('invite.php')) ?>"
                               class="state-layer mt-4 inline-flex items-center gap-2 rounded-full bg-primary px-4 py-2
                                      text-sm font-medium text-on-primary">
                                <span class="material-symbols-rounded text-lg">add_link</span>
                                Envoyer une invitation
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ── Pagination ───────────────────────────────────────────────────── -->
    <?php if ($pagination['pages'] > 1): ?>
    <nav class="flex items-center justify-center gap-1" aria-label="Pagination">
        <?php for ($page = 1; $page <= $pagination['pages']; $page++): ?>
        <a href="?page=<?= e((string) $page) ?>"
           class="state-layer flex h-10 min-w-[40px] items-center justify-center rounded-full px-3
                  text-sm font-medium transition-colors
                  <?= $page === $pagination['page']
                        ? 'bg-primary text-on-primary shadow-elev1'
                        : 'text-on-surface-variant hover:bg-on-surface/8' ?>"
           <?= $page === $pagination['page'] ? 'aria-current="page"' : '' ?>
           aria-label="Page <?= e((string) $page) ?>">
            <?= e((string) $page) ?>
        </a>
        <?php endfor; ?>
    </nav>
    <?php endif; ?>
</section>