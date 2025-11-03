<?php

namespace App\Service\TrackingAgent\Model;

class TrackingResult
{
    public string $trackingNo  = '';
    public string $carrierCode = '';

    public string $status = '';

    /**
     * @var TrackingDetailItem[]
     */
    public array $details = [];

    public ?\DateTime $lastUpdateAt = null;

    public function getTrackingNo(): string
    {
        return $this->trackingNo;
    }

    public function setTrackingNo(string $trackingNo): TrackingResult
    {
        $this->trackingNo = $trackingNo;
        return $this;
    }

    public function getCarrierCode(): string
    {
        return $this->carrierCode;
    }

    public function setCarrierCode(string $carrierCode): TrackingResult
    {
        $this->carrierCode = $carrierCode;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): TrackingResult
    {
        $this->status = $status;
        return $this;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function setDetails(array $details): TrackingResult
    {
        $this->details = $details;
        return $this;
    }

    public function getLastUpdateAt(): ?\DateTime
    {
        return $this->lastUpdateAt;
    }

    public function setLastUpdateAt(?\DateTime $lastUpdateAt): TrackingResult
    {
        $this->lastUpdateAt = $lastUpdateAt;
        return $this;
    }


}
