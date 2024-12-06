<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="login-form">
        <h2>Authentification</h2>

        <form action="../controleur/login.php" method="POST">
            <label for="login">Numéro d'Utilisateur :</label>
            <input type="text" id="login" name="login" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Connexion</button>

            <a href='../controleur/inscription.php'> Pas encore de compte? Inscrivez-vous. </a>

            <?php
            if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <p class="error">Identification incorrecte. Essayez de nouveau.</p>
            <?php endif; ?>

        </form>
    </div>

</body>

<a href="../../projets.php" class="btn menu">Menu</a>


</html>