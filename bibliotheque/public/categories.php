<?php
require_once "../config/Database.php";
require_once "../classes/Categorie.php";

$db = (new Database())->connect();
$cat = new Categorie($db);

/* =========================
   AJOUT
========================= */
if(isset($_POST['ajouter'])) {
    $cat->libelle = $_POST['libelle'];
    $cat->ajouter();

    header("Location: categories.php");
    exit;
}

/* =========================
   SUPPRESSION
========================= */
if(isset($_GET['delete'])) {
    $cat->id = $_GET['delete'];
    $cat->supprimer();

    header("Location: categories.php");
    exit;
}

/* =========================
   EDIT (récupération)
========================= */
$editData = null;

if(isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}

/* =========================
   MODIFICATION
========================= */
if(isset($_POST['modifier'])) {
    $cat->id = $_POST['id'];
    $cat->libelle = $_POST['libelle'];

    $cat->modifier();

    header("Location: categories.php");
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

    <h2 class="text-center mb-4">📂 Gestion des Catégories</h2>

    <!-- FORMULAIRE -->
    <div class="card p-3 mb-4">

        <form method="POST">

            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

            <input class="form-control mb-2"
                   type="text"
                   name="libelle"
                   value="<?= $editData['libelle'] ?? '' ?>"
                   placeholder="Libellé catégorie"
                   required>

            <?php if($editData): ?>
                <button class="btn btn-success w-100" name="modifier">Modifier</button>
            <?php else: ?>
                <button class="btn btn-primary w-100" name="ajouter">Ajouter</button>
            <?php endif; ?>

        </form>

    </div>

    <!-- TABLE -->
    <table class="table table-striped table-hover">

        <thead class="table-dark">
            <tr>
                <th>Libellé</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php
        $result = $cat->lire();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                <td>{$row['libelle']}</td>
                <td>
                    <a class='btn btn-warning btn-sm' href='categories.php?edit={$row['id']}'>Modifier</a>

                    <a class='btn btn-danger btn-sm'
                       href='categories.php?delete={$row['id']}'
                       onclick=\"return confirm('Supprimer ?')\">
                       Supprimer
                    </a>
                </td>
            </tr>";
        }
        ?>

        </tbody>
    </table>

</div>