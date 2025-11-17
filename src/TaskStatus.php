<?php
declare(strict_types=1);

namespace HtmlAcademy;

enum TaskStatus: string
{
    case NEW = 'new';
    case CANCELED = 'canceled';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case FAILED = 'failed';

    public function statusMatchingRu(): string
    {
        return match ($this) {
            self::NEW => 'Новое',
            self::CANCELED => 'Отменено',
            self::IN_PROGRESS => 'В работе',
            self::COMPLETED => 'Выполнено',
            self::FAILED => 'Провалено',
        };
    }
}
