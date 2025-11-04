<?php

namespace App\Service\TrackingAgent\Processor\TrackingMore;

use App\Entity\TrackingMoreResults;
use App\Service\TrackingAgent\Model\TrackingDetailItem;
use App\Service\TrackingAgent\Model\TrackingResult;
use App\Service\TrackingAgent\Processor\IOriginData;
use App\Service\TrackingAgent\Processor\IProcessor;

class Processor implements IProcessor
{
    public function supports(IOriginData $originData): bool
    {
        return $originData instanceof TrackingMoreResults;
    }

    /**
     * @param TrackingMoreResults $originData
     * @return TrackingResult
     */
    public function process(IOriginData $originData): TrackingResult
    {
        $result = new TrackingResult();
        $result->setTrackingNo($originData->getTrackingNumber());
        $result->setCarrierCode($originData->getCarrierCode());
        $rawData = $originData->getOriginData();
        $result->setStatus($rawData['delivery_status']);
        $details = [];
        foreach ($rawData['origin_info']['trackinfo'] as $originTrackInfo) {
           $details[] = (new TrackingDetailItem())
               ->setTime(new \DateTime($originTrackInfo['checkpoint_date']))
               ->setContent($originTrackInfo['tracking_detail']);
        }
        $result->setDetails($details);
        return $result;
    }
}
