<?php
if (isset($_POST['task_ids'])) {
    $task_ids = $_POST['task_ids'];
    $tasks = json_decode(file_get_contents('tasks.json'), true);

    if (empty($task_ids)) {
        echo "Aucune tâche sélectionnée.";
        exit();
    }

    foreach ($tasks as $key => $task) {
        if (in_array($task['id'], $task_ids)) {
            $tasks[$key]['statut'] = "complete";
            echo "Tâche terminée : " . $task['tâche'] . "<br>";
        }
    }

    file_put_contents('tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
}

header('Location: toDoList.php');
exit();
