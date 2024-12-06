<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../compte/vue/login.view.php?error=1");
    exit();
}

include '../modele/connexion.php';

try {
    $connexion = new Connexion();
    $login = $_SESSION['login'];

    $reqClient = "SELECT id_cli FROM client WHERE login = :login";
    $resultClient = $connexion->execSQL($reqClient, ['login' => $login]);

    if (empty($resultClient)) {
        throw new Exception("Utilisateur non trouvé.");
    }

    $id_client = $resultClient[0]['id_cli'];

    $reqCategories = "SELECT * FROM categories WHERE id_client = :id_client";
    $categories = $connexion->execSQL($reqCategories, ['id_client' => $id_client]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finances App</title>
    <link rel="stylesheet" href="../../style/finances.css">
</head>

<body>
    <header class="main-header">
        <h1>Bienvenue, <?= htmlspecialchars($login) ?> !</h1>
        <div class="menu">
            <a href="../vue/index.php" class="btn">Retour à l'accueil</a>
            <a href="../../compte/controleur/logout.php" class="btn logout-btn">Déconnexion</a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <p class="success">Opération réussie !</p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>

    </header>

    <div class="container">
        <div class="content">

            <section>
                <h2>Vos Catégories</h2>
                <?php if (!empty($categories)): ?>
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($categories as $categorie):
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($categorie['id']) ?></td>
                                    <td><?= htmlspecialchars($categorie['nom']) ?></td>
                                    <td>
                                        <a href="../controleur/modifier_categorie.php?id=<?= $categorie['id'] ?>" class="btn btn-edit">Modifier</a>
                                        <a href="../controleur/supprimer_categorie.php?id=<?= $categorie['id'] ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                <?php else: ?>
                    <p>Vous n'avez aucune catégorie enregistrée.</p>
                <?php endif; ?>

                <a href="../controleur/ajouter_categorie.php" class="btn btn-add">Ajouter une catégorie</a>
            </section>


        </div>

    </div>
</body>

</html>