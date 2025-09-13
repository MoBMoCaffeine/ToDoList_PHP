<?php
$filename = __DIR__ . '/todos.txt';

function loadTodos($filename) {
    if (file_exists($filename)) {
        return file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
    return [];
}

function saveTodos($filename, $todos) {
    file_put_contents($filename, implode(PHP_EOL, $todos) . PHP_EOL, LOCK_EX);
}

while (true) {
    echo "\n============================\n";
    echo "📋 To-Do List - PHP\n";
    echo "1) Veiw tasks\n";
    echo "2) Add task to do\n";
    echo "3) Delete task\n";
    echo "4) exit\n";
    echo "choose what to do: ";

    $choice = trim(fgets(STDIN));

    switch ($choice) {
        case "1":
            $todos = loadTodos($filename);
            if ($todos) {
                echo "=== Task List ===\n";
                foreach ($todos as $i => $t) {
                    echo ($i + 1) . ". $t\n";
                }
            } else {
                echo "There is nothing to do.\n";
            }
            break;

        case "2":
            echo "Write the task to do: ";
            $task = trim(fgets(STDIN));
            if ($task !== '') {
                $todos = loadTodos($filename);
                $todos[] = $task;
                saveTodos($filename, $todos);
                echo "Task added successfully.\n";
            } else {
                echo "ERROR: empty input!.\n";
            }
            break;

        case "3":
            $todos = loadTodos($filename);
            if (!$todos) {
                echo "there is nothing to remove.\n";
                break;
            }
            foreach ($todos as $i => $t) {
                echo ($i + 1) . ". $t\n";
            }
            echo "enter the index of task you would remove: ";
            $index = (int)trim(fgets(STDIN)) - 1;
            if (isset($todos[$index])) {
                $removed = $todos[$index];
                unset($todos[$index]);
                $todos = array_values($todos); 
                saveTodos($filename, $todos);
                echo "removed: $removed\n";
            } else {
                echo "ERROR: wrong index.\n";
            }
            break;

        case "4":
            echo "SEE YOU SOON!\n\n";
            exit;

        default:
            echo "ERROR: wrong choice.\n";
    }
}
