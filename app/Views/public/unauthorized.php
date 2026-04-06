<section class="w-full max-w-2xl rounded-[2rem] border border-brand-100/25 bg-brand-950/80 p-6 text-brand-50 shadow-2xl shadow-brand-950/40 backdrop-blur sm:p-8">
    <p class="text-sm uppercase tracking-[0.35em] text-brand-100">Accès refusé</p>
    <h1 class="mt-4 text-3xl font-extrabold">Vous n'êtes pas autorisé à accéder à la plateforme</h1>
    <p class="mt-4 text-sm leading-7 text-brand-100/90 sm:text-base">
        Votre compte Google n'est pas autorisé pour l'espace d'administration.
    </p>

    <div class="mt-6 rounded-2xl border border-brand-100/35 bg-brand-900/40 p-4 text-sm text-brand-100">
        Pour demander l'accès, merci de contacter
        <span class="font-bold text-white">Maxime PONSART</span>.
    </div>

    <div class="mt-8">
        <a href="<?= e(url('auth.php')) ?>" class="inline-flex rounded-2xl bg-brand-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-900/50 transition hover:bg-brand-700">
            Revenir à la connexion
        </a>
    </div>
</section>
