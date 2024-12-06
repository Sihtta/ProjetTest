<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../vue/login.view.php");
    exit();
}

include '../modele/connexion.php';

function estAdmin($login): bool
{
    $connexion = new Connexion();
    $req = "SELECT role FROM client WHERE login = :login";
    $resultat = $connexion->execSQL($req, ['login' => $login]);
    return !empty($resultat) && $resultat[0]['role'] === 'admin';
}

$_SESSION['is_admin'] = estAdmin($_SESSION['login']);

function obtenirFactures($login): array
{
    try {
        $connexion = new Connexion();
        
        if ($_SESSION['is_admin']) {
            $reqFactures = "SELECT f.*, c.nom_cli, c.prenom_cli, fl.lib_forfait, fl.mt_forfait
                            FROM facture f
                            LEFT JOIN forfait_livraison fl ON f.id_forfait = fl.id_forfait
                            JOIN client c ON f.id_cli = c.id_cli";
            $factures = $connexion->execSQL($reqFactures);
        } else {
            $reqFactures = "SELECT f.*, fl.lib_forfait, fl.mt_forfait 
                            FROM facture f 
                            LEFT JOIN forfait_livraison fl ON f.id_forfait = fl.id_forfait 
                            JOIN client c ON f.id_cli = c.id_cli
                            WHERE c.login = :login";
            $factures = $connexion->execSQL($reqFactures, ['login' => $login]);
        }

        foreach ($factures as &$facture) {
            $reqProduits = "SELECT p.lib_prod, p.tarif_ht, l.qte_prod 
                            FROM ligne l 
                            JOIN produit p ON l.code_prod = p.code_prod 
                            WHERE l.num_fact = :num_fact";
            $produits = $connexion->execSQL($reqProduits, ['num_fact' => $facture['num_fact']]);
            $facture['produits'] = $produits;
        }

        return $factures;
    } catch (Exception $e) {
        die('Erreur lors de la récupération des factures : ' . $e->getMessage());
    }
}

$login = $_SESSION['login'];
$factures = obtenirFactures($login);

if (isset($_POST['delete_facture_id'])) {
    try {
        $factureId = $_POST['delete_facture_id'];
        $connexion = new Connexion();
        $reqDelete = "DELETE FROM facture WHERE num_fact = :factureId";
        $connexion->execSQL($reqDelete, ['factureId' => $factureId]);
        echo json_encode(['message' => 'Facture supprimée avec succès.']);
        header('Location: ../vue/login.view.php');
        exit();
    } catch (Exception $e) {
        echo json_encode(['message' => 'Erreur lors de la suppression de la facture.']);
        exit();
    }
}

if (isset($_POST['update_facture_id'])) {
    try {
        $factureId = $_POST['update_facture_id'];
        $commentaire = $_POST['comment_fact'];
        $tauxRemise = $_POST['taux_remise_fact'];
        $forfait = $_POST['lib_forfait'];
        $montant = $_POST['mt_forfait'];

        $connexion = new Connexion();
        $reqUpdate = "UPDATE facture 
                      SET comment_fact = :commentaire, taux_remise_fact = :tauxRemise, lib_forfait = :forfait, mt_forfait = :montant 
                      WHERE num_fact = :factureId";
        $connexion->execSQL($reqUpdate, [
            'commentaire' => $commentaire,
            'tauxRemise' => $tauxRemise,
            'forfait' => $forfait,
            'montant' => $montant,
            'factureId' => $factureId
        ]);
        echo json_encode(['message' => 'Facture modifiée avec succès.']);
        exit();
    } catch (Exception $e) {
        echo json_encode(['message' => 'Erreur lors de la modification de la facture.']);
        exit();
    }
}

if (isset($_POST['ajouter_facture'])) {
    try {
        $commentaire = $_POST['comment_fact'];
        $tauxRemise = $_POST['taux_remise_fact'];
        $idForfait = $_POST['lib_forfait'];

        $connexion = new Connexion();

        $reqInsert = "INSERT INTO facture (comment_fact, taux_remise_fact, id_forfait) 
                      VALUES (:commentaire, :tauxRemise, :idForfait)";
        $connexion->execSQL($reqInsert, [
            'commentaire' => $commentaire,
            'tauxRemise' => $tauxRemise,
            'idForfait' => $idForfait
        ]);

        header("Location: ../vue/facture.php");
        exit();
    } catch (Exception $e) {
        header("Location: ../vue/ajouter_facture.php?error=ajout_failed");
        exit();
    }
}

include '../vue/facture.view.php';
?>
