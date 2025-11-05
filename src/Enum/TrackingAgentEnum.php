<?php

namespace App\Enum;

enum TrackingAgentEnum: string
{
    case TrackingMore = 'tracking_more';
    case OneSevenTracking = '17_tracking';

    public function getAgentClass(): string
    {
        return match ($this) {
            self::TrackingMore => \App\Service\TrackingAgent\Agent\TrackingMore\Agent::class,
            self::OneSevenTracking => \App\Service\TrackingAgent\Agent\OneSevenTracking\Agent::class
        };
    }
}
