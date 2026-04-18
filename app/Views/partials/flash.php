<?php $success = flash('success'); ?>
<?php $error = flash('error'); ?>

<?php if ($success): ?>
    <div role="status" aria-live="polite"
         class="mb-6 flex items-start gap-3 rounded-lg bg-success-container px-4 py-3 text-on-success-container shadow-elev1">
        <span class="material-symbols-rounded shrink-0 sym-filled text-xl mt-0.5"
              style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 20">check_circle</span>
        <p class="text-sm font-medium"><?= e($success) ?></p>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div role="alert" aria-live="assertive"
         class="mb-6 flex items-start gap-3 rounded-lg bg-error-container px-4 py-3 text-on-error-container shadow-elev1">
        <span class="material-symbols-rounded shrink-0 text-xl mt-0.5"
              style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 20">error</span>
        <p class="text-sm font-medium"><?= e($error) ?></p>
    </div>
<?php endif; ?>