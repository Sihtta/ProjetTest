<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['is_admin'] ? "Les Factures" : "Mes Factures"; ?></title>
    <link rel="stylesheet" href="../vue/css/inventaire.css">
    <link rel="stylesheet" href="../vue/css/facture_edit.css">
</head>
<body>
    <h2 style="text-align:center; color: #8a2be2;"><?php echo $_SESSION['is_admin'] ? "Les Factures" : "Mes Factures"; ?></h2>

    <div id="message" style="text-align: center; color: green;">
        <?php 
        if (isset($_SESSION['maj_message'])) {
            echo $_SESSION['maj_message'];
            unset($_SESSION['maj_message']); 
        }
        ?>
    </div>

    <table>
        <tr>
            <th>Numéro de Facture</th>
            <?php if ($_SESSION['is_admin']): ?>
                <th>ID Client</th>
            <?php endif; ?>
            <th>Date de Facture</th>
            <th>Commentaire</th>
            <th>Taux de Remise</th>
            <th>Forfait Livraison</th>
            <th>Montant Forfait</th>
            <th>Produits</th>
            <?php if ($_SESSION['is_admin']): ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>
        <?php foreach ($factures as $facture): ?>
            <tr>
                <td><?= $facture['num_fact']; ?></td>
                <?php if ($_SESSION['is_admin']): ?>
                    <td><?= $facture['id_cli']; ?></td>
                <?php endif; ?>
                <td><?= $facture['date_fact']; ?></td>
                <td><?= $facture['comment_fact']; ?></td>
                <td><?= $facture['taux_remise_fact']; ?>%</td>
                <td><?= $facture['lib_forfait']; ?></td>
                <td><?= $facture['mt_forfait']; ?> €</td>
                <td>
                    <table>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Tarif Unitaire</th>
                        </tr>
                        <?php if (!empty($facture['produits'])): ?>
                            <?php foreach ($facture['produits'] as $produit): ?>
                                <tr>
                                    <td><?= $produit['lib_prod']; ?></td>
                                    <td><?= $produit['qte_prod']; ?></td>
                                    <td><?= number_format($produit['tarif_ht'], 2); ?> €</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">Aucun produit pour cette facture.</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </td>
                <?php if ($_SESSION['is_admin']): ?>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="delete_facture_id" value="<?= $facture['num_fact']; ?>">
                            <button type="submit"><img src="../vue/img/annuler.png" alt="Supprimer" style="width:20px; height:20px;"></button>
                        </form>

                        <a href="../vue/modifier_facture.view.php?num_fact=<?= $facture['num_fact']; ?>">
                            <button><img src="../vue/img/modification.png" alt="Supprimer" style="width:20px; height:20px;"></button>
                        </a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($_SESSION['is_admin']): ?>
        <div class="div-btn">
            <button class="btn-action" onclick="window.location.href = '../vue/ajouter_facture.view.php'">Ajouter une Facture</button>
        </div>
        <div class="div-btn">
            <button id="update_catalogue" class="btn-action" type="button">Mettre à jour le catalogue</button>
        </div>
    <?php endif; ?>

    <p style="text-align:right;"><a href="../controleur/logout.php">Déconnexion</a></p>

    <script>
        document.getElementById('update_catalogue')?.addEventListener('click', async () => {

        const messageElement = document.getElementById('message');
        if (messageElement) {  
            messageElement.innerHTML = 'Mise à jour en cours...';
        }

        try {
            const response = await fetch('../modele/maj_catalogue.php', {
                method: 'POST',
                body: new URLSearchParams({ maj_catalogue: 'true' }),  
            });

            const jsonResponse = await response.json();
            if (jsonResponse.message) {
                if (messageElement) {
                    messageElement.innerHTML = jsonResponse.message;
                }
            } else {
                if (messageElement) {
                    messageElement.innerHTML = 'Erreur lors de la mise à jour.';
                }
            }
        } catch (error) {
            console.error('Erreur Fetch:', error);
            if (messageElement) {
                messageElement.innerHTML = 'Erreur lors de la mise à jour.';
            }
        }
        });

    </script>

</body>
</html>