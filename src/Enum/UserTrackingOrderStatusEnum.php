<?php

namespace App\Enum;

enum UserTrackingOrderStatusEnum: int
{
    case Pending = 1000;

    case Tracking = 2000;

    case Completed = 3000;

    case Cancelled = 4000;

    case Failed = 5000;

    public static function finished(): array
    {
        return [self::Completed->value, self::Cancelled->value, self::Failed->value];
    }

    public function label(): string
    {
        return match ($this) {
            self::Pending => '待跟踪',
            self::Tracking => '跟踪中',
            self::Completed => '已完成',
            self::Cancelled => '已取消',
            self::Failed => '跟踪失败',
        };
    }
}
