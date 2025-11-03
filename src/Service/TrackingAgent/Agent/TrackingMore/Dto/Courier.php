<?php

namespace App\Service\TrackingAgent\Agent\TrackingMore\Dto;

use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;

class Courier
{
    private ?string $courierName = '';
    private ?string $courierCode = '';
    private ?string $courierCountryIso2 = '';
    private ?string $courierUrl = '';
    private ?string $courierPhone = '';
    private ?string $courierType = '';
    private ?array $trackingRequiredFields = [];
    private ?array $optionalFields = [];
    private ?string $defaultLanguage = '';
    private ?array $supportLanguage = [];
    private ?string $courierLogo = '';

    public function getCourierName(): ?string
    {
        return $this->courierName;
    }

    public function setCourierName(?string $courierName): void
    {
        $this->courierName = $courierName;
    }

    public function getCourierCode(): ?string
    {
        return $this->courierCode;
    }

    public function setCourierCode(?string $courierCode): void
    {
        $this->courierCode = $courierCode;
    }

    public function getCourierCountryIso2(): ?string
    {
        return $this->courierCountryIso2;
    }

    public function setCourierCountryIso2(?string $courierCountryIso2): void
    {
        $this->courierCountryIso2 = $courierCountryIso2;
    }

    public function getCourierUrl(): ?string
    {
        return $this->courierUrl;
    }

    public function setCourierUrl(?string $courierUrl): void
    {
        $this->courierUrl = $courierUrl;
    }

    public function getCourierPhone(): ?string
    {
        return $this->courierPhone;
    }

    public function setCourierPhone(?string $courierPhone): void
    {
        $this->courierPhone = $courierPhone;
    }

    public function getCourierType(): ?string
    {
        return $this->courierType;
    }

    public function setCourierType(?string $courierType): void
    {
        $this->courierType = $courierType;
    }

    public function getTrackingRequiredFields(): ?array
    {
        return $this->trackingRequiredFields;
    }

    public function setTrackingRequiredFields(?array $trackingRequiredFields): void
    {
        $this->trackingRequiredFields = $trackingRequiredFields;
    }

    public function getOptionalFields(): ?array
    {
        return $this->optionalFields;
    }

    public function setOptionalFields(?array $optionalFields): void
    {
        $this->optionalFields = $optionalFields;
    }

    public function getDefaultLanguage(): ?string
    {
        return $this->defaultLanguage;
    }

    public function setDefaultLanguage(?string $defaultLanguage): void
    {
        $this->defaultLanguage = $defaultLanguage;
    }

    public function getSupportLanguage(): ?array
    {
        return $this->supportLanguage;
    }

    public function setSupportLanguage(?array $supportLanguage): void
    {
        $this->supportLanguage = $supportLanguage;
    }

    public function getCourierLogo(): ?string
    {
        return $this->courierLogo;
    }

    public function setCourierLogo(?string $courierLogo): void
    {
        $this->courierLogo = $courierLogo;
    }
}
