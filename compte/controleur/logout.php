<?php
session_start();

// Supprime toutes les variables de session
session_unset();

// Détruit la session
session_destroy();

header("Location: ../vue/login.view.php");
exit();
