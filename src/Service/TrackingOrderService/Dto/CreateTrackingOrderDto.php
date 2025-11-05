<?php

namespace App\Service\TrackingOrderService\Dto;

class CreateTrackingOrderDto
{
    private int $userId = 0;
    private string $agentCode = '';
    private string $carrierCode = '';
    private string $carrierName = '';
    private string $trackingNumber = '';

    private bool $asyncTrack = true;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): CreateTrackingOrderDto
    {
        $this->userId = $userId;
        return $this;
    }

    public function getAgentCode(): string
    {
        return $this->agentCode;
    }

    public function setAgentCode(string $agentCode): CreateTrackingOrderDto
    {
        $this->agentCode = $agentCode;
        return $this;
    }

    public function getCarrierCode(): string
    {
        return $this->carrierCode;
    }

    public function setCarrierCode(string $carrierCode): CreateTrackingOrderDto
    {
        $this->carrierCode = $carrierCode;
        return $this;
    }

    public function getCarrierName(): string
    {
        return $this->carrierName;
    }

    public function setCarrierName(string $carrierName): CreateTrackingOrderDto
    {
        $this->carrierName = $carrierName;
        return $this;
    }

    public function getTrackingNumber(): string
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber(string $trackingNumber): CreateTrackingOrderDto
    {
        $this->trackingNumber = $trackingNumber;
        return $this;
    }

    public function isAsyncTrack(): bool
    {
        return $this->asyncTrack;
    }

    public function setAsyncTrack(bool $asyncTrack): CreateTrackingOrderDto
    {
        $this->asyncTrack = $asyncTrack;
        return $this;
    }
}
