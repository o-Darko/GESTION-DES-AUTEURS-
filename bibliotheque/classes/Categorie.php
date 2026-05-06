<?php

class Categorie {

    private $conn;
    private $table = "categories";

    public $id;
    public $libelle;

    public function __construct($db) {
        $this->conn = $db;
    }

    // =========================
    // AJOUTER
    // =========================
    public function ajouter() {

        $query = "INSERT INTO categories (libelle)
                  VALUES (:libelle)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":libelle", $this->libelle);

        return $stmt->execute();
    }

    // =========================
    // LIRE
    // =========================
    public function lire() {

        $query = "SELECT * FROM categories";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // =========================
    // MODIFIER
    // =========================
    public function modifier() {

        $query = "UPDATE categories 
                  SET libelle = :libelle 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":libelle", $this->libelle);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // =========================
    // SUPPRIMER
    // =========================
    public function supprimer() {

        $query = "DELETE FROM categories WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }
}