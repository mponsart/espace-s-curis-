<section class="w-full max-w-5xl rounded-[2rem] border border-brand-100/20 bg-brand-950/80 p-6 shadow-2xl shadow-brand-950/40 backdrop-blur sm:p-8">
    <div class="grid gap-8 lg:grid-cols-[0.8fr_minmax(0,1.2fr)]">
        <aside class="rounded-[2rem] bg-gradient-to-br from-brand-500 via-brand-700 to-brand-950 p-6 text-white">
            <p class="text-sm uppercase tracking-[0.35em] text-brand-100">Formulaire public</p>
            <h1 class="mt-4 text-3xl font-extrabold">Informations bénévoles</h1>
            <p class="mt-4 text-sm text-brand-100/90">Complétez ce formulaire en une seule fois. Vos données sont protégées et utilisées uniquement pour la gestion de votre engagement bénévole.</p>
            <div class="mt-8 rounded-2xl bg-white/10 p-4 text-sm text-brand-100">
                <p class="font-semibold">Sécurité</p>
                <p class="mt-2">Le lien d'invitation est unique, limité dans le temps et protégé côté serveur.</p>
            </div>
        </aside>

        <div>
            <?php $flashSuccess = flash('success'); ?>
            <?php if ($saved && $flashSuccess): ?>
                <div class="mb-6 rounded-2xl border border-emerald-300 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                    <?= e($flashSuccess) ?>
                </div>
            <?php endif; ?>

            <?php $flashError = flash('error'); ?>
            <?php if ($flashError): ?>
                <div class="mb-6 rounded-2xl border border-rose-300 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
                    <?= e($flashError) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($locked)): ?>
                <div class="mb-6 rounded-2xl border border-brand-100/30 bg-white/5 px-4 py-3 text-sm text-slate-100">
                    <p class="font-semibold">Formulaire validé</p>
                    <p class="mt-1 text-slate-200">Vos informations sont désormais verrouillées<?= !empty($validatedAt) ? ' (validation : ' . e((string) $validatedAt) . ').' : '.' ?></p>
                </div>
            <?php endif; ?>

            <?php if ($errors !== []): ?>
                <div class="mb-6 rounded-2xl border border-rose-300 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <p class="font-semibold">Veuillez corriger les erreurs suivantes :</p>
                    <ul class="mt-2 list-disc pl-5">
                        <?php foreach ($errors as $error): ?>
                            <li><?= e($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php
            $disabledAttr = !empty($locked) ? 'disabled' : '';
            $disabledClass = !empty($locked) ? ' opacity-60 cursor-not-allowed' : '';
            ?>

            <form method="post" class="space-y-6">
                <?= csrf_field() ?>
                <input type="hidden" name="token" value="<?= e($token) ?>">

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="last_name" class="mb-2 block text-sm font-semibold text-slate-200">Nom</label>
                        <input id="last_name" name="last_name" value="<?= e((string) $values['last_name']) ?>" required <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                    </div>
                    <div>
                        <label for="first_name" class="mb-2 block text-sm font-semibold text-slate-200">Prénom</label>
                        <input id="first_name" name="first_name" value="<?= e((string) $values['first_name']) ?>" required <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                    </div>
                    <div>
                        <label for="gender" class="mb-2 block text-sm font-semibold text-slate-200">Genre</label>
                        <select id="gender" name="gender" <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                            <option value="">Sélectionner</option>
                            <option value="female" <?= $values['gender'] === 'female' ? 'selected' : '' ?>>Femme</option>
                            <option value="male" <?= $values['gender'] === 'male' ? 'selected' : '' ?>>Homme</option>
                            <option value="other" <?= $values['gender'] === 'other' ? 'selected' : '' ?>>Autre</option>
                            <option value="prefer_not_to_say" <?= $values['gender'] === 'prefer_not_to_say' ? 'selected' : '' ?>>Préfère ne pas répondre</option>
                        </select>
                    </div>
                    <div>
                        <label for="birth_date" class="mb-2 block text-sm font-semibold text-slate-200">Date de naissance</label>
                        <input id="birth_date" name="birth_date" type="date" value="<?= e((string) $values['birth_date']) ?>" <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                    </div>
                    <div>
                        <label for="birth_place" class="mb-2 block text-sm font-semibold text-slate-200">Lieu de naissance</label>
                        <input id="birth_place" name="birth_place" value="<?= e((string) $values['birth_place']) ?>" <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                    </div>
                    <div>
                        <label for="nationality" class="mb-2 block text-sm font-semibold text-slate-200">Nationalité</label>
                        <input id="nationality" name="nationality" value="<?= e((string) $values['nationality']) ?>" <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-200">E-mail</label>
                        <input id="email" name="email" type="email" value="<?= e((string) $values['email']) ?>" required <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="address" class="mb-2 block text-sm font-semibold text-slate-200">Adresse</label>
                        <textarea id="address" name="address" rows="3" <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>"><?= e((string) $values['address']) ?></textarea>
                    </div>
                    <div>
                        <label for="postal_code" class="mb-2 block text-sm font-semibold text-slate-200">Code postal</label>
                        <input id="postal_code" name="postal_code" value="<?= e((string) $values['postal_code']) ?>" <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                    </div>
                    <div>
                        <label for="city" class="mb-2 block text-sm font-semibold text-slate-200">Ville</label>
                        <input id="city" name="city" value="<?= e((string) $values['city']) ?>" <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                    </div>
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-semibold text-slate-200">Téléphone</label>
                        <input id="phone" name="phone" value="<?= e((string) $values['phone']) ?>" <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                    </div>
                    <div></div>
                    <div>
                        <label for="emergency_name" class="mb-2 block text-sm font-semibold text-slate-200">Contact d'urgence</label>
                        <input id="emergency_name" name="emergency_name" value="<?= e((string) $values['emergency_name']) ?>" <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                    </div>
                    <div>
                        <label for="emergency_phone" class="mb-2 block text-sm font-semibold text-slate-200">Téléphone urgence</label>
                        <input id="emergency_phone" name="emergency_phone" value="<?= e((string) $values['emergency_phone']) ?>" <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-800 bg-white/5 p-5">
                    <h2 class="text-base font-bold text-slate-100">Informations complémentaires</h2>
                    <p class="mt-1 text-sm text-slate-200">Ces informations nous aident à vous positionner au mieux. (Optionnel)</p>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="tshirt_size" class="mb-2 block text-sm font-semibold text-slate-200">Taille de t-shirt</label>
                            <select id="tshirt_size" name="tshirt_size" <?= $disabledAttr ?> class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-brand-500<?= $disabledClass ?>">
                                <option value="">Sélectionner</option>
                                <?php foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size): ?>
                                    <option value="<?= e($size) ?>" <?= (string) ($values['tshirt_size'] ?? '') === $size ? 'selected' : '' ?>><?= e($size) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="flex flex-col justify-end gap-3">
                            <label class="flex items-start gap-3 rounded-2xl border border-slate-700 bg-slate-950 px-4 py-4 text-sm text-slate-200<?= $disabledClass ?>">
                                <input type="checkbox" name="has_driving_license" value="1" <?= (int) ($values['has_driving_license'] ?? 0) === 1 ? 'checked' : '' ?> <?= $disabledAttr ?> class="mt-1 h-4 w-4 rounded border-slate-600 text-brand-500 focus:ring-brand-400">
                                <span>J'ai le permis de conduire</span>
                            </label>
                            <label class="flex items-start gap-3 rounded-2xl border border-slate-700 bg-slate-950 px-4 py-4 text-sm text-slate-200<?= $disabledClass ?>">
                                <input type="checkbox" name="has_vehicle" value="1" <?= (int) ($values['has_vehicle'] ?? 0) === 1 ? 'checked' : '' ?> <?= $disabledAttr ?> class="mt-1 h-4 w-4 rounded border-slate-600 text-brand-500 focus:ring-brand-400">
                                <span>Je peux venir avec un véhicule</span>
                            </label>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="availability_notes" class="mb-2 block text-sm font-semibold text-slate-200">Disponibilités</label>
                            <textarea id="availability_notes" name="availability_notes" rows="3" <?= $disabledAttr ?> placeholder="Ex : soirs en semaine, samedi matin, du 10 au 12 mai..." class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none placeholder:text-slate-500 focus:border-brand-500<?= $disabledClass ?>"><?= e((string) ($values['availability_notes'] ?? '')) ?></textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="skills" class="mb-2 block text-sm font-semibold text-slate-200">Compétences / expériences</label>
                            <textarea id="skills" name="skills" rows="3" <?= $disabledAttr ?> placeholder="Ex : accueil, logistique, cuisine, secourisme, animation..." class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none placeholder:text-slate-500 focus:border-brand-500<?= $disabledClass ?>"><?= e((string) ($values['skills'] ?? '')) ?></textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="dietary_preferences" class="mb-2 block text-sm font-semibold text-slate-200">Régime alimentaire</label>
                            <input id="dietary_preferences" name="dietary_preferences" value="<?= e((string) ($values['dietary_preferences'] ?? '')) ?>" <?= $disabledAttr ?> placeholder="Ex : végétarien, sans porc, halal..." class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none placeholder:text-slate-500 focus:border-brand-500<?= $disabledClass ?>">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="allergies" class="mb-2 block text-sm font-semibold text-slate-200">Allergies (si applicable)</label>
                            <input id="allergies" name="allergies" value="<?= e((string) ($values['allergies'] ?? '')) ?>" <?= $disabledAttr ?> placeholder="Ex : arachides, gluten..." class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none placeholder:text-slate-500 focus:border-brand-500<?= $disabledClass ?>">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="notes" class="mb-2 block text-sm font-semibold text-slate-200">Commentaire</label>
                            <textarea id="notes" name="notes" rows="3" <?= $disabledAttr ?> placeholder="Toute information utile (optionnel)..." class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none placeholder:text-slate-500 focus:border-brand-500<?= $disabledClass ?>"><?= e((string) ($values['notes'] ?? '')) ?></textarea>
                        </div>
                    </div>
                </div>

                <label class="flex items-start gap-3 rounded-2xl border border-slate-700 bg-slate-950 px-4 py-4 text-sm text-slate-200<?= $disabledClass ?>">
                    <input type="checkbox" name="consent_rgpd" value="1" <?= (int) $values['consent_rgpd'] === 1 ? 'checked' : '' ?> <?= $disabledAttr ?> class="mt-1 h-4 w-4 rounded border-slate-600 text-brand-500 focus:ring-brand-400">
                    <span>J'accepte le traitement de mes données pour la gestion de mon engagement bénévole.</span>
                </label>

                <?php if (empty($locked)): ?>
                    <button type="submit" class="inline-flex rounded-2xl bg-brand-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-700/30 hover:bg-brand-700">Enregistrer mes informations</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</section>
