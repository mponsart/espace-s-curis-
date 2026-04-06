<section class="space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900">Fiche bénévole</h2>
            <p class="mt-2 text-sm text-slate-500">Détail des informations collectées.</p>
        </div>
        <a href="<?= e(url('volunteers.php')) ?>" class="rounded-2xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Retour à la liste</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h3 class="text-lg font-bold text-slate-900">État civil</h3>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Nom</dt><dd class="font-medium text-slate-900"><?= e($volunteer['last_name']) ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Prénom</dt><dd class="font-medium text-slate-900"><?= e($volunteer['first_name']) ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Genre</dt><dd class="font-medium text-slate-900"><?= e($volunteer['gender']) ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Date de naissance</dt><dd class="font-medium text-slate-900"><?= e($volunteer['birth_date']) ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Lieu de naissance</dt><dd class="font-medium text-slate-900"><?= e($volunteer['birth_place']) ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Nationalité</dt><dd class="font-medium text-slate-900"><?= e($volunteer['nationality']) ?></dd></div>
            </dl>
        </section>

        <section class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h3 class="text-lg font-bold text-slate-900">Coordonnées</h3>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Email</dt><dd class="font-medium text-slate-900"><?= e($volunteer['email']) ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Téléphone</dt><dd class="font-medium text-slate-900"><?= e($volunteer['phone']) ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Ville</dt><dd class="font-medium text-slate-900"><?= e($volunteer['city']) ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Code postal</dt><dd class="font-medium text-slate-900"><?= e($volunteer['postal_code']) ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Adresse</dt><dd class="font-medium text-slate-900"><?= nl2br(e($volunteer['address'])) ?></dd></div>
            </dl>
        </section>

        <section class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h3 class="text-lg font-bold text-slate-900">Contact d'urgence</h3>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Nom</dt><dd class="font-medium text-slate-900"><?= e($volunteer['emergency_name']) ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Téléphone</dt><dd class="font-medium text-slate-900"><?= e($volunteer['emergency_phone']) ?></dd></div>
            </dl>
        </section>

        <section class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h3 class="text-lg font-bold text-slate-900">Sécurité et RGPD</h3>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Jeton</dt><dd class="max-w-[16rem] break-all font-medium text-slate-900"><?= e($volunteer['token']) ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Expire le</dt><dd class="font-medium text-slate-900"><?= e($volunteer['token_expires_at']) ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Consentement</dt><dd class="font-medium text-slate-900"><?= (int) $volunteer['consent_rgpd'] === 1 ? 'Oui' : 'Non' ?></dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500">Créé le</dt><dd class="font-medium text-slate-900"><?= e($volunteer['created_at']) ?></dd></div>
            </dl>
        </section>
    </div>
</section>