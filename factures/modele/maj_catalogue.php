<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once('connexion.php'); 

    $jsonFilePath = '../ressources/catalogue.json';  

    if (!file_exists($jsonFilePath)) {
        echo json_encode(["message" => "Erreur : le fichier JSON est introuvable à $jsonFilePath"]);
        exit;
    }

    $jsonData = file_get_contents($jsonFilePath);
    if ($jsonData === false) {
        echo json_encode(["message" => "Erreur de lecture du fichier JSON"]);
        exit;
    }

    $data = json_decode($jsonData, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["message" => "Erreur de décodage JSON : " . json_last_error_msg()]);
        exit;
    }

    $connexion = new Connexion(); 

    foreach ($data as $item) {
        if (isset($item['suppr'])) {
            foreach ($item['suppr'] as $code_prod) {
                $stmt = "DELETE FROM produit WHERE code_prod = :code_prod";
                $connexion->execSQL($stmt, ['code_prod' => $code_prod]);
            }
        } else {
            if (isset($item['code'])) {
                $code_prod = $item['code'];
                $stmt = "SELECT COUNT(*) FROM produit WHERE code_prod = :code_prod";
                $result = $connexion->execSQL($stmt, ['code_prod' => $code_prod]);
                
                if ($result[0]['COUNT(*)'] > 0) {
                    if (isset($item['tarif'])) {
                        $stmt = "UPDATE produit SET tarif_ht = :tarif WHERE code_prod = :code_prod";
                        $connexion->execSQL($stmt, ['tarif' => $item['tarif'], 'code_prod' => $code_prod]);
                    }
                } else {
                    if (isset($item['lib'], $item['type'], $item['pays'], $item['cond'], $item['tarif'])) {
                        $stmt = "INSERT INTO produit (code_prod, lib_prod, type, origine, conditionnement, tarif_ht)
                                 VALUES (:code_prod, :lib_prod, :type, :origine, :conditionnement, :tarif_ht)";
                        $connexion->execSQL($stmt, [
                            'code_prod' => $item['code'],
                            'lib_prod' => $item['lib'],
                            'type' => $item['type'],
                            'origine' => $item['pays'],
                            'conditionnement' => $item['cond'],
                            'tarif_ht' => $item['tarif']
                        ]);
                    }
                }
            }
        }
    }

    echo json_encode(["message" => "Mise à jour effectuée"]);
} else {
    echo json_encode(["message" => "Erreur : la méthode de requête doit être POST."]);
}
?>
