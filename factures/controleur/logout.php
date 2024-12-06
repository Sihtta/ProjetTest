<?php
session_start();

// Supprime toutes les variables de session
session_unset();

// Détruit la session
session_destroy();

// Redirection vers la page de connexion sans le paramètre "error"
header("Location: ../vue/login.view.php");
exit();
