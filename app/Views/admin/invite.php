<section class="grid gap-6 xl:grid-cols-[minmax(0,1.15fr)_minmax(280px,0.85fr)]">

    <!-- ── Invite form card ─────────────────────────────────────────────── -->
    <div class="rounded-xl bg-surface-container-lowest shadow-elev1">
        <?php require app()->basePath('app/Views/partials/flash.php'); ?>

        <div class="border-b border-outline-variant px-6 py-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-primary">Invitation</p>
            <h2 class="mt-1 text-xl font-bold text-on-surface">Envoyer une invitation sécurisée</h2>
            <p class="mt-2 text-sm text-on-surface-variant leading-relaxed">
                Saisissez l'adresse e-mail du bénévole. Un lien privé valable 7 jours sera envoyé automatiquement.
            </p>
        </div>

        <form method="post" class="p-6 space-y-5" novalidate>
            <?= csrf_field() ?>

            <!-- MD3 Outlined text field (light theme) -->
            <div>
                <label for="email"
                       class="block text-sm font-medium text-on-surface-variant mb-2">
                    Adresse e-mail du bénévole
                </label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">
                        <span class="material-symbols-rounded text-xl">mail</span>
                    </span>
                    <input id="email"
                           name="email"
                           type="email"
                           value="<?= e((string) old('email')) ?>"
                           required
                           autocomplete="email"
                           class="w-full rounded-md border border-outline-variant bg-transparent py-3.5 pl-11 pr-4
                                  text-sm text-on-surface placeholder-on-surface-variant/60
                                  outline-none ring-0 transition
                                  focus:border-primary focus:ring-2 focus:ring-primary/20
                                  hover:border-on-surface"
                           placeholder="prenom.nom@exemple.com">
                </div>
            </div>

            <button type="submit"
                    class="state-layer inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3
                           text-sm font-semibold text-on-primary shadow-elev1 transition-shadow hover:shadow-elev2">
                <span class="material-symbols-rounded text-xl">send</span>
                Envoyer l'invitation
            </button>
        </form>
    </div>

    <!-- ── Security info card ───────────────────────────────────────────── -->
    <aside class="rounded-xl bg-primary-container shadow-elev1 overflow-hidden"
           aria-label="Sécurité de l'invitation">
        <div class="px-6 py-5 border-b border-on-primary-container/10">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-on-primary-container/10">
                    <span class="material-symbols-rounded text-xl text-on-primary-container"
                          style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 20">shield_locked</span>
                </span>
                <h3 class="text-base font-semibold text-on-primary-container">Sécurité de l'invitation</h3>
            </div>
        </div>

        <div class="px-6 py-5 space-y-3 text-sm text-on-primary-container/80">
            <p class="text-on-primary-container/90">
                Le lien n'est jamais affiché en clair. Il est envoyé directement au bénéficiaire par e-mail.
            </p>

            <ul class="mt-4 space-y-3">
                <?php foreach ([
                    ['lock',        'Lien personnel et temporaire'],
                    ['timer',       'Validité limitée à 7 jours'],
                    ['key',         'Accès protégé par un jeton unique'],
                    ['forward_to_inbox', 'Envoi automatique par e-mail'],
                ] as [$icon, $text]): ?>
                <li class="flex items-center gap-3 rounded-lg bg-on-primary-container/8 px-4 py-3">
                    <span class="material-symbols-rounded text-xl text-on-primary-container shrink-0"
                          style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24">
                        <?= $icon ?>
                    </span>
                    <span class="text-on-primary-container font-medium"><?= $text ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </aside>
</section>