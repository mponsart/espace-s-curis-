<section class="grid gap-6 xl:grid-cols-[minmax(0,1.15fr)_minmax(320px,0.85fr)]">
    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-brand-100">
        <?php require app()->basePath('app/Views/partials/flash.php'); ?>
        <p class="text-sm uppercase tracking-[0.3em] text-brand-700">Invitation</p>
        <h2 class="mt-3 text-3xl font-extrabold text-slate-900">Créer un lien sécurisé</h2>
        <p class="mt-2 text-sm text-slate-500">Le lien est valable 7 jours et permet au bénévole de compléter son dossier sans compte local.</p>

        <form method="post" class="mt-8 space-y-5">
            <?= csrf_field() ?>
            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email du bénévole</label>
                <input id="email" name="email" type="email" value="<?= e((string) old('email')) ?>" required class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none ring-0 transition focus:border-brand-500">
            </div>
            <button type="submit" class="inline-flex rounded-2xl bg-brand-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-700/30 hover:bg-brand-700">Créer lien</button>
        </form>
    </div>

    <aside class="rounded-[2rem] bg-gradient-to-br from-brand-950 via-brand-900 to-brand-700 p-6 text-slate-100 shadow-sm">
        <h3 class="text-xl font-bold">Lien généré</h3>
        <p class="mt-2 text-sm text-brand-100/85">Copiez ce lien et transmettez-le au bénévole.</p>

        <?php if ($generatedLink !== null): ?>
            <div class="mt-6 rounded-2xl border border-brand-900 bg-brand-950/70 p-4">
                <p class="break-all text-sm text-brand-100"><?= e($generatedLink) ?></p>
            </div>
        <?php else: ?>
            <div class="mt-6 rounded-2xl border border-dashed border-brand-100/40 p-6 text-sm text-brand-100/80">
                Aucun lien généré pour le moment.
            </div>
        <?php endif; ?>
    </aside>
</section>