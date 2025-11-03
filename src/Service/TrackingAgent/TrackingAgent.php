<?php

namespace App\Service\TrackingAgent;

use App\Service\TrackingAgent\Model\TrackingResult;

interface TrackingAgent
{
    public function register(string $trackingNo, string $carrierCode): void;

    public function getTracking(string $trackingNo): ?TrackingResult;

    /**
     * @return TrackingResult[]
     */
    public function batchGetTracking(array $trackingNos): array;
}
