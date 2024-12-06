<?php
include 'connexion.php';

try {
    $c = new Connexion();
    echo "Connexion à la base de données réussie ! ";  
    
    $resultats = $c->execSQL("SELECT * FROM utilisateur LIMIT 5"); 
    if ($resultats) {
        echo "Requête exécutée avec succès ! ";
    } else {
        echo "Aucun résultat trouvé.";
    }

} catch (Exception $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();  
}
?>
