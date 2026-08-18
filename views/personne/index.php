<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Gestion des personnes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Icônes Heroicons pour un look pro -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 font-sans">

    <!-- 1. BARRE DE NAVIGATION PROFESSIONNELLE -->
    <nav class="bg-white shadow-sm border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo / Titre -->
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-600 text-white p-2 rounded-lg shadow-md">
                        <i class="fa-solid fa-users text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-slate-800 tracking-tight">Gestion des personnes</span>
                </div>
                
                <!-- Bouton Ajouter (Corrigé vers /create) -->
                <a href="/create" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 font-medium text-sm">
                    <i class="fa-solid fa-plus"></i> Ajouter une personne
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- 2. STATISTIQUES RAPIDES (Pour un effet pro) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center text-xl">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Total membres</p>
                    <p class="text-2xl font-bold text-slate-800"><?= count($personnes) ?></p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center text-xl">
                    <i class="fa-solid fa-image"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Photos uploadées</p>
                    <p class="text-2xl font-bold text-slate-800">
                        <?= count(array_filter($personnes, fn($p) => strpos($p->getImageData(), 'data:image') === 0 && $p->getImageData() !== 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH5QoHDBUNBqHnPQAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAAYklEQVRYw+3XsQ2AIBQF0UtpXYVd2ISN2MRN2IQxKqLwHjzKxEAsfbk5WX5uxwAAAAASUVORK5CYII=') ?>
                    </p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center text-xl">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Dernier ajout</p>
                    <p class="text-2xl font-bold text-slate-800 truncate"><?= isset($personnes[0]) ? htmlspecialchars($personnes[0]->getPrenom()) : 'Aucun' ?></p>
                </div>
            </div>
        </div>

        <!-- 3. GRILLE DE CARTES (Remplace le tableau) -->
        <?php if (count($personnes) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($personnes as $p): ?>
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden group">
                    <!-- Zone image -->
                    <div class="relative h-48 w-full bg-slate-100 flex items-center justify-center overflow-hidden">
                        <!-- CORRECTION ICI : On utilise getImageData() -->
                        <img src="<?= htmlspecialchars($p->getImageData()) ?>" 
                             alt="<?= htmlspecialchars($p->getPrenom()) ?>" 
                             class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <!-- Badge ID sur l'image -->
                        <div class="absolute top-3 right-3 bg-black/60 text-white text-xs font-bold px-2 py-1 rounded-full backdrop-blur-sm">
                            #<?= $p->getId() ?>
                        </div>
                    </div>
                    
                    <!-- Zone infos -->
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-lg font-bold text-slate-800 truncate"><?= htmlspecialchars($p->getPrenom()) ?></h3>
                        </div>
                        <p class="text-sm text-slate-500 font-medium mb-4"><?= htmlspecialchars($p->getNom()) ?></p>
                        
                        <!-- Actions (Simulées pour le style) -->
                        <div class="flex gap-2 pt-3 border-t border-slate-100">
                            <button class="flex-1 py-1.5 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-md text-xs font-semibold transition-colors">
                                <i class="fa-regular fa-eye mr-1"></i> Voir
                            </button>
                            <button class="flex-1 py-1.5 px-3 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-md text-xs font-semibold transition-colors">
                                <i class="fa-regular fa-pen-to-square mr-1"></i> Éditer
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- État vide stylisé -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 text-4xl">
                    <i class="fa-solid fa-users-slash"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Aucune personne enregistrée</h3>
                <p class="text-slate-500 mb-6">Commencez par ajouter votre premier membre.</p>
                <a href="/create" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg shadow-md transition-all font-medium text-sm">
                    <i class="fa-solid fa-plus"></i> Ajouter maintenant
                </a>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>