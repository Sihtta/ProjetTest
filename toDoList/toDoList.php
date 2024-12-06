<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/toDoListStyle.css">
    <script>
        function toggleTaskSelection() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const deleteButton = document.getElementById('deleteSelected');
            const completeButton = document.getElementById('completeSelected');
            let checkedCount = 0;

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    checkedCount++;
                }
            });

            deleteButton.style.display = checkedCount >= 2 ? 'block' : 'none';
            completeButton.style.display = checkedCount >= 2 ? 'block' : 'none';
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center text-purple">Ma To-Do List</h2>
        <form action="add_task.php" method="POST" class="form-inline justify-content-center mb-4">
            <input type="text" name="task" class="form-control mr-2" placeholder="Nouvelle tâche..." required>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>

        <form action="delete_selected.php" method="POST">
            <div class="form-group">
                <ul class="list-group">
                    <?php
                    $tasks = json_decode(file_get_contents('tasks.json'), true);

                    if ($tasks === null) {
                        $tasks = [];
                    }

                    foreach ($tasks as $task) {
                        $isComplete = $task['statut'] == "complete";
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center " . ($isComplete ? 'bg-custom-gray' : '') . "'>";
                        echo "<input type='checkbox' name='task_ids[]' value='" . $task['id'] . "' class='mr-2' onchange='toggleTaskSelection()'>";
                        echo $isComplete ? "<s>" . htmlspecialchars($task['tâche']) . "</s>" : htmlspecialchars($task['tâche']);
                        echo "<div>";
                        echo "<a href='toggle_task.php?id=" . $task['id'] . "' class='btn btn-info btn-sm mx-1'>Terminer</a>";
                        echo "<a href='delete_task.php?id=" . $task['id'] . "' class='btn btn-danger btn-sm'>Supprimer</a>";
                        echo "</div>";
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="d-flex justify-content-center mb-4">
                <button type="submit" class="btn btn-danger" id="deleteSelected" style="display: none;">Supprimer Sélectionnées</button>
                <button type="submit" formaction="complete_selected.php" class="btn btn-info mx-2" id="completeSelected" style="display: none;">Terminer Sélectionnées</button>
            </div>
        </form>

    </div>

    <a href="../projets.php" class="btn menu">Accueil</a>
</body>

</html>