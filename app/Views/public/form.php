<div class="w-full max-w-4xl">

    <!-- ── Status banners ───────────────────────────────────────────────── -->
    <?php $flashSuccess = flash('success'); ?>
    <?php if ($saved && $flashSuccess): ?>
        <div role="status" aria-live="polite"
             class="mb-6 flex items-start gap-3 rounded-lg bg-success-container px-4 py-3 text-on-success-container shadow-elev1">
            <span class="material-symbols-rounded shrink-0 text-xl mt-0.5"
                  style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 20">check_circle</span>
            <p class="text-sm font-medium"><?= e($flashSuccess) ?></p>
        </div>
    <?php endif; ?>

    <?php $flashError = flash('error'); ?>
    <?php if ($flashError): ?>
        <div role="alert" aria-live="assertive"
             class="mb-6 flex items-start gap-3 rounded-lg bg-error-container px-4 py-3 text-on-error-container shadow-elev1">
            <span class="material-symbols-rounded shrink-0 text-xl mt-0.5"
                  style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 20">error</span>
            <p class="text-sm font-medium"><?= e($flashError) ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($locked)): ?>
        <div class="mb-6 flex items-start gap-3 rounded-lg bg-surface-container-high border border-outline-variant px-4 py-3 text-on-surface shadow-elev1">
            <span class="material-symbols-rounded shrink-0 text-xl mt-0.5 text-primary"
                  style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 20">lock</span>
            <div>
                <p class="text-sm font-semibold text-on-surface">Formulaire verrouillé</p>
                <p class="text-sm text-on-surface-variant mt-0.5">
                    Vos informations sont désormais verrouillées<?= !empty($validatedAt) ? ' (validation : ' . e((string) $validatedAt) . ').' : '.' ?>
                </p>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($errors !== []): ?>
        <div role="alert"
             class="mb-6 rounded-lg bg-error-container px-4 py-3 text-on-error-container shadow-elev1">
            <p class="text-sm font-semibold flex items-center gap-2">
                <span class="material-symbols-rounded text-xl"
                      style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 20">error</span>
                Veuillez corriger les erreurs suivantes :
            </p>
            <ul class="mt-2 list-disc pl-8 text-sm space-y-1">
                <?php foreach ($errors as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- ── Main card ────────────────────────────────────────────────────── -->
    <div class="rounded-xl bg-surface-container overflow-hidden shadow-elev3">

        <!-- Card header -->
        <div class="bg-primary-container px-6 py-6 sm:px-8">
            <p class="text-xs font-semibold uppercase tracking-widest text-on-primary-container/70">Formulaire public</p>
            <h1 class="mt-1 text-2xl font-bold text-on-primary-container">Informations bénévoles</h1>
            <p class="mt-2 text-sm text-on-primary-container/80 leading-relaxed max-w-xl">
                Complétez ce formulaire en une seule fois. Vos données sont protégées et utilisées uniquement pour la gestion de votre engagement bénévole.
            </p>
        </div>

        <!-- Form body -->
        <div class="px-6 py-6 sm:px-8">
            <?php
                $disabledAttr  = !empty($locked) ? 'disabled' : '';
                $disabledClass = !empty($locked) ? ' opacity-50 pointer-events-none' : '';
            ?>

            <form method="post" class="space-y-8" novalidate>
                <?= csrf_field() ?>
                <input type="hidden" name="token" value="<?= e($token) ?>">

                <!-- ── Identity ─────────────────────────────────────────── -->
                <fieldset>
                    <legend class="flex items-center gap-2 text-sm font-semibold text-on-surface mb-4">
                        <span class="material-symbols-rounded text-lg text-primary"
                              style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24">badge</span>
                        État civil
                    </legend>
                    <div class="grid gap-4 sm:grid-cols-2<?= $disabledClass ?>">
                        <div class="md-field">
                            <input id="last_name" name="last_name"
                                   value="<?= e((string) $values['last_name']) ?>"
                                   required <?= $disabledAttr ?> placeholder=" ">
                            <label for="last_name">Nom</label>
                        </div>
                        <div class="md-field">
                            <input id="first_name" name="first_name"
                                   value="<?= e((string) $values['first_name']) ?>"
                                   required <?= $disabledAttr ?> placeholder=" ">
                            <label for="first_name">Prénom</label>
                        </div>
                        <div class="md-field">
                            <select id="gender" name="gender" <?= $disabledAttr ?>>
                                <option value="" disabled <?= $values['gender'] === '' ? 'selected' : '' ?>>Sélectionner</option>
                                <option value="female"            <?= $values['gender'] === 'female'            ? 'selected' : '' ?>>Femme</option>
                                <option value="male"              <?= $values['gender'] === 'male'              ? 'selected' : '' ?>>Homme</option>
                                <option value="other"             <?= $values['gender'] === 'other'             ? 'selected' : '' ?>>Autre</option>
                                <option value="prefer_not_to_say" <?= $values['gender'] === 'prefer_not_to_say' ? 'selected' : '' ?>>Préfère ne pas répondre</option>
                            </select>
                            <label for="gender">Genre</label>
                        </div>
                        <div class="md-field">
                            <input id="birth_date" name="birth_date" type="date"
                                   value="<?= e((string) $values['birth_date']) ?>"
                                   <?= $disabledAttr ?>>
                            <label for="birth_date">Date de naissance</label>
                        </div>
                        <div class="md-field">
                            <input id="birth_place" name="birth_place"
                                   value="<?= e((string) $values['birth_place']) ?>"
                                   <?= $disabledAttr ?> placeholder=" ">
                            <label for="birth_place">Lieu de naissance</label>
                        </div>
                        <div class="md-field">
                            <input id="nationality" name="nationality"
                                   value="<?= e((string) $values['nationality']) ?>"
                                   <?= $disabledAttr ?> placeholder=" ">
                            <label for="nationality">Nationalité</label>
                        </div>
                    </div>
                </fieldset>

                <div class="h-px bg-outline-variant"></div>

                <!-- ── Contact ──────────────────────────────────────────── -->
                <fieldset>
                    <legend class="flex items-center gap-2 text-sm font-semibold text-on-surface mb-4">
                        <span class="material-symbols-rounded text-lg text-primary"
                              style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24">contact_mail</span>
                        Coordonnées
                    </legend>
                    <div class="grid gap-4 sm:grid-cols-2<?= $disabledClass ?>">
                        <div class="md-field sm:col-span-2">
                            <input id="email" name="email" type="email"
                                   value="<?= e((string) $values['email']) ?>"
                                   required <?= $disabledAttr ?> placeholder=" ">
                            <label for="email">E-mail</label>
                        </div>
                        <div class="md-field sm:col-span-2">
                            <textarea id="address" name="address"
                                      rows="3" <?= $disabledAttr ?>
                                      placeholder=" "><?= e((string) $values['address']) ?></textarea>
                            <label for="address">Adresse</label>
                        </div>
                        <div class="md-field">
                            <input id="postal_code" name="postal_code"
                                   value="<?= e((string) $values['postal_code']) ?>"
                                   <?= $disabledAttr ?> placeholder=" ">
                            <label for="postal_code">Code postal</label>
                        </div>
                        <div class="md-field">
                            <input id="city" name="city"
                                   value="<?= e((string) $values['city']) ?>"
                                   <?= $disabledAttr ?> placeholder=" ">
                            <label for="city">Ville</label>
                        </div>
                        <div class="md-field sm:col-span-2 sm:max-w-xs">
                            <input id="phone" name="phone" type="tel"
                                   value="<?= e((string) $values['phone']) ?>"
                                   <?= $disabledAttr ?> placeholder=" ">
                            <label for="phone">Téléphone</label>
                        </div>
                    </div>
                </fieldset>

                <div class="h-px bg-outline-variant"></div>

                <!-- ── Emergency contact ────────────────────────────────── -->
                <fieldset>
                    <legend class="flex items-center gap-2 text-sm font-semibold text-on-surface mb-4">
                        <span class="material-symbols-rounded text-lg text-primary"
                              style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24">emergency</span>
                        Contact d'urgence
                    </legend>
                    <div class="grid gap-4 sm:grid-cols-2<?= $disabledClass ?>">
                        <div class="md-field">
                            <input id="emergency_name" name="emergency_name"
                                   value="<?= e((string) $values['emergency_name']) ?>"
                                   <?= $disabledAttr ?> placeholder=" ">
                            <label for="emergency_name">Nom du contact</label>
                        </div>
                        <div class="md-field">
                            <input id="emergency_phone" name="emergency_phone" type="tel"
                                   value="<?= e((string) $values['emergency_phone']) ?>"
                                   <?= $disabledAttr ?> placeholder=" ">
                            <label for="emergency_phone">Téléphone d'urgence</label>
                        </div>
                    </div>
                </fieldset>

                <div class="h-px bg-outline-variant"></div>

                <!-- ── RGPD consent ──────────────────────────────────────── -->
                <div>
                    <label class="flex items-start gap-3 rounded-lg border border-outline-variant bg-surface-container-high px-4 py-4 cursor-pointer
                                  hover:bg-surface-container-highest transition-colors<?= $disabledClass ?>">
                        <input type="checkbox"
                               name="consent_rgpd"
                               value="1"
                               <?= (int) $values['consent_rgpd'] === 1 ? 'checked' : '' ?>
                               <?= $disabledAttr ?>
                               class="mt-0.5 h-5 w-5 shrink-0 rounded-sm accent-primary cursor-pointer">
                        <span class="text-sm text-on-surface leading-relaxed">
                            J'accepte le traitement de mes données personnelles pour la gestion de mon engagement bénévole conformément au RGPD.
                        </span>
                    </label>
                </div>

                <!-- ── Submit button ─────────────────────────────────────── -->
                <?php if (empty($locked)): ?>
                <div class="flex justify-end">
                    <button type="submit"
                            class="state-layer inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3
                                   text-sm font-semibold text-on-primary shadow-elev2 transition-shadow hover:shadow-elev3">
                        <span class="material-symbols-rounded text-xl">save</span>
                        Enregistrer mes informations
                    </button>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
