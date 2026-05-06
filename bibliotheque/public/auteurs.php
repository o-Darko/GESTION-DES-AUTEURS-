<?php
require_once "../config/Database.php";
require_once "../classes/Auteur.php";

$db = (new Database())->connect();
$auteur = new Auteur($db);

/* =========================
   AJOUT AUTEUR
========================= */
if(isset($_POST['ajouter'])) {
    $auteur->nom = $_POST['nom'];
    $auteur->prenom = $_POST['prenom'];
    $auteur->nationalite = $_POST['nationalite'];

    $auteur->ajouter();
}

/* =========================
   SUPPRESSION AUTEUR
========================= */
if(isset($_GET['delete'])) {
    $auteur->id = $_GET['delete'];
    $auteur->supprimer();

    header("Location: auteurs.php");
    exit;
}
?>

<!-- Bootstrap (si pas déjà dans ton projet) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

    <h2 class="text-center mb-4">📚 Gestion des Auteurs</h2>

    <!-- FORMULAIRE -->
    <div class="card shadow p-4 mb-4">
        <form method="POST">
            <input class="form-control mb-2" type="text" name="nom" placeholder="Nom" required>
            <input class="form-control mb-2" type="text" name="prenom" placeholder="Prénom" required>
            <input class="form-control mb-2" type="text" name="nationalite" placeholder="Nationalité" required>

            <button class="btn btn-primary w-100" name="ajouter">Ajouter</button>
        </form>
    </div>

    <!-- TABLE -->
    <div class="card shadow p-3">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Nationalité</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $result = $auteur->lire();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>{$row['nom']}</td>
                    <td>{$row['prenom']}</td>
                    <td>{$row['nationalite']}</td>
                    <td>
                        <a class='btn btn-danger btn-sm' 
                           href='auteurs.php?delete={$row['id']}'
                           onclick=\"return confirm('Supprimer cet auteur ?')\">
                           Supprimer
                        </a>
                    </td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

</div>