<?php
$user = $_SESSION['user'];
$config = require __DIR__ . '/../config.php';
$services = $config['services'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signatures - Groupe Speed Cloud</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'speed-purple': '#8a4dfd',
                        'speed-purple-dark': '#7040d9',
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900" style="font-family: 'Titillium Web', sans-serif;">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-10">
            <div class="flex items-center gap-4">
                <img src="/assets/images/cloudy.png" alt="Groupe Speed Cloud" class="w-12 h-12 rounded-xl">
                <div>
                    <h1 class="text-xl font-bold text-white">Signatures</h1>
                    <p class="text-gray-400 text-sm">Groupe Speed Cloud</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <?php if (!empty($user['picture'])): ?>
                    <img src="<?= htmlspecialchars($user['picture']) ?>" alt="" class="w-10 h-10 rounded-full">
                    <?php endif; ?>
                    <div class="text-right">
                        <p class="text-white text-sm font-medium"><?= htmlspecialchars($user['name']) ?></p>
                        <p class="text-gray-400 text-xs"><?= htmlspecialchars($user['email']) ?></p>
                        <?php if (!empty($user['jobTitle'])): ?>
                        <p class="text-purple-400 text-xs"><?= htmlspecialchars($user['jobTitle']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="/logout.php" class="text-gray-400 hover:text-white transition" title="Déconnexion">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Tabs -->
        <div class="max-w-4xl mx-auto mb-6">
            <div class="flex gap-2">
                <button id="tabPersonal" class="px-6 py-3 rounded-t-lg bg-white/10 text-white font-medium border-b-2 border-speed-purple transition">
                    👤 Signature Personnelle
                </button>
                <button id="tabService" class="px-6 py-3 rounded-t-lg bg-white/5 text-gray-400 font-medium border-b-2 border-transparent hover:text-white transition">
                    🏢 Signature Service
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto bg-white/10 backdrop-blur-lg rounded-2xl rounded-tl-none p-8 shadow-2xl border border-white/20">
            
            <!-- Personal Signature Form -->
            <form id="personalForm" class="grid md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="firstname" class="block text-sm font-semibold text-gray-200 mb-2">Prénom</label>
                    <input type="text" id="firstname" value="<?= htmlspecialchars($user['firstName']) ?>" 
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-speed-purple transition">
                </div>
                <div>
                    <label for="lastname" class="block text-sm font-semibold text-gray-200 mb-2">Nom</label>
                    <input type="text" id="lastname" value="<?= htmlspecialchars($user['lastName']) ?>" 
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-speed-purple transition">
                </div>
                <div>
                    <label for="job" class="block text-sm font-semibold text-gray-200 mb-2">
                        Poste
                        <?php if (!empty($user['jobTitle'])): ?>
                        <span class="text-green-400 text-xs ml-2">✓ Récupéré depuis Google</span>
                        <?php endif; ?>
                    </label>
                    <input type="text" id="job" value="<?= htmlspecialchars($user['jobTitle'] ?? '') ?>" placeholder="Votre fonction" 
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-speed-purple transition">
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-200 mb-2">E-mail</label>
                    <input type="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" readonly
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-gray-400 cursor-not-allowed">
                </div>
                <input type="hidden" id="signatureType" value="personal">
            </form>
            
            <!-- Service Signature Form (hidden by default) -->
            <form id="serviceForm" class="hidden grid md:grid-cols-2 gap-6 mb-8">
                <div class="md:col-span-2">
                    <label for="service" class="block text-sm font-semibold text-gray-200 mb-2">Service / Département</label>
                    <select id="service" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-speed-purple transition">
                        <?php foreach ($services as $key => $service): ?>
                            <?php if ($key === ''): ?>
                            <option value="" class="bg-gray-800">-- Sélectionnez un service --</option>
                            <?php else: ?>
                            <option value="<?= htmlspecialchars($key) ?>" class="bg-gray-800"><?= htmlspecialchars($service['name']) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="hidden" id="serviceSignatureType" value="service">
            </form>
            
            <!-- Client Email Selection -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-200 mb-2">Client email</label>
                <div class="grid grid-cols-3 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="style" value="gmail" class="peer hidden" checked>
                        <div class="p-4 bg-white/5 border-2 border-white/10 rounded-lg text-center peer-checked:border-speed-purple peer-checked:bg-speed-purple/20 transition">
                            <span class="text-white font-medium">Gmail</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="style" value="outlook" class="peer hidden">
                        <div class="p-4 bg-white/5 border-2 border-white/10 rounded-lg text-center peer-checked:border-speed-purple peer-checked:bg-speed-purple/20 transition">
                            <span class="text-white font-medium">Outlook</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="style" value="chatwoot" class="peer hidden">
                        <div class="p-4 bg-white/5 border-2 border-white/10 rounded-lg text-center peer-checked:border-speed-purple peer-checked:bg-speed-purple/20 transition">
                            <span class="text-white font-medium">Chatwoot</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Preview -->
            <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                <div class="bg-gray-100 px-4 py-2 border-b flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                        <span class="ml-4 text-sm text-gray-500">Aperçu de la signature</span>
                    </div>
                    <button id="copyBtn" class="text-sm bg-speed-purple text-white px-3 py-1 rounded hover:bg-speed-purple-dark transition">
                        Copier
                    </button>
                </div>
                <div id="preview" class="p-6 bg-white min-h-[200px]">
                    <!-- Signature générée ici -->
                </div>
            </div>

            <!-- Instructions -->
            <div class="mt-6 p-4 bg-speed-purple/20 rounded-lg border border-speed-purple/30">
                <h3 class="text-white font-semibold mb-2">💡 Comment utiliser</h3>
                <ol class="text-gray-300 text-sm space-y-1 list-decimal list-inside">
                    <li>Vérifiez vos informations (prénom, nom, poste)</li>
                    <li>Sélectionnez votre client email</li>
                    <li>Cliquez sur "Copier" ou sélectionnez la signature (Ctrl+A dans l'aperçu)</li>
                    <li>Collez dans les paramètres de signature de votre client email</li>
                </ol>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-400 text-sm">
            © <?= date('Y') ?> Groupe Speed Cloud - Tous droits réservés
        </div>
    </div>

    <!-- Services data for JS -->
    <script>
        const servicesData = <?= json_encode($services) ?>;
    </script>

    <script>
        const personalForm = document.getElementById('personalForm');
        const serviceForm = document.getElementById('serviceForm');
        const tabPersonal = document.getElementById('tabPersonal');
        const tabService = document.getElementById('tabService');
        const preview = document.getElementById('preview');
        const copyBtn = document.getElementById('copyBtn');
        
        let currentTab = 'personal';
        
        // Tab switching
        tabPersonal.addEventListener('click', () => {
            currentTab = 'personal';
            tabPersonal.classList.add('bg-white/10', 'text-white', 'border-speed-purple');
            tabPersonal.classList.remove('bg-white/5', 'text-gray-400', 'border-transparent');
            tabService.classList.remove('bg-white/10', 'text-white', 'border-speed-purple');
            tabService.classList.add('bg-white/5', 'text-gray-400', 'border-transparent');
            personalForm.classList.remove('hidden');
            serviceForm.classList.add('hidden');
            updatePreview();
        });
        
        tabService.addEventListener('click', () => {
            currentTab = 'service';
            tabService.classList.add('bg-white/10', 'text-white', 'border-speed-purple');
            tabService.classList.remove('bg-white/5', 'text-gray-400', 'border-transparent');
            tabPersonal.classList.remove('bg-white/10', 'text-white', 'border-speed-purple');
            tabPersonal.classList.add('bg-white/5', 'text-gray-400', 'border-transparent');
            serviceForm.classList.remove('hidden');
            personalForm.classList.add('hidden');
            updatePreview();
        });
        
        async function updatePreview() {
            const style = document.querySelector('input[name="style"]:checked').value;
            let data;
            
            if (currentTab === 'personal') {
                data = new URLSearchParams({
                    style: style,
                    type: 'personal',
                    name: `${personalForm.firstname.value} ${personalForm.lastname.value}`.trim(),
                    job: personalForm.job.value,
                    email: personalForm.email.value
                });
            } else {
                const serviceKey = serviceForm.service.value;
                const serviceInfo = servicesData[serviceKey] || {};
                data = new URLSearchParams({
                    style: style,
                    type: 'service',
                    service: serviceKey,
                    name: serviceInfo.name || '',
                    email: serviceInfo.email || '',
                    job: ''
                });
            }
            
            try {
                const response = await fetch('/signature.php?' + data.toString());
                preview.innerHTML = await response.text();
            } catch (e) {
                console.error(e);
            }
        }
        
        // Events for personal form
        personalForm.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', updatePreview);
        });
        
        // Events for service form
        serviceForm.service.addEventListener('change', updatePreview);
        
        // Events for style selection
        document.querySelectorAll('input[name="style"]').forEach(input => {
            input.addEventListener('change', updatePreview);
        });
        
        // Copy button
        copyBtn.addEventListener('click', async () => {
            try {
                const selection = window.getSelection();
                const range = document.createRange();
                range.selectNodeContents(preview);
                selection.removeAllRanges();
                selection.addRange(range);
                document.execCommand('copy');
                selection.removeAllRanges();
                
                copyBtn.textContent = '✓ Copié !';
                setTimeout(() => copyBtn.textContent = 'Copier', 2000);
            } catch (e) {
                console.error(e);
            }
        });
        
        // Init
        updatePreview();
    </script>
</body>
</html>
