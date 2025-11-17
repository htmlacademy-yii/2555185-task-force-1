<?php
declare(strict_types=1);

namespace HtmlAcademy;

enum TaskAction: string
{
    case RESPOND = 'respond';
    case CANCEL = 'cancel';
    case COMPLETE = 'complete';
    case REFUSE = 'refuse';

    public function actionMatchingRu(): string
    {
        return match ($this) {
            self::RESPOND => 'Откликнуться',
            self::CANCEL => 'Отменить',
            self::COMPLETE => 'Выполнено',
            self::REFUSE => 'Отказаться',
        };
    }
}
