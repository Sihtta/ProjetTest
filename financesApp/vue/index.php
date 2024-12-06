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

    $reqComptes = "SELECT * FROM compte_bancaire WHERE id_client = :id_client";
    $comptes = $connexion->execSQL($reqComptes, ['id_client' => $id_client]);

    $reqCategories = "SELECT * FROM categories WHERE id_client = :id_client";
    $categories = $connexion->execSQL($reqCategories, ['id_client' => $id_client]);

    // Requête pour récupérer les transactions, triées par date, avec jointure pour le nom de la catégorie
    $reqTransactions = "
        SELECT t.*, cb.libelle AS compte, c.nom AS categorie
        FROM transactions t
        INNER JOIN compte_bancaire cb ON t.id_compte = cb.id_compte
        INNER JOIN categories c ON t.categorie = c.id
        WHERE cb.id_client = :id_client
        ORDER BY t.date DESC
        LIMIT 5";
    $transactions = $connexion->execSQL($reqTransactions, ['id_client' => $id_client]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>

<?php if (isset($_GET['success'])): ?>
    <p class="success">Opération réussie !</p>
<?php elseif (isset($_GET['error'])): ?>
    <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>


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
            <a href="../../projets.php" class="btn">Accueil</a>
            <a href="../../compte/controleur/logout.php" class="btn logout-btn">Déconnexion</a>
        </div>
    </header>
    <div class="container">
        <div class="content">

            <div class="rotating-bar bar1"></div>
            <div class="rotating-bar bar2"></div>
            <section>
                <h2>Vos Comptes Bancaires</h2>
                <?php if (!empty($comptes)): ?>
                    <div class="comptes-list">
                        <?php foreach ($comptes as $compte): ?>
                            <div class="compte-card">
                                <h3><?= htmlspecialchars($compte['libelle']) ?></h3>
                                <p><strong>Type :</strong> <?= htmlspecialchars($compte['type']) ?></p>
                                <p><strong>Solde :</strong> <?= htmlspecialchars($compte['solde']) ?> €</p>
                                <a href="#" class="btn">Voir détails</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Vous n'avez aucun compte bancaire enregistré.</p>
                <?php endif; ?>
            </section>

            <section>
                <h2>Vos dernières Transactions</h2>
                <?php if (!empty($transactions)): ?>
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Montant</th>
                                <th>Catégorie</th>
                                <th>Description</th>
                                <th>Compte</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr>
                                    <td><?= (new DateTime($transaction['date']))->format('d-m-Y') ?></td>
                                    <td><?= htmlspecialchars($transaction['type']) ?></td>
                                    <td><?= htmlspecialchars($transaction['montant']) ?> €</td>
                                    <td><?= htmlspecialchars($transaction['categorie']) ?></td>
                                    <td><?= htmlspecialchars($transaction['description']) ?></td>
                                    <td><?= htmlspecialchars($transaction['compte']) ?></td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Vous n'avez aucune transaction enregistrée.</p>
                <?php endif; ?>
                <a href="../controleur/list_transactions.php" class="btn btn-more">Voir mes transactions</a>
                <a href="../controleur/ajouter_transaction.php" class="btn btn-add">Ajouter une transaction</a>
            </section>

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
                            $limit = 5;
                            $count = 0;
                            foreach ($categories as $categorie):
                                if ($count >= $limit) break;
                                $count++;
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
                    <?php if (count($categories) > $limit): ?>
                        <a href="../controleur/list_categories.php" class="btn btn-more">Voir plus de catégories</a>
                    <?php endif; ?>

                <?php else: ?>
                    <p>Vous n'avez aucune catégorie enregistrée.</p>
                <?php endif; ?>

                <a href="../controleur/ajouter_categorie.php" class="btn btn-add">Ajouter une catégorie</a>
            </section>


        </div>

    </div>

</body>

</html>