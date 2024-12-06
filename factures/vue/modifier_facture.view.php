<?php
require_once '../modele/clientDAO.class.php';
require_once '../modele/forfaitDAO.class.php';
require_once '../modele/factureDAO.class.php';
require_once '../modele/facture.class.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $clientDAO = new ClientDAO();
    $forfaitDAO = new ForfaitDAO();
    $factureDAO = new FactureDAO();

    if (isset($_GET['num_fact'])) {
        $num_fact = $_GET['num_fact'];

        $facture = $factureDAO->getFactureByNum($num_fact);
        if (!$facture) {
            echo "Facture introuvable.";
            exit();
        }

        $clients = $clientDAO->getAllClients();
        $forfaits = $forfaitDAO->getAllForfaits();
    } else {
        echo "Numéro de facture manquant.";
        exit();
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Facture</title>
    <link rel="stylesheet" href="../vue/css/inventaire.css">
    <link rel="stylesheet" href="../vue/css/facture_edit.css">
</head>
<body>
    <h2 style="text-align:center; color: #8a2be2;">Modifier la Facture</h2>

    <div id="message" style="text-align: center; color: red;">
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 'client_not_found') {
            echo "Le client sélectionné n'existe pas.";
        }
        ?>
    </div>

    <form action="../controleur/modifier_facture.php" method="POST" style="max-width: 800px; margin: auto;">
        <input type="hidden" name="num_fact" value="<?= $facture['num_fact']; ?>">

        <div class="facture_sous_rubrique">
            <label for="id_cli">Client :</label>
            <select id="id_cli" name="id_cli" required>
                <?php
                foreach ($clients as $client) {
                    $selected = ($client->getIdCli() == $facture['id_cli']) ? 'selected' : '';
                    echo "<option value='" . $client->getIdCli() . "' $selected>" . $client->getNomCli() . " " . $client->getPrenomCli() . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="facture_sous_rubrique">
            <label for="commentaire">Commentaire :</label>
            <textarea id="commentaire" name="commentaire" required><?= $facture['comment_fact']; ?></textarea>
        </div>

        <div class="facture_sous_rubrique">
            <label for="tauxRemise">Taux de remise (%):</label>
            <input type="number" id="tauxRemise" name="tauxRemise" value="<?= $facture['taux_remise_fact']; ?>" min="0" max="100" step="0.01" required>
        </div>

        <div class="facture_sous_rubrique">
            <label for="idForfait">Forfait :</label>
            <select id="idForfait" name="idForfait" required>
                <?php
                foreach ($forfaits as $forfait) {
                    $selected = ($forfait->getIdForfait() == $facture['id_forfait']) ? 'selected' : '';
                    echo "<option value='" . $forfait->getIdForfait() . "' $selected>" . $forfait->getLibForfait() . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="facture_sous_rubrique">
            <label for="dateFact">Date de Facture :</label>
            <input type="date" id="dateFact" name="dateFact" value="<?= $facture['date_fact']; ?>" required>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" id="btn_equipement_valider"></button>
            <button type="button" id="btn_equipement_annuler" onclick="window.location.href='../vue/login.view.php'"></button>
        </div>
    </form>
</body>
</html>
