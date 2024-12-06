<?php
require_once '../modele/clientDAO.class.php';
require_once '../modele/forfaitDAO.class.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $clientDAO = new ClientDAO();
    $forfaitDAO = new ForfaitDAO();
    $clients = $clientDAO->getAllClients();
    $forfaits = $forfaitDAO->getAllForfaits();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Facture</title>
    <link rel="stylesheet" href="../vue/css/inventaire.css">
    <link rel="stylesheet" href="../vue/css/facture_edit.css">
</head>
<body>
    <h2 style="text-align:center; color: #8a2be2;">Ajouter une Facture</h2>

    <div id="message" style="text-align: center; color: red;">
        <?php 
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 'client_not_found') {
                echo "Le client sélectionné n'existe pas.";
            }
        }
        ?>
    </div>

    <form action="../controleur/ajouter_facture.php" method="POST" style="max-width: 800px; margin: auto;">
        <div class="facture_sous_rubrique">
            <label for="id_cli">Client :</label>
            <select id="id_cli" name="id_cli" required>
                <?php
                if (empty($clients)) {
                    echo "<option disabled>Aucun client disponible</option>";
                } else {
                    foreach ($clients as $client) {
                        echo "<option value='" . $client->getIdCli() . "'>" . $client->getNomCli() . " " . $client->getPrenomCli() . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="facture_sous_rubrique">
            <label for="commentaire">Commentaire :</label>
            <textarea id="commentaire" name="commentaire" required></textarea>
        </div>

        <div class="facture_sous_rubrique">
            <label for="tauxRemise">Taux de remise (%):</label>
            <input type="number" id="tauxRemise" name="tauxRemise" min="0" max="100" step="0.01" required>
        </div>

        <div class="facture_sous_rubrique">
            <label for="idForfait">Forfait :</label>
            <select id="idForfait" name="idForfait" required>
                <?php
                if (empty($forfaits)) {
                    echo "<option disabled>Aucun forfait disponible</option>";
                } else {
                    foreach ($forfaits as $forfait) {
                        echo "<option value='" . $forfait->getIdForfait() . "'>" . $forfait->getLibForfait() . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="facture_sous_rubrique">
            <label for="dateFact">Date de Facture :</label>
            <input type="date" id="dateFact" name="dateFact" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" id="btn_equipement_valider"></button>
            <button type="button" id="btn_equipement_annuler" onclick="window.location.href='../vue/login.view.php'"></button>
        </div>
    </form>
</body>
</html>
