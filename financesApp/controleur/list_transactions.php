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

    // Requête pour récupérer les transactions, triées par date
    $reqTransactions = "
        SELECT t.*, cb.libelle AS compte, c.nom AS categorie
        FROM transactions t
        INNER JOIN compte_bancaire cb ON t.id_compte = cb.id_compte
        INNER JOIN categories c ON t.categorie = c.id
        WHERE cb.id_client = :id_client
        ORDER BY t.date DESC";
    $transactions = $connexion->execSQL($reqTransactions, ['id_client' => $id_client]);
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

        <style>
            .container button {
                color: #1B1B1B;
                margin-bottom: 15px;
                padding: 8px;
                width: 30%;
            }
        </style>
    </header>

    <div class="container">
        <div class="content">

            <section>
                <h2>Vos Transactions</h2>
                <?php if (!empty($transactions)): ?>
                    <form method="POST" action="../controleur/supprimer_transaction.php">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>Sélection</th>
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
                                        <td>
                                            <input type="radio" name="transaction_id" value="<?= htmlspecialchars($transaction['id']) ?>">
                                        </td>
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
                        <button type="submit" class="btn btn-delete">Supprimer la transaction</button>
                        <button type="submit" formaction="../controleur/modifier_transaction.php" class="btn btn-edit">Modifier la transaction</button>
                        <button type="submit" formaction="../controleur/ajouter_transaction.php" class="btn btn-add">Ajouter une transaction</button>
                    </form>

                <?php else: ?>
                    <p>Vous n'avez aucune transaction enregistrée.</p>
                <?php endif; ?>

            </section>


        </div>
    </div>
    <script>
        document.querySelector('.btn-delete').addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer les transactions sélectionnées ?')) {
                e.preventDefault();
            }
        });
    </script>

</body>

</html>