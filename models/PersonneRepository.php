<?php
require_once __DIR__ . '/Personne.php';

if (!class_exists('Database')) {
    require_once __DIR__ . '/../config/Database.php';
}

class PersonneRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Récupérer toutes les personnes
    public function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM personnes ORDER BY id DESC");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $personnes = [];
        foreach ($data as $row) {
            $personnes[] = new Personne(
                $row['nom'],
                $row['prenom'],
                $row['image_data'], 
                $row['id']
            );
        }
        return $personnes;
    }

    // Créer une nouvelle personne
    public function create(string $nom, string $prenom, ?array $file): bool {
        // Appel à la nouvelle méthode d'encodage
        $imageData = $this->handleImageEncoding($file);

        // On insère dans la colonne 'image_data'
        $stmt = $this->db->prepare("INSERT INTO personnes (nom, prenom, image_data) VALUES (:nom, :prenom, :image)");
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':image' => $imageData // On envoie directement la chaîne Base64
        ]);
    }

    // ---------------------------------------------------------
    // LA NOUVELLE MÉTHODE D'UPLOAD (Directement dans la BDD)
    // ---------------------------------------------------------
    private function handleImageEncoding(?array $file): string {
        // 1. Image par défaut encodée en Base64 (Petit carré gris)
        $defaultBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH5QoHDBUNBqHnPQAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAAYklEQVRYw+3XsQ2AIBQF0UtpXYVd2ISN2MRN2IQxKqLwHjzKxEAsfbk5WX5uxwAAAAASUVORK5CYII=';

        // Étape 1 : Vérifier si un fichier est bien envoyé
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return $defaultBase64;
        }

        // Étape 2 : Vérification du type MIME (Sécurité)
        $fileType = mime_content_type($file['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (!in_array($fileType, $allowedTypes)) {
            return $defaultBase64; // Type interdit
        }

        // Étape 3 : Vérification de la taille (2 Mo max)
        if ($file['size'] > 2 * 1024 * 1024) {
            return $defaultBase64; // Trop gros
        }

        // Étape 4 : Lire le fichier, l'encoder en Base64 et le formater pour le HTML
        $fileContent = file_get_contents($file['tmp_name']);
        $base64 = base64_encode($fileContent);

        // Retourner la chaîne prête pour la balise <img> et la BDD
        return 'data:' . $fileType . ';base64,' . $base64;
    }
}
?>