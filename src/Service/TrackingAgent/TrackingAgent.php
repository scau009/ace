<?php

namespace App\Service\TrackingAgent;

use App\Service\TrackingAgent\Model\TrackingResult;

interface TrackingAgent
{
    /**
     * @return string
     */
    public function getCode(): string;

    public function register(string $trackingNo, string $carrierCode): string;

    public function getTracking(string $trackingNo): ?TrackingResult;

    /**
     * @return TrackingResult[]
     */
    public function batchGetTracking(array $trackingNos): array;
}
