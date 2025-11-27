<?php
declare(strict_types=1);

namespace HtmlAcademy;

use HtmlAcademy\Actions\AbstractAction;
use HtmlAcademy\Actions\RespondAction;
use HtmlAcademy\Actions\CancelAction;
use HtmlAcademy\Actions\CompleteAction;
use HtmlAcademy\Actions\RefuseAction;
use HtmlAcademy\Enums\TaskStatus;
use HtmlAcademy\Exception\TaskException;

class Task
{
    private TaskStatus $currentStatus;
    private ?int $executorId;
    private int $customerId;

    public function __construct(int $customerId, ?int $executorId = null)
    {

        if ($executorId !== null && $executorId <= 0) {
            throw new TaskException("ID исполнителя должен быть положительным числом или null");
        }

        if ($executorId === $customerId) {
            throw new TaskException("Заказчик и исполнитель не могут быть одним пользователем");
        }

        $this->currentStatus = TaskStatus::NEW;
        $this->customerId = $customerId;
        $this->executorId = $executorId;
    }

    /**
     * Возвращает список доступных действий
     *
     * @param int $currentUserId ID текущего пользователя
     * @return array<AbstractAction> Массив доступных действий
     */
    public function getAvailableActions(int $currentUserId): array
    {
        $actionsByStatus = match ($this->currentStatus) {
            TaskStatus::NEW => [new RespondAction(), new CancelAction()],
            TaskStatus::IN_PROGRESS => [new CompleteAction(), new RefuseAction()],
            TaskStatus::COMPLETED, TaskStatus::CANCELED, TaskStatus::FAILED => [],
        };

        // Фильтруем действия по правам пользователя
        return array_filter(
            $actionsByStatus,
            fn($action) => $action->checkRights(
                $this->executorId,
                $this->customerId,
                $currentUserId
            )
        );
    }

    public function getNextStatus(AbstractAction $action): ?TaskStatus
    {
        return $action->getNextStatus();
    }

    public function getCurrentStatus(): TaskStatus
    {
        return $this->currentStatus;
    }

    public function setStatus(TaskStatus $status): void
    {
        $availableActions = match ($this->currentStatus) {
            TaskStatus::NEW => [new RespondAction(), new CancelAction()],
            TaskStatus::IN_PROGRESS => [new CompleteAction(), new RefuseAction()],
            TaskStatus::COMPLETED, TaskStatus::CANCELED, TaskStatus::FAILED => [],
        };

        $isValidTransition = false;
        foreach ($availableActions as $action) {
            if ($action->getNextStatus() === $status) {
                $isValidTransition = true;
                break;
            }
        }

        if (!$isValidTransition && $this->currentStatus === $status) {
            $isValidTransition = true;
        }

        if (!$isValidTransition) {
            throw new TaskException(
                "Недопустимый переход статуса с {$this->currentStatus->name} на {$status->name}"
            );
        }

        $this->currentStatus = $status;
    }
    public function setExecutorId(int $executorId): void
    {

        if ($executorId === $this->customerId) {
            throw new TaskException("Исполнитель не может быть заказчиком");
        }

        if ($this->executorId !== null && $this->executorId !== $executorId) {
            throw new TaskException("Исполнитель уже назначен и не может быть изменен");
        }
        $this->executorId = $executorId;
    }

    public function getExecutorId(): ?int
    {
        return $this->executorId;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }
}
