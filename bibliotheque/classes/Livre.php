<?php

class Livre {

    private $conn;
    private $table = "livres";

    public $id;
    public $titre;
    public $isbn;
    public $annee;
    public $quantite;
    public $auteur_id;
    public $categorie_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // AJOUTER LIVRE
    public function ajouter() {

        $query = "INSERT INTO livres 
        (titre, isbn, annee, quantite, auteur_id, categorie_id)
        VALUES (:titre, :isbn, :annee, :quantite, :auteur_id, :categorie_id)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":titre", $this->titre);
        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":annee", $this->annee);
        $stmt->bindParam(":quantite", $this->quantite);
        $stmt->bindParam(":auteur_id", $this->auteur_id);
        $stmt->bindParam(":categorie_id", $this->categorie_id);

        return $stmt->execute();
    }

    // AFFICHER LIVRES
    public function lire() {

        $query = "SELECT livres.*, 
                  auteurs.nom AS auteur,
                  categories.libelle AS categorie
                  FROM livres
                  JOIN auteurs ON livres.auteur_id = auteurs.id
                  JOIN categories ON livres.categorie_id = categories.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // SUPPRIMER LIVRE
    public function supprimer() {

        $query = "DELETE FROM livres WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }
}