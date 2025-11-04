<?php

namespace App\Service\TrackingAgent\Processor;

use App\Service\TrackingAgent\Model\TrackingResult;

interface IProcessor
{
    public function supports(IOriginData $originData): bool;

    public function process(IOriginData $originData): TrackingResult;
}
