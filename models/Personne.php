<?php
class Personne {
    private ?int $id;
    private string $nom;
    private string $prenom;
    private string $image_data; // On stocke le contenu brut encodé en Base64 ici

    public function __construct(string $nom, string $prenom, string $image_data, ?int $id = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->image_data = $image_data;
        $this->id = $id;
    }

    public static function fromArray(array $data): self {
        return new self($data['nom'], $data['prenom'], $data['image_data'], $data['id'] ?? null);
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getImageData(): string { return $this->image_data; } // C'est ça qui sera mis dans src="..."
}
?>