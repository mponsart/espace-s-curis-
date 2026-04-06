<section class="w-full max-w-2xl rounded-[2rem] border border-brand-100/20 bg-brand-950/80 p-8 text-center shadow-2xl shadow-brand-950/40 backdrop-blur">
    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-brand-500/15 text-3xl text-brand-100">!</div>
    <h1 class="mt-6 text-3xl font-extrabold text-white">Erreur</h1>
    <p class="mt-3 text-sm text-brand-100/90"><?= e($message ?? 'Une erreur est survenue.') ?></p>
    <a href="<?= e(url('auth.php')) ?>" class="mt-8 inline-flex rounded-2xl bg-brand-100 px-5 py-3 text-sm font-semibold text-brand-950 hover:bg-white">Retour</a>
</section>