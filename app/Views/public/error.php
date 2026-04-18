<div class="w-full max-w-sm rounded-xl bg-surface-container shadow-elev3 overflow-hidden text-center">
    <!-- Icon header -->
    <div class="flex flex-col items-center gap-3 bg-error-container px-6 pt-8 pb-6">
        <span class="flex h-16 w-16 items-center justify-center rounded-full bg-error/15">
            <span class="material-symbols-rounded text-4xl text-on-error-container"
                  style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 48">error</span>
        </span>
        <h1 class="text-xl font-bold text-on-error-container">Erreur</h1>
    </div>

    <!-- Body -->
    <div class="px-6 py-6 flex flex-col items-center gap-6">
        <p class="text-sm text-on-surface-variant leading-relaxed">
            <?= e($message ?? 'Une erreur est survenue.') ?>
        </p>
        <a href="<?= e(url('auth.php')) ?>"
           class="state-layer inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3
                  text-sm font-semibold text-on-primary shadow-elev1 transition-shadow hover:shadow-elev2">
            <span class="material-symbols-rounded text-xl">arrow_back</span>
            Retour
        </a>
    </div>
</div>