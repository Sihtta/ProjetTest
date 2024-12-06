<?php
require_once '../modele/clientDAO.class.php';
require_once '../modele/forfaitDAO.class.php';
require_once '../modele/factureDAO.class.php';
require_once '../modele/facture.class.php';

try {
    $clientDAO = new ClientDAO();
    $forfaitDAO = new ForfaitDAO();
    $factureDAO = new FactureDAO();

    if (isset($_POST['num_fact'], $_POST['id_cli'], $_POST['idForfait'], $_POST['commentaire'], $_POST['tauxRemise'], $_POST['dateFact'])) {
        
        $num_fact = $_POST['num_fact'];
        $clientId = $_POST['id_cli'];
        $forfaitId = $_POST['idForfait'];
        $commentaire = $_POST['commentaire'];
        $tauxRemise = $_POST['tauxRemise'];
        $dateFact = $_POST['dateFact'];

        $client = $clientDAO->getClientById($clientId);
        if (!$client) {
            header("Location: ../vue/modifier_facture.view.php?num_fact=$num_fact&error=client_not_found");
            exit();
        }

        $forfait = $forfaitDAO->getForfaitById($forfaitId);
        if (!$forfait) {
            header("Location: ../vue/modifier_facture.view.php?num_fact=$num_fact&error=forfait_not_found");
            exit();
        }

        $facture = new Facture(
            $num_fact,           
            $dateFact,           
            $commentaire,        
            $tauxRemise,         
            $clientId,           
            $forfaitId           
        );

        if ($factureDAO->updateFacture($facture)) {
            header("Location: ../controleur/facture.php");
        } else {
            header("Location: ../vue/modifier_facture.view.php?num_fact=$num_fact&error=update_failed");
            exit();
        }
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    exit();
}
?>
