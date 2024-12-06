<?php
require_once '../modele/clientDAO.class.php';
require_once '../modele/forfaitDAO.class.php';
require_once '../modele/factureDAO.class.php';
require_once '../modele/facture.class.php';

try {
    $clientDAO = new ClientDAO();
    $forfaitDAO = new ForfaitDAO();
    $factureDAO = new FactureDAO();

    if (isset($_POST['id_cli'], $_POST['idForfait'], $_POST['commentaire'], $_POST['tauxRemise'], $_POST['dateFact'])) {
        
        $clientId = $_POST['id_cli'];
        $forfaitId = $_POST['idForfait'];
        $commentaire = $_POST['commentaire'];
        $tauxRemise = $_POST['tauxRemise'];
        $dateFact = $_POST['dateFact'];

        $client = $clientDAO->getClientById($clientId);
        if (!$client) {
            header("Location: ../vue/ajouter_facture.view.php?error=client_not_found");
            exit();
        }

        $forfait = $forfaitDAO->getForfaitById($forfaitId);
        if (!$forfait) {
            header("Location: ../vue/ajouter_facture.view.php?error=forfait_not_found");
            exit();
        }

        $facture = new Facture(
            0,                   
            $dateFact,           
            $commentaire,        
            $tauxRemise,         
            $clientId,           
            $forfaitId           
        );

        $sql = "INSERT INTO facture (date_fact, comment_fact, taux_remise_fact, id_forfait, id_cli)
                VALUES (:date_fact, :comment_fact, :taux_remise_fact, :id_forfait, :id_cli)";

        if ($factureDAO->addFacture($facture)) {
            header("Location: ../controleur/facture.php");
        } else {
            header("Location: ../vue/ajouter_facture.view.php?error=add_failed");
            exit();
        }
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    exit();
}
?>
