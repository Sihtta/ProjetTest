<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: compte/vue/login.view.php"); // Redirection si non connecté
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My App</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <div class="container">
        <div class="content">

            <header>
                <h1>Bienvenue sur mon App</h1>
                <p>Connecté en tant que : <?php echo $_SESSION['login']; ?></p>
            </header>

            <main>
                <section class="projects">
                    <h2>Projets</h2>
                    <div class="project-list">
                        <div class="card">
                            <h3>To Do List</h3>
                            <p>Organisez vos tâches facilement.</p>
                            <a href="toDoList/toDoList.php" class="btn btn-primary">Accéder</a>
                        </div>
                        <div class="card">
                            <h3>Finances App</h3>
                            <p>Suivez et gérez vos finances.</p>
                            <a href="financesApp/vue/index.php" class="btn btn-primary">Accéder</a>
                        </div>
                        <div class="card">
                            <h3>Factures</h3>
                            <p>Gestion des factures pour votre entreprise.</p>
                            <a href="factures/vue/login.view.php" class="btn btn-primary">Accéder</a>
                        </div>
                        <div class="card">
                            <h3>Atari</h3>
                            <p>Découvrez les jeux vidéos retro.</p>
                            <a href="atari/index.html" class="btn btn-primary">Accéder</a>
                        </div>
                    </div>
                </section>
            </main>

            <a href="index.html" class="btn btn-info" style="margin-top: 20px;">Se deconnecter</a>
        </div>

    </div>
</body>

</html>