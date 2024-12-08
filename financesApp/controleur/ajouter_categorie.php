<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../compte/vue/login.view.php?error=1");
    exit();
}

include '../modele/connexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $connexion = new Connexion();
        $login = $_SESSION['login'];

        // Vérifier si la catégorie est vide
        if (empty($_POST['nom'])) {
            throw new Exception("Le nom de la catégorie ne peut pas être vide.");
        }

        $nomCategorie = $_POST['nom'];

        // Récupérer l'id_client
        $reqClient = "SELECT id_cli FROM client WHERE login = :login";
        $resultClient = $connexion->execSQL($reqClient, ['login' => $login]);

        if (empty($resultClient)) {
            throw new Exception("Utilisateur non trouvé.");
        }

        $id_client = $resultClient[0]['id_cli'];

        // Insertion de la nouvelle catégorie dans la base de données
        $reqInsertCategorie = "INSERT INTO categories (id_client, nom) VALUES (:id_client, :nom)";
        $connexion->execSQL($reqInsertCategorie, ['id_client' => $id_client, 'nom' => $nomCategorie]);

        header("Location: ../controleur/list_categories.php?success=1");
        exit();
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une catégorie</title>
    <link rel="stylesheet" href="../../style/finances.css">
</head>

<body>
    <header class="main-header">
        <h1>Ajouter une nouvelle catégorie</h1>
        <div class="menu">
            <a href="../vue/index.php" class="btn">Retour à l'acceuil</a>
            <a href="../../compte/controleur/logout.php" class="btn logout-btn">Déconnexion</a>
        </div>
    </header>

    <div class="container" style="max-width: 500px; width: 90%">
        <div class="content">

            <?php if (isset($errorMessage)): ?>
                <p class="error"><?= htmlspecialchars($errorMessage) ?></p>
            <?php endif; ?>

            <form method="POST" action="ajouter_categorie.php">
                <p><strong>Nom de la catégorie :</strong></p>
                <input type="text" id="category-name" name="nom" placeholder="Nom de la catégorie" />

                <button type="submit">Ajouter</button>
            </form>
        </div>
    </div>

</body>

</html>