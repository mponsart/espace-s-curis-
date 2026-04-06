<section class="grid gap-6 xl:grid-cols-[minmax(0,1.15fr)_minmax(320px,0.85fr)]">
    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-brand-100 sm:p-8">
        <?php require app()->basePath('app/Views/partials/flash.php'); ?>
        <p class="text-sm uppercase tracking-[0.28em] text-brand-700">Invitation</p>
        <h2 class="mt-3 text-3xl font-extrabold text-slate-900">Envoyer une invitation sécurisée</h2>
        <p class="mt-3 max-w-2xl text-sm text-slate-600">Saisissez l'adresse e-mail du bénévole pour envoyer automatiquement une invitation valable 7 jours. Le lien reste privé et n'est jamais affiché en clair dans l'interface.</p>

        <form method="post" class="mt-8 rounded-3xl border border-slate-200 bg-slate-50/80 p-5 sm:p-6">
            <?= csrf_field() ?>
            <div class="space-y-5">
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Adresse e-mail du bénévole</label>
                    <input id="email" name="email" type="email" value="<?= e((string) old('email')) ?>" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none ring-0 transition focus:border-brand-500 focus:shadow-[0_0_0_4px_rgba(138,77,253,0.15)]" placeholder="prenom.nom@exemple.com">
                </div>
                <button type="submit" class="inline-flex items-center rounded-2xl bg-brand-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-700/30 transition hover:bg-brand-700">Envoyer l'invitation</button>
            </div>
        </form>
    </div>

    <aside class="rounded-[2rem] bg-gradient-to-br from-brand-950 via-brand-900 to-brand-700 p-6 text-slate-100 shadow-sm">
        <h3 class="text-xl font-bold">Sécurité de l'invitation</h3>
        <p class="mt-2 text-sm text-brand-100/90">Le lien n'est jamais affiché en clair. Il est envoyé directement au bénéficiaire par e-mail.</p>

        <div class="mt-6 space-y-3 rounded-2xl border border-brand-900 bg-brand-950/70 p-5 text-sm text-brand-100/90">
            <p>• Lien personnel et temporaire</p>
            <p>• Validité limitée à 7 jours</p>
            <p>• Accès protégé par un jeton unique</p>
            <p>• Envoi automatique par e-mail</p>
        </div>
    </aside>
</section>