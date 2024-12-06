<?php
require_once("connexion.php");
require_once("client.class.php");

class ClientDAO {
    private $connexion;

    public function __construct() {
        $this->connexion = new Connexion();
    }

    public function getClientById(int $idCli): ?Client {
        $sql = "SELECT * FROM client WHERE id_cli = :idCli";
        $stmt = $this->connexion->getPDO()->prepare($sql);
        $stmt->execute([':idCli' => $idCli]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new Client(
                $result['id_cli'],
                $result['civ_cli'],
                $result['nom_cli'],
                $result['prenom_cli'],
                $result['tel_cli'],
                $result['mel_cli'],
                $result['adr_cli'],
                $result['cp_cli'],
                $result['commune_cli'],
                (float)$result['tauxmax_remise_cli'],
                $result['mot_de_passe']
            );
        }
        return null;
    }

    public function getAllClients(): array {
        $sql = "SELECT * FROM client";
        $stmt = $this->connexion->getPDO()->query($sql);

        $clients = [];
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $clients[] = new Client(
                $result['id_cli'],
                $result['civ_cli'],
                $result['nom_cli'],
                $result['prenom_cli'],
                $result['tel_cli'],
                $result['mel_cli'],
                $result['adr_cli'],
                $result['cp_cli'],
                $result['commune_cli'],
                (float)$result['tauxmax_remise_cli'],
                $result['mot_de_passe']
            );
        }
        return $clients;
    }
}
?>