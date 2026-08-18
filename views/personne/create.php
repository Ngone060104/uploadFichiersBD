<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une personne</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 font-sans">

    <!-- 1. BARRE DE NAVIGATION -->
    <nav class="bg-white shadow-sm border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-600 text-white p-2 rounded-lg shadow-md">
                        <i class="fa-solid fa-users text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-slate-800 tracking-tight">Gestion des personnes</span>
                </div>
                <a href="/" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 px-5 py-2.5 rounded-lg shadow-sm hover:shadow transition-all duration-200 font-medium text-sm">
                    <i class="fa-solid fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            
            <!-- En-tête de la carte -->
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-800">Ajouter une nouvelle personne</h1>
                    <p class="text-sm text-slate-500">Remplissez les informations ci-dessous</p>
                </div>
            </div>

            <div class="p-6">
                
                <!-- Affichage du message global (succès ou erreur serveur) -->
                <?php if (isset($errors['global'])): ?>
                    <div class="mb-6 p-4 rounded-lg flex items-center gap-3 bg-red-50 text-red-700 border border-red-200">
                        <i class="fa-solid fa-circle-exclamation text-lg"></i>
                        <span><?= htmlspecialchars($errors['global']) ?></span>
                    </div>
                <?php endif; ?>

                <form method="post" enctype="multipart/form-data" novalidate class="space-y-6">
                    
                    <!-- Champs Nom et Prénom -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="block text-sm font-semibold text-slate-700 mb-1.5">Nom <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <!-- Ajout de la classe border-red-500 si erreur -->
                                <input type="text" id="nom" name="nom" 
                                       value="<?= htmlspecialchars($old['nom'] ?? '') ?>"
                                       class="block w-full pl-10 pr-3 py-2.5 bg-slate-50 border <?= isset($errors['nom']) ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-300' ?> rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors outline-none placeholder:text-slate-400 text-sm"
                                       placeholder="ex: Dupont">
                            </div>
                            <!-- Message d'erreur sous le champ -->
                            <?php if (isset($errors['nom'])): ?>
                                <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation text-xs"></i>
                                    <?= htmlspecialchars($errors['nom']) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="prenom" class="block text-sm font-semibold text-slate-700 mb-1.5">Prénom <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <!-- Ajout de la classe border-red-500 si erreur -->
                                <input type="text" id="prenom" name="prenom" 
                                       value="<?= htmlspecialchars($old['prenom'] ?? '') ?>"
                                       class="block w-full pl-10 pr-3 py-2.5 bg-slate-50 border <?= isset($errors['prenom']) ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-300' ?> rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors outline-none placeholder:text-slate-400 text-sm"
                                       placeholder="ex: Jean">
                            </div>
                            <!-- Message d'erreur sous le champ -->
                            <?php if (isset($errors['prenom'])): ?>
                                <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation text-xs"></i>
                                    <?= htmlspecialchars($errors['prenom']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Upload de photo stylisé -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Photo de profil</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors bg-slate-50/50 group">
                            <div class="space-y-1 text-center">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400 group-hover:text-indigo-500 transition-colors mb-2"></i>
                                <div class="text-sm text-slate-600">
                                    <label for="image" class="relative cursor-pointer rounded-md font-semibold text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Téléverser une image</span>
                                        <input id="image" name="image" type="file" accept="image/*" class="sr-only">
                                    </label>
                                    <p class="pl-1">ou glissez-déposez</p>
                                </div>
                                <p class="text-xs text-slate-500">PNG, JPG, WEBP jusqu'à 2 Mo</p>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-100">
                        <a href="/" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" name="ajouter" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 font-medium text-sm">
                            <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>

</body>
</html>