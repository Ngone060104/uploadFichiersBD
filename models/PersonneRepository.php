<?php
require_once 'Personne.php';

class PersonneRepository {
    private PDO $db;
    private string $uploadDir = 'uploads/';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        // Créer le dossier s'il n'existe pas
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
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
                $row['chemin_image'],
                $row['id']
            );
        }
        return $personnes;
    }

    // Créer une nouvelle personne
    public function create(string $nom, string $prenom, ?array $file): bool {
        // Appel à la méthode d'upload
        $cheminImage = $this->handleUpload($file);

        $stmt = $this->db->prepare("INSERT INTO personnes (nom, prenom, chemin_image) VALUES (:nom, :prenom, :image)");
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':image' => $cheminImage
        ]);
    }

    // ---------------------------------------------------------
    // LA MÉTHODE D'UPLOAD D'IMAGE DEMANDÉE
    // ---------------------------------------------------------
    private function handleUpload(?array $file): string {
        $defaultPath = 'uploads/default.png'; // Image par défaut

        // Si aucun fichier n'est envoyé ou s'il y a une erreur
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return $defaultPath;
        }

        // Vérification du type MIME
        $fileType = mime_content_type($file['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (!in_array($fileType, $allowedTypes)) {
            return $defaultPath; // Type interdit, on retourne l'image par défaut
        }

        // Vérification de la taille (2 Mo max)
        if ($file['size'] > 2 * 1024 * 1024) {
            return $defaultPath; // Trop gros
        }

        // Génération d'un nom unique
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('img_', true) . '.' . $extension;
        $targetFilePath = $this->uploadDir . $newFileName;

        // Déplacement physique du fichier
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $targetFilePath;
        }

        return $defaultPath;
    }
}
?>