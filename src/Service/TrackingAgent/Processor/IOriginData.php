<?php

namespace App\Service\TrackingAgent\Processor;

interface IOriginData
{
    public function getTrackingNumber(): string;
    public function getCarrierCode(): string;
    public function getOriginData(): array;
}
