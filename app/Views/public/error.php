<section class="w-full max-w-2xl rounded-[2rem] border border-rose-400/20 bg-slate-900/80 p-8 text-center shadow-2xl backdrop-blur">
    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-rose-500/15 text-3xl text-rose-300">!</div>
    <h1 class="mt-6 text-3xl font-extrabold text-white">Erreur</h1>
    <p class="mt-3 text-sm text-slate-300"><?= e($message ?? 'Une erreur est survenue.') ?></p>
    <a href="<?= e(url('auth.php')) ?>" class="mt-8 inline-flex rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-100">Retour</a>
</section>