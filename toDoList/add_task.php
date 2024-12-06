<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = trim($_POST['task']);

    if (!empty($task)) {
        $tasks = json_decode(file_get_contents('tasks.json'), true);

        $tasks[] = ["id" => uniqid(), "tâche" => $task, "statut" => "incomplete"];

        file_put_contents('tasks.json', json_encode($tasks));
    }
}

header("Location: toDoList.php");
exit();
