<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../compte/vue/login.view.php?error=1");
    exit();
}

include '../modele/connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $connexion = new Connexion();

        // Vérifiez si une transaction a été sélectionnée
        if (isset($_POST['transaction_id']) && !empty($_POST['transaction_id'])) {
            $transactionId = $_POST['transaction_id'];

            $reqTransaction = "SELECT montant, type, id_compte FROM transactions WHERE id = ?";
            $transaction = $connexion->execSQL($reqTransaction, [$transactionId]);

            if (empty($transaction)) {
                header("Location: ../controleur/list_transactions.php?error=Transaction introuvable.");
                exit();
            }

            $transaction = $transaction[0];
            $montant = $transaction['montant'];
            $type = $transaction['type'];
            $idCompte = $transaction['id_compte'];

            // Calculer l'ajustement du solde en fonction du type de la transaction
            $ajustement = ($type === 'debit') ? $montant : -$montant;

            // Supprimer la transaction
            $reqDelete = "DELETE FROM transactions WHERE id = ?";
            $connexion->execSQL($reqDelete, [$transactionId]);

            // Mettre à jour le solde du compte associé
            $reqUpdateSolde = "UPDATE compte_bancaire SET solde = solde + ? WHERE id_compte = ?";
            $connexion->execSQL($reqUpdateSolde, [$ajustement, $idCompte]);

            header("Location: ../controleur/list_transactions.php?success=1");
            exit();
        } else {
            header("Location: ../controleur/list_transactions.php?error=Aucune transaction sélectionnée.");
            exit();
        }
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
} else {
    header("Location: ../controleur/list_transactions.php");
    exit();
}
