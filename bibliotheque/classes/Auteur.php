<?php

class Auteur {

    private $conn;
    private $table = "auteurs";

    public $id;
    public $nom;
    public $prenom;
    public $nationalite;

    public function __construct($db) {
        $this->conn = $db;
    }

    // AJOUTER
    public function ajouter() {

        $query = "INSERT INTO auteurs (nom, prenom, nationalite)
                  VALUES (:nom, :prenom, :nationalite)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":nationalite", $this->nationalite);

        return $stmt->execute();
    }

    // AFFICHER
    public function lire() {

        $query = "SELECT * FROM auteurs";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // MODIFIER
    public function modifier() {

        $query = "UPDATE auteurs 
                  SET nom = :nom, prenom = :prenom, nationalite = :nationalite
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":nationalite", $this->nationalite);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // SUPPRIMER
    public function supprimer() {

        $query = "DELETE FROM auteurs WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }
}