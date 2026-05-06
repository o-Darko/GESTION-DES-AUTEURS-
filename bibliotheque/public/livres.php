<?php
require_once "../config/Database.php";
require_once "../classes/Livre.php";

$db = (new Database())->connect();
$livre = new Livre($db);

/* =========================
   AJOUT LIVRE
========================= */
if(isset($_POST['ajouter'])) {

    $livre->titre = $_POST['titre'];
    $livre->isbn = $_POST['isbn'];
    $livre->annee = $_POST['annee'];
    $livre->quantite = $_POST['quantite'];
    $livre->auteur_id = $_POST['auteur_id'];
    $livre->categorie_id = $_POST['categorie_id'];

    $livre->ajouter();
}

/* =========================
   SUPPRESSION LIVRE
========================= */
if(isset($_GET['delete'])) {

    $livre->id = $_GET['delete'];
    $livre->supprimer();

    header("Location: livres.php");
    exit;
}
?>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

    <h2 class="text-center mb-4">📚 Gestion des Livres</h2>

    <!-- FORMULAIRE -->
    <div class="card shadow p-4 mb-4">

        <form method="POST">

            <input class="form-control mb-2" type="text" name="titre" placeholder="Titre" required>
            <input class="form-control mb-2" type="text" name="isbn" placeholder="ISBN" required>
            <input class="form-control mb-2" type="number" name="annee" placeholder="Année" required>
            <input class="form-control mb-2" type="number" name="quantite" placeholder="Quantité" required>

            <input class="form-control mb-2" type="number" name="auteur_id" placeholder="ID Auteur" required>
            <input class="form-control mb-2" type="number" name="categorie_id" placeholder="ID Catégorie" required>

            <button class="btn btn-primary w-100" name="ajouter">Ajouter</button>

        </form>

    </div>

    <!-- TABLE -->
    <div class="card shadow p-3">

        <table class="table table-striped table-hover">

            <thead class="table-dark">
                <tr>
                    <th>Titre</th>
                    <th>ISBN</th>
                    <th>Année</th>
                    <th>Quantité</th>
                    <th>Auteur</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php
            $result = $livre->lire();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>{$row['titre']}</td>
                    <td>{$row['isbn']}</td>
                    <td>{$row['annee']}</td>
                    <td>{$row['quantite']}</td>
                    <td>{$row['auteur']}</td>
                    <td>{$row['categorie']}</td>
                    <td>
                        <a class='btn btn-danger btn-sm'
                           href='livres.php?delete={$row['id']}'
                           onclick=\"return confirm('Supprimer ce livre ?')\">
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