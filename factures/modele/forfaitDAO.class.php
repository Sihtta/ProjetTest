<?php
require_once("connexion.php");
require_once("forfait.class.php");

class ForfaitDAO {
    private $connexion;

    public function __construct() {
        $this->connexion = new Connexion();
    }

    public function getAllForfaits() {
        $sql = "SELECT id_forfait, lib_forfait, mt_forfait FROM forfait_livraison";
        $stmt = $this->connexion->getPDO()->query($sql);
        
        $forfaits = [];
        while ($row = $stmt->fetch()) {
            $forfaits[] = new ForfaitLivraison(
                $row['id_forfait'],
                $row['lib_forfait'],
                $row['mt_forfait']
            );
        }
        return $forfaits;
    }

    public function getForfaitById($idForfait) {
        $sql = "SELECT * FROM forfait_livraison WHERE id_forfait = :idForfait";
        $stmt = $this->connexion->getPDO()->prepare($sql);
        $stmt->execute([':idForfait' => $idForfait]);
        
        $row = $stmt->fetch();
        if ($row) {
            return new ForfaitLivraison(
                $row['id_forfait'],
                $row['lib_forfait'],
                $row['mt_forfait']
            );
        }
        return null;
    }
}
?>
