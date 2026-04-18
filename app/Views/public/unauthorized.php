<div class="w-full max-w-sm rounded-xl bg-surface-container shadow-elev3 overflow-hidden">
    <!-- Icon header -->
    <div class="flex flex-col items-center gap-3 bg-surface-container-high px-6 pt-8 pb-6 text-center border-b border-outline-variant">
        <span class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-container">
            <span class="material-symbols-rounded text-4xl text-on-primary-container"
                  style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 48">lock</span>
        </span>
        <p class="text-xs font-semibold uppercase tracking-widest text-on-surface-variant">Accès refusé</p>
        <h1 class="text-lg font-bold text-on-surface leading-snug">
            Vous n'êtes pas autorisé à accéder à la plateforme
        </h1>
    </div>

    <!-- Body -->
    <div class="px-6 py-5 space-y-4">
        <p class="text-sm text-on-surface-variant leading-relaxed">
            Votre compte Google n'est pas autorisé pour l'espace d'administration.
        </p>

        <!-- Contact info card -->
        <div class="flex items-start gap-3 rounded-lg bg-primary-container/30 border border-primary-container px-4 py-3">
            <span class="material-symbols-rounded text-xl text-primary shrink-0 mt-0.5"
                  style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24">info</span>
            <p class="text-sm text-on-surface">
                Pour demander l'accès, merci de contacter
                <span class="font-semibold text-on-surface">Maxime PONSART</span>.
            </p>
        </div>

        <a href="<?= e(url('auth.php')) ?>"
           class="state-layer mt-2 flex items-center justify-center gap-2 rounded-full bg-primary px-6 py-3
                  text-sm font-semibold text-on-primary shadow-elev1 transition-shadow hover:shadow-elev2">
            <span class="material-symbols-rounded text-xl">arrow_back</span>
            Revenir à la connexion
        </a>
    </div>
</div>
