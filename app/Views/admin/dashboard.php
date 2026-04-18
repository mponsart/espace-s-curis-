<section class="space-y-6">
    <?php require app()->basePath('app/Views/partials/flash.php'); ?>

    <!-- ── Greeting banner ──────────────────────────────────────────────── -->
    <div class="relative overflow-hidden rounded-xl bg-primary-container px-6 py-6 shadow-elev1">
        <!-- Decorative circles -->
        <div class="pointer-events-none absolute -right-10 -top-10 h-48 w-48 rounded-full bg-primary/10"></div>
        <div class="pointer-events-none absolute -bottom-8 right-24 h-32 w-32 rounded-full bg-primary/8"></div>

        <p class="text-xs font-semibold uppercase tracking-widest text-on-primary-container/70">Administration</p>
        <h2 class="mt-2 text-2xl font-bold text-on-primary-container sm:text-3xl">
            Bonjour, <?= e($user['name']) ?> 👋
        </h2>
        <p class="mt-2 max-w-xl text-sm text-on-primary-container/80 leading-relaxed">
            Gérez les invitations, suivez les réponses et exportez les fiches bénévoles depuis cet espace sécurisé.
        </p>
    </div>

    <!-- ── Stat + quick-action cards ────────────────────────────────────── -->
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

        <!-- Stat card -->
        <article class="flex flex-col gap-4 rounded-xl bg-surface-container-lowest px-6 py-5 shadow-elev1"
                 aria-label="Statistique bénévoles">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-on-surface-variant">Total bénévoles</p>
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-secondary-container text-on-secondary-container">
                    <span class="material-symbols-rounded text-xl"
                          style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 20">group</span>
                </span>
            </div>
            <p class="text-5xl font-bold text-on-surface tracking-tight">
                <?= e((string) $totalVolunteers) ?>
            </p>
        </article>

        <!-- Invite card -->
        <article class="flex flex-col justify-between gap-6 rounded-xl bg-surface-container-lowest px-6 py-5 shadow-elev1">
            <div>
                <p class="text-sm font-medium text-on-surface-variant">Invitations</p>
                <p class="mt-1 text-base font-semibold text-on-surface">Invitez de nouveaux bénévoles</p>
            </div>
            <a href="<?= e(url('invite.php')) ?>"
               class="state-layer inline-flex items-center gap-2 self-start rounded-full bg-primary px-5 py-2.5
                      text-sm font-semibold text-on-primary shadow-elev1 transition-shadow hover:shadow-elev2">
                <span class="material-symbols-rounded text-lg">add_link</span>
                Créer un lien
            </a>
        </article>

        <!-- Export card -->
        <article class="flex flex-col justify-between gap-6 rounded-xl bg-surface-container-lowest px-6 py-5 shadow-elev1">
            <div>
                <p class="text-sm font-medium text-on-surface-variant">Export</p>
                <p class="mt-1 text-base font-semibold text-on-surface">Télécharger les fiches</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="<?= e(url('export-volunteers.php')) ?>"
                   class="state-layer inline-flex items-center gap-2 rounded-full border border-outline
                          px-4 py-2 text-sm font-medium text-on-surface-variant hover:bg-on-surface/5">
                    <span class="material-symbols-rounded text-lg">table_view</span>
                    CSV
                </a>
                <a href="<?= e(url('export-volunteers-pdf.php')) ?>"
                   class="state-layer inline-flex items-center gap-2 rounded-full border border-outline
                          px-4 py-2 text-sm font-medium text-on-surface-variant hover:bg-on-surface/5">
                    <span class="material-symbols-rounded text-lg">picture_as_pdf</span>
                    PDF
                </a>
            </div>
        </article>
    </div>

    <!-- ── Recent volunteers ─────────────────────────────────────────────── -->
    <section class="rounded-xl bg-surface-container-lowest shadow-elev1 overflow-hidden">
        <div class="flex items-center justify-between gap-4 px-6 py-5 border-b border-outline-variant">
            <div>
                <h3 class="text-base font-semibold text-on-surface">Dernières fiches créées</h3>
                <p class="text-sm text-on-surface-variant">Aperçu des bénévoles les plus récents.</p>
            </div>
            <a href="<?= e(url('volunteers.php')) ?>"
               class="state-layer inline-flex items-center gap-1 rounded-full px-3 py-1.5 text-sm font-medium
                      text-primary hover:bg-primary/8">
                Voir tout
                <span class="material-symbols-rounded text-base">arrow_forward</span>
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm" role="table">
                <thead>
                    <tr class="bg-surface-container">
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Nom</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Créé le</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentVolunteers as $i => $volunteer): ?>
                    <tr class="border-t border-outline-variant transition-colors hover:bg-surface-container-low">
                        <td class="px-6 py-4 font-medium text-on-surface">
                            <?= e(trim(($volunteer['first_name'] ?? '') . ' ' . ($volunteer['last_name'] ?? ''))) ?: '<span class="text-on-surface-variant italic">Invitation en attente</span>' ?>
                        </td>
                        <td class="px-6 py-4 text-on-surface-variant"><?= e($volunteer['email']) ?></td>
                        <td class="px-6 py-4 text-on-surface-variant"><?= e($volunteer['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if ($recentVolunteers === []): ?>
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center">
                            <span class="material-symbols-rounded mx-auto mb-3 block text-4xl text-on-surface-variant/40"
                                  style="font-variation-settings:'FILL' 0,'wght' 300,'GRAD' 0,'opsz' 48">group</span>
                            <p class="text-sm text-on-surface-variant">Aucun bénévole pour le moment.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</section>