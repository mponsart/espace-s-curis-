<section class="space-y-6">

    <!-- ── Page header ──────────────────────────────────────────────────── -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-on-surface">Fiche bénévole</h2>
            <p class="mt-1 text-sm text-on-surface-variant">Détail des informations collectées.</p>
        </div>
        <a href="<?= e(url('volunteers.php')) ?>"
           class="state-layer inline-flex items-center gap-2 self-start rounded-full border border-outline
                  px-4 py-2.5 text-sm font-medium text-on-surface-variant hover:bg-on-surface/8 sm:self-auto">
            <span class="material-symbols-rounded text-lg">arrow_back</span>
            Retour à la liste
        </a>
    </div>

    <!-- ── Info cards grid ──────────────────────────────────────────────── -->
    <div class="grid gap-4 lg:grid-cols-2">

        <!-- État civil -->
        <section class="rounded-xl bg-surface-container-lowest shadow-elev1 overflow-hidden"
                 aria-labelledby="section-civil">
            <div class="flex items-center gap-3 border-b border-outline-variant bg-surface-container px-6 py-4">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary-container text-on-primary-container">
                    <span class="material-symbols-rounded text-xl"
                          style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 20">badge</span>
                </span>
                <h3 id="section-civil" class="text-sm font-semibold text-on-surface">État civil</h3>
            </div>
            <dl class="divide-y divide-outline-variant text-sm">
                <?php foreach ([
                    'Nom'              => $volunteer['last_name'],
                    'Prénom'           => $volunteer['first_name'],
                    'Genre'            => $volunteer['gender'],
                    'Date de naissance'=> $volunteer['birth_date'],
                    'Lieu de naissance'=> $volunteer['birth_place'],
                    'Nationalité'      => $volunteer['nationality'],
                ] as $label => $value): ?>
                <div class="flex items-center justify-between gap-4 px-6 py-3">
                    <dt class="text-on-surface-variant"><?= e($label) ?></dt>
                    <dd class="font-medium text-on-surface text-right"><?= e((string) ($value ?? '')) ?: '—' ?></dd>
                </div>
                <?php endforeach; ?>
            </dl>
        </section>

        <!-- Coordonnées -->
        <section class="rounded-xl bg-surface-container-lowest shadow-elev1 overflow-hidden"
                 aria-labelledby="section-contact">
            <div class="flex items-center gap-3 border-b border-outline-variant bg-surface-container px-6 py-4">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-secondary-container text-on-secondary-container">
                    <span class="material-symbols-rounded text-xl"
                          style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 20">contact_mail</span>
                </span>
                <h3 id="section-contact" class="text-sm font-semibold text-on-surface">Coordonnées</h3>
            </div>
            <dl class="divide-y divide-outline-variant text-sm">
                <?php foreach ([
                    'Email'       => $volunteer['email'],
                    'Téléphone'   => $volunteer['phone'],
                    'Ville'       => $volunteer['city'],
                    'Code postal' => $volunteer['postal_code'],
                ] as $label => $value): ?>
                <div class="flex items-center justify-between gap-4 px-6 py-3">
                    <dt class="text-on-surface-variant"><?= e($label) ?></dt>
                    <dd class="font-medium text-on-surface text-right"><?= e((string) ($value ?? '')) ?: '—' ?></dd>
                </div>
                <?php endforeach; ?>
                <div class="flex flex-col gap-1 px-6 py-3">
                    <dt class="text-on-surface-variant">Adresse</dt>
                    <dd class="font-medium text-on-surface"><?= nl2br(e((string) ($volunteer['address'] ?? ''))) ?: '—' ?></dd>
                </div>
            </dl>
        </section>

        <!-- Contact d'urgence -->
        <section class="rounded-xl bg-surface-container-lowest shadow-elev1 overflow-hidden"
                 aria-labelledby="section-emergency">
            <div class="flex items-center gap-3 border-b border-outline-variant bg-surface-container px-6 py-4">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-tertiary-container text-on-tertiary-container">
                    <span class="material-symbols-rounded text-xl"
                          style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 20">emergency</span>
                </span>
                <h3 id="section-emergency" class="text-sm font-semibold text-on-surface">Contact d'urgence</h3>
            </div>
            <dl class="divide-y divide-outline-variant text-sm">
                <?php foreach ([
                    'Nom'       => $volunteer['emergency_name'],
                    'Téléphone' => $volunteer['emergency_phone'],
                ] as $label => $value): ?>
                <div class="flex items-center justify-between gap-4 px-6 py-3">
                    <dt class="text-on-surface-variant"><?= e($label) ?></dt>
                    <dd class="font-medium text-on-surface text-right"><?= e((string) ($value ?? '')) ?: '—' ?></dd>
                </div>
                <?php endforeach; ?>
            </dl>
        </section>

        <!-- Sécurité & RGPD -->
        <section class="rounded-xl bg-surface-container-lowest shadow-elev1 overflow-hidden"
                 aria-labelledby="section-security">
            <div class="flex items-center gap-3 border-b border-outline-variant bg-surface-container px-6 py-4">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-error-container text-on-error-container">
                    <span class="material-symbols-rounded text-xl"
                          style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 20">security</span>
                </span>
                <h3 id="section-security" class="text-sm font-semibold text-on-surface">Sécurité et RGPD</h3>
            </div>
            <dl class="divide-y divide-outline-variant text-sm">
                <div class="flex items-center justify-between gap-4 px-6 py-3">
                    <dt class="text-on-surface-variant">Jeton</dt>
                    <dd class="font-medium text-on-surface-variant italic">Masqué pour des raisons de sécurité</dd>
                </div>
                <div class="flex items-center justify-between gap-4 px-6 py-3">
                    <dt class="text-on-surface-variant">Expire le</dt>
                    <dd class="font-medium text-on-surface text-right"><?= e($volunteer['token_expires_at']) ?></dd>
                </div>
                <div class="flex items-center justify-between gap-4 px-6 py-3">
                    <dt class="text-on-surface-variant">Consentement RGPD</dt>
                    <dd class="font-medium">
                        <?php if ((int) $volunteer['consent_rgpd'] === 1): ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-success-container px-2.5 py-0.5 text-xs font-semibold text-on-success-container">
                                <span class="material-symbols-rounded text-xs"
                                      style="font-variation-settings:'FILL' 1,'wght' 600,'GRAD' 0,'opsz' 20">check</span>
                                Oui
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-error-container px-2.5 py-0.5 text-xs font-semibold text-on-error-container">
                                Non
                            </span>
                        <?php endif; ?>
                    </dd>
                </div>
                <div class="flex items-center justify-between gap-4 px-6 py-3">
                    <dt class="text-on-surface-variant">Validé le</dt>
                    <dd class="font-medium text-on-surface text-right"><?= e($volunteer['validated_at'] ?? '') ?: '—' ?></dd>
                </div>
                <div class="flex items-center justify-between gap-4 px-6 py-3">
                    <dt class="text-on-surface-variant">Créé le</dt>
                    <dd class="font-medium text-on-surface text-right"><?= e($volunteer['created_at']) ?></dd>
                </div>
            </dl>
        </section>
    </div>
</section>
