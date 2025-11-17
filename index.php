<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

// 2. Используем namespace (если нужно)
use HtmlAcademy\Task;
use HtmlAcademy\TaskAction;

$task = new Task(123, 456);

echo "Текущий статус: " . $task->getCurrentStatus()->value . "\n";

$actions = $task->getAvailableActions();
echo "Доступные действия: ";
foreach ($actions as $action) {
    echo $action->value . " ";
}
echo "\n";

$nextStatus = $task->getNextStatus(TaskAction::RESPOND);
echo "Следующий статус после RESPOND: " . $nextStatus->value . "\n";
