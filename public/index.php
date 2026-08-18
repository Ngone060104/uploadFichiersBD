<?php
// 1. On remonte dans les dossiers parents pour inclure le strict minimum
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../models/Personne.php';
require_once __DIR__ . '/../models/PersonneRepository.php';
require_once __DIR__ . '/../controllers/PersonneController.php';

// CETTE LIGNE EST OBLIGATOIRE POUR QUE LA LIGNE 48 MARCHE :
define('ROOT_PATH', dirname(__DIR__)); 

// 2. Connexion à la base de données
$db = Database::getInstance()->getConnection();

// 3. Initialiser le routeur
$basePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__); // Détection auto
$router = new Router($basePath);

// 4. Définir les routes
$router->add('GET', '/', PersonneController::class, 'index');
$router->add('GET', '/create', PersonneController::class, 'create');
$router->add('POST', '/create', PersonneController::class, 'create');

// 5. Lancer le dispatcher
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);