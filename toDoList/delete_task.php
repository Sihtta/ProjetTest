<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $tasks = json_decode(file_get_contents('tasks.json'), true);

    $tasks = array_filter($tasks, function ($task) use ($id) {
        return $task['id'] !== $id;
    });

    file_put_contents('tasks.json', json_encode(array_values($tasks)));
}

header("Location: toDoList.php");
exit();
