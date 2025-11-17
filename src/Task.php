<?php
declare(strict_types=1);

namespace HtmlAcademy;
class Task
{
    private TaskStatus $currentStatus;
    private ?int $executorId;
    private int $customerId;

    public function __construct(int $customerId, ?int $executorId = null)
    {
        $this->currentStatus = TaskStatus::NEW;
        $this->customerId = $customerId;
        $this->executorId = $executorId;
    }

    public function getAvailableActions(): array
    {
        return match ($this->currentStatus) {
            TaskStatus::NEW => [TaskAction::RESPOND, TaskAction::CANCEL],
            TaskStatus::IN_PROGRESS => [TaskAction::COMPLETE, TaskAction::REFUSE],
            TaskStatus::COMPLETED, TaskStatus::CANCELED, TaskStatus::FAILED => [],
        };
    }

    public function getNextStatus(TaskAction $action): ?TaskStatus
    {
        return match ($action) {
            TaskAction::CANCEL => TaskStatus::CANCELED,
            TaskAction::RESPOND => TaskStatus::IN_PROGRESS,
            TaskAction::COMPLETE => TaskStatus::COMPLETED,
            TaskAction::REFUSE => TaskStatus::FAILED,
            default => null,
        };
    }
    public function getCurrentStatus(): TaskStatus
    {
        return $this->currentStatus;
    }
}

