<?php
require_once __DIR__ . '/../models/PersonneRepository.php';

class PersonneController {
    private PersonneRepository $repo;

    public function __construct(PDO $db) {
        $this->repo = new PersonneRepository($db);
    }

    public function index(): void {
        $personnes = $this->repo->findAll();
        require_once __DIR__ . '/../views/personne/index.php';
    }

       public function create(): void {
        $errors = []; // Tableau pour stocker les erreurs spécifiques
        $old = [];    // Pour garder les valeurs saisies (si erreur, on ne perd pas le texte tapé)

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);

            // Validation spécifique par champ
            if (empty($nom)) {
                $errors['nom'] = "Le champ Nom est obligatoire.";
            }
            if (empty($prenom)) {
                $errors['prenom'] = "Le champ Prénom est obligatoire.";
            }

            // Si aucune erreur, on enregistre
            if (empty($errors)) {
                $success = $this->repo->create($nom, $prenom, $_FILES['image'] ?? null);
                if ($success) {
                    header('Location: /');
                    exit();
                } else {
                    $errors['global'] = "Une erreur est survenue lors de l'enregistrement.";
                }
            }

            // On garde les valeurs tapées pour ne pas les effacer
            $old = ['nom' => $nom, 'prenom' => $prenom];
        }

        // On passe les erreurs et les anciennes valeurs à la vue
        require_once ROOT_PATH . '/views/personne/create.php';
    }
}
?>