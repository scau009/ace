<?php

namespace App\Service\TrackingAgent\Model;

abstract class TrackingResult
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

    public function setTrackingNo(string $trackingNo): void
    {
        $this->trackingNo = $trackingNo;
    }

    public function getCarrierCode(): string
    {
        return $this->carrierCode;
    }

    public function setCarrierCode(string $carrierCode): void
    {
        $this->carrierCode = $carrierCode;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function setDetails(array $details): void
    {
        $this->details = $details;
    }

    public function getLastUpdateAt(): ?\DateTime
    {
        return $this->lastUpdateAt;
    }

    public function setLastUpdateAt(?\DateTime $lastUpdateAt): void
    {
        $this->lastUpdateAt = $lastUpdateAt;
    }
}
