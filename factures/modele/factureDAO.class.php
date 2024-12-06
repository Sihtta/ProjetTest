<?php
require_once("connexion.php");
require_once("facture.class.php");

class FactureDAO {
    private $connexion;

    public function __construct() {
        $this->connexion = new Connexion();
    }

    public function addFacture(Facture $facture): bool {
        $sql = "INSERT INTO facture (date_fact, comment_fact, taux_remise_fact, id_cli, id_forfait)
                VALUES (:date_fact, :comment_fact, :taux_remise_fact, :id_cli, :id_forfait)";
        
        $params = [
            ':date_fact' => $facture->getDateFact(),
            ':comment_fact' => $facture->getCommentFact(),
            ':taux_remise_fact' => $facture->getTauxRemiseFact(),
            ':id_cli' => $facture->getIdCli(),
            ':id_forfait' => $facture->getIdForfait()
        ];

        $stmt = $this->connexion->getPDO()->prepare($sql);
        return $stmt->execute($params);
    }

    public function getFactureByNum($num_fact) {
        $sql = "SELECT * FROM facture WHERE num_fact = :num_fact";
        $params = [':num_fact' => $num_fact];
        $stmt = $this->connexion->getPDO()->prepare($sql);
        $stmt->execute($params);
        $factureData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($factureData) {
            return $factureData;
        } else {
            return null;
        }
    }

    public function updateFacture(Facture $facture): bool {
        $sql = "UPDATE facture 
                SET date_fact = :date_fact, 
                    comment_fact = :comment_fact, 
                    taux_remise_fact = :taux_remise_fact, 
                    id_cli = :id_cli, 
                    id_forfait = :id_forfait
                WHERE num_fact = :num_fact";
    
        $params = [
            ':date_fact' => $facture->getDateFact(),
            ':comment_fact' => $facture->getCommentFact(),
            ':taux_remise_fact' => $facture->getTauxRemiseFact(),
            ':id_cli' => $facture->getIdCli(),
            ':id_forfait' => $facture->getIdForfait(),
            ':num_fact' => $facture->getNumFact()
        ];
    
        $stmt = $this->connexion->getPDO()->prepare($sql);
        return $stmt->execute($params);
    }
}
?>
