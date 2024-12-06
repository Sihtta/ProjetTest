<?php
class Connexion
{
    private $db;

    public function __construct()
    {
        $db_config = [
            'SGBD' => 'mysql',
            'HOST' => 'localhost',
            'DB_NAME' => 'finances_app',
            'USER' => 'root',
            'PASSWORD' => ''
        ];

        try {
            $this->db = new PDO(
                $db_config['SGBD'] . ':host=' . $db_config['HOST'] . ';dbname=' . $db_config['DB_NAME'],
                $db_config['USER'],
                $db_config['PASSWORD'],
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
            );
            unset($db_config);
        } catch (Exception $exception) {
            die('Erreur de connexion à la base de données : ' . $exception->getMessage());
        }
    }

    public function execSQL(string $req, array $valeurs = []): array
    {
        try {
            $stmt = $this->db->prepare($req);
            $stmt->execute($valeurs);
            $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultats;
        } catch (PDOException $e) {
            die('Erreur lors de l\'exécution de la requête : ' . $e->getMessage());
        }
    }

    public function getPDO()
    {
        return $this->db;
    }

    public function mettreAJourSolde(int $id_compte): void
    {
        try {
            $reqUpdateSolde = "
            UPDATE compte_bancaire
            SET solde = (
                SELECT IFNULL(SUM(montant), 0)
                FROM transactions
                WHERE id_compte = :id_compte
            )
            WHERE id_compte = :id_compte";
            $this->execSQL($reqUpdateSolde, ['id_compte' => $id_compte]);
        } catch (Exception $e) {
            die("Erreur lors de la mise à jour du solde : " . $e->getMessage());
        }
    }
}
