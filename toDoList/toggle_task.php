<?php
if (isset($_GET['id'])) {
    $taskId = $_GET['id'];
    $tasks = json_decode(file_get_contents('tasks.json'), true);

    foreach ($tasks as $key => $task) {
        if ($task['id'] == $taskId) {
            $tasks[$key]['statut'] = ($task['statut'] === "complete") ? "incomplete" : "complete";
        }
    }

    file_put_contents('tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
}

header('Location: toDoList.php');
exit();
